<?php

class TramitesController{

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

							$nomnoticia=TemplateController::rutasimg($_POST["nombre-noticia"]);
							
							$fields = array(
							
								"file"=>$_FILES["cover-store"]["tmp_name"],
								"type"=>$_FILES["cover-store"]["type"],
								"folder"=>"tramites/".$nomnoticia,
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

					"id_categoriatramite_tramite" => $_POST["nombre-categorianotica"],

					"nombre_tramite" => trim(TemplateController::capitalize($_POST["nombre-noticia"])),
					
					"descripcion_tramite" => trim($_POST["resumen-noticia"]),
					
					"contenido_tramite" => trim(TemplateController::htmlClean($_POST["cuerpo-noticia"])),
										
					"imagen_tramite" => $saveImageCover,
					
					"fecha_creacion_tramite" => date("Y-m-d")

				);

				
				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "tramites?token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
							fncSweetAlert("success", "tramite creado correctamente", "/tramites");

						</script>';


				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error guardando el tramite");

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
	
		if(isset($_POST["idTramite"])){
					
			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';


			if($id == $_POST["idTramite"]){

				$select = "*";

				$url = "tramites?select=".$select."&linkTo=id_tramite&equalTo=".$id;

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

							$nomnoticia=TemplateController::rutasimg($_POST["nombre-noticia"]);
							
							$fields = array(
							
								"file"=>$_FILES["cover-store"]["tmp_name"],
								"type"=>$_FILES["cover-store"]["type"],
								"folder"=>"tramites/".$nomnoticia,
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


						$data ="id_categoriatramite_tramite=".$_POST["nombre-categorianotica"].
						       "&nombre_tramite=".trim(TemplateController::capitalize($_POST["nombre-noticia"])).
						       "&contenido_tramite=".urlencode(trim(TemplateController::htmlClean($_POST["cuerpo-noticia"]))).
						       "&descripcion_tramite=".trim($_POST["resumen-noticia"]).
						       "&imagen_tramite=".$saveImageCover.
						       "&fecha_actualizacion_tramite=".date("Y-m-d");
						       


						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "tramites?id=".$id."&nameId=id_tramite&token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";

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
								fncSweetAlert("success", "Campos actualizados correctamente", "/tramites");

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