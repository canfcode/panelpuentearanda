<?php

class DenunciasController{

	/*=============================================
	Creación tramite
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
							//$nomnoticia = str_replace(" ", "-",$_POST["nombre-noticia"] );
							$nomnoticia=TemplateController::rutasimg($_POST["nombre-noticia"]);
							
							$fields = array(
							
								"file"=>$_FILES["cover-store"]["tmp_name"],
								"type"=>$_FILES["cover-store"]["type"],
								"folder"=>"denuncias/".$nomnoticia,
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

					"id_categoriadenuncia_denuncia" => $_POST["nombre-categorianotica"],

					"nombre_denuncia" => trim(TemplateController::capitalize($_POST["nombre-noticia"])),
					
					"descripcion_denuncia" => trim($_POST["resumen-noticia"]),
					
					"contenido_denuncia" => trim(TemplateController::htmlClean($_POST["cuerpo-noticia"])),
										
					"imagen_denuncia" => $saveImageCover,
					
					"fecha_creacion_denuncia" => date("Y-m-d")

				);

				
				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "denuncias?token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
							fncSweetAlert("success", "creado correctamente", "/denuncias");

						</script>';


				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error guardando");

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
	Edición tramite
	=============================================*/	
public function edit($id){
	
		if(isset($_POST["idDenuncia"])){
					
			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';


			if($id == $_POST["idDenuncia"]){
				
				//$select = "imagen_noticia";
				$select = "*";

				$url = "denuncias?select=".$select."&linkTo=id_denuncia&equalTo=".$id;

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
							//$nomnoticia = str_replace(" ", "-",$_POST["nombre-noticia"] );
							$nomnoticia=TemplateController::rutasimg($_POST["nombre-noticia"]);
							$fields = array(
							
								"file"=>$_FILES["cover-store"]["tmp_name"],
								"type"=>$_FILES["cover-store"]["type"],
								"folder"=>"denuncias/".$nomnoticia,
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


						$data ="id_categoriadenuncia_denuncia=".$_POST["nombre-categorianotica"].
						       "&nombre_denuncia=".trim(TemplateController::capitalize($_POST["nombre-noticia"])).
						       "&contenido_denuncia=".urlencode(trim(TemplateController::htmlClean($_POST["cuerpo-noticia"]))).
						       "&descripcion_denuncia=".trim($_POST["resumen-noticia"]).
						       "&imagen_denuncia=".$saveImageCover.
						       "&fecha_actualizacion_denuncia=".date("Y-m-d");
						       


						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "denuncias?id=".$id."&nameId=id_denuncia&token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";


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
								fncSweetAlert("success", "Campos actualizados correctamente", "/denuncias");

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