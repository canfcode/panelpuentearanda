<?php

class CursosController{

	/*=============================================
	Creación cursos
	=============================================*/	

	public function create(){

		if(isset($_POST["nombre-noticia"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,100}$/', $_POST["nombre-noticia"] ) && 

			  preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,180}$/', $_POST["resumen-noticia"] )

			
			){
			
				/*=============================================
				Validación Portada noticia
				=============================================*/		

				
						if(isset($_FILES["cover-store"]["tmp_name"]) && !empty($_FILES["cover-store"]["tmp_name"])){	

							//quitar espacion en el nombre caperta creada con el nombre de la noticia
							$nomnoticia = str_replace(" ", "-",$_POST["nombre-noticia"] );
							
							$fields = array(
							
								"file"=>$_FILES["cover-store"]["tmp_name"],
								"type"=>$_FILES["cover-store"]["type"],
								"folder"=>"cursos/".$nomnoticia,
								"name"=>"cover",
								"width"=>1024,
								"height"=>768
							);

							$saveImageCover = CurlController::requestFile($fields);

							

						}else{

							$saveImageCover = $response->results[0]->cover_store;
						}
	
			   	/*=============================================
				Agrupamos la información 
				=============================================*/		

				$data = array(

					"id_categoriacurso_curso" => $_POST["nombre-categorianotica"],

					"nombre_curso" => trim(TemplateController::capitalize($_POST["nombre-noticia"])),
					
					"descripcion_curso" => trim($_POST["resumen-noticia"]),
					
					"contenido_curso" => trim(TemplateController::htmlClean($_POST["cuerpo-noticia"])),
										
					"imagen_curso" => $saveImageCover,
					
					"fecha_creacion_curso" => date("Y-m-d")

				);

				
				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "cursos?token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
				$method = "POST";
				$fields = $data;

				$response = CurlController::request($url,$method,$fields);

				/*=============================================
				Respuesta de la API
				=============================================*/		
				
				if($response->status == 200){

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncSweetAlert("success", "curso creado correctamente", "/cursos");

						</script>';


				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error guardando el curso");

					</script>';

				}
		

			}else{

				echo '<script>

					fncFormatInputs();
					matPreloader("off");
					fncSweetAlert("close", "", "");
					fncNotie(3, "Field syntax error");

				</script>';

				
			}
		}

	}

	/*=============================================
	Edición noticias
	=============================================*/	
public function edit($id){
	
		if(isset($_POST["idCurso"])){
					
			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';


			if($id == $_POST["idCurso"]){
				
				//$select = "imagen_noticia";
				$select = "*";

				$url = "cursos?select=".$select."&linkTo=id_curso&equalTo=".$id;

				$method = "GET";
				$fields = array();

				$response = CurlController::request($url,$method,$fields);
				
				

				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/	

					if(preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,100}$/', $_POST["nombre-noticia"] ) && 

			  			preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,180}$/', $_POST["resumen-noticia"] )

			
			){

						/*=============================================
						Validar cambio imagen
						=============================================*/	

						if(isset($_FILES["cover-store"]["tmp_name"]) && !empty($_FILES["cover-store"]["tmp_name"])){	

							//quitar espacion en el nombre caperta creada con el nombre de la noticia
							$nomnoticia = str_replace(" ", "-",$_POST["nombre-noticia"] );
							
							$fields = array(
							
								"file"=>$_FILES["cover-store"]["tmp_name"],
								"type"=>$_FILES["cover-store"]["type"],
								"folder"=>"noticias/".$nomnoticia,
								"name"=>"cover",
								"width"=>1024,
								"height"=>720
							);

							$saveImageCover = CurlController::requestFile($fields);

							

						}else{

							$saveImageCover = $response->results[0]->cover_store;
						}
					   	/*=============================================
						Agrupamos la información 
						=============================================*/	


						$data ="id_categoriacurso_curso=".$_POST["nombre-categorianotica"].
						       "&nombre_curso=".trim(TemplateController::capitalize($_POST["nombre-noticia"])).
						       "&contenido_curso=".urlencode(trim(TemplateController::htmlClean($_POST["cuerpo-noticia"]))).
						       "&descripcion_curso=".trim($_POST["resumen-noticia"]).
						       "&imagen_curso=".$saveImageCover.
						       "&fecha_actualizacion_curso=".date("Y-m-d");
						       


						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "cursos?id=".$id."&nameId=id_curso&token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";


							$method = "PUT";
							$fields = $data;

							
							$response = CurlController::request($url,$method,$fields);

							

						/*=============================================
						Respuesta de la API
						=============================================*/		
						
						if($response->status == 200){		

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncSweetAlert("success", "Campos actualizados correctamente", "/cursos");

							</script>';
	
						}else{

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncNotie(3, "Error editando el registro");

							</script>';
							
						}

					}else{

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "revise la sintaxis de los campos");

						</script>';
						
					}

				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error editing the registry");

					</script>';

					
				}

			}else{

				echo '<script>

					fncFormatInputs();
					matPreloader("off");
					fncSweetAlert("close", "", "");
					fncNotie(3, "Error editing the registry");

				</script>';

				
			}
		}

	}
	

}