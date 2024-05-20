<?php

class NoticiasController{

	/*=============================================
	Creación tiendas
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

							
							//$nomnoticia = str_replace(" ", "-",$_POST["nombre-noticia"] );
						$nomnoticia=TemplateController::rutasimg($_POST["nombre-noticia"]);
							
							$fields = array(
							
								"file"=>$_FILES["cover-store"]["tmp_name"],
								"type"=>$_FILES["cover-store"]["type"],
								"folder"=>"noticias/".$nomnoticia,
								"name"=>"cover",
								"width"=>570,
								"height"=>210
							);

							$saveImageCover = CurlController::requestFile($fields);

							

						}else{

							$saveImageCover = $response->results[0]->cover_store;
						}
	
			   	/*=============================================
				Agrupamos la información 
				=============================================*/		

				$data = array(

					"id_categorianoticia_noticia" => $_POST["nombre-categorianotica"],

					"titulo_noticia" => trim(TemplateController::capitalize($_POST["nombre-noticia"])),
					
					"resumen_noticia" => trim($_POST["resumen-noticia"]),
					
					"cuerpo_noticia" => trim(TemplateController::htmlClean($_POST["cuerpo-noticia"])),
										
					"imagen_noticia" => $saveImageCover,
					
					"fecha_creacion_noticia" => date("Y-m-d")

				);

				
				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "noticias?token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
							fncSweetAlert("success", "Noticia creada correctamente", "/noticias");

						</script>';


				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error guardando la noticia");

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
	
		if(isset($_POST["idNoticia"])){
					
			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';


			if($id == $_POST["idNoticia"]){
				
				//$select = "imagen_noticia";
				$select = "*";

				$url = "noticias?select=".$select."&linkTo=id_noticia&equalTo=".$id;

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

							
							//$nomnoticia = str_replace(" ", "-",$_POST["nombre-noticia"] );
							$nomnoticia=TemplateController::rutasimg($_POST["nombre-noticia"]);
							
							$fields = array(
							
								"file"=>$_FILES["cover-store"]["tmp_name"],
								"type"=>$_FILES["cover-store"]["type"],
								"folder"=>"noticias/".$nomnoticia,
								"name"=>"cover",
								"width"=>570,
								"height"=>210
							);

							$saveImageCover = CurlController::requestFile($fields);

							

						}else{

							$saveImageCover = $response->results[0]->cover_store;
						}
					   	/*=============================================
						Agrupamos la información 
						=============================================*/	


						$data ="id_categorianoticia_noticia=".$_POST["nombre-categorianotica"].
						       "&titulo_noticia=".trim(TemplateController::capitalize($_POST["nombre-noticia"])).
						       "&cuerpo_noticia=".urlencode(trim(TemplateController::htmlClean($_POST["cuerpo-noticia"]))).
						       "&resumen_noticia=".trim($_POST["resumen-noticia"]).
						       "&imagen_noticia=".$saveImageCover.
						       "&fecha_actualizacion_noticia=".date("Y-m-d");
						       


						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "noticias?id=".$id."&nameId=id_noticia&token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";


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
								fncSweetAlert("success", "Campos actualizados correctamente", "/noticias");

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
