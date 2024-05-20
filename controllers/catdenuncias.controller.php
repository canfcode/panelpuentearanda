<?php

class CategoriasdenController{

	/*=============================================
	Creación categorías
	=============================================*/	

	public function create(){

		if(isset($_POST["nombre_categoria"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["nombre_categoria"] )&&
			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}$/', $_POST["descripcion-denuncia"] ) 
				){


			   	/*=============================================
				Agrupamos la información 
				=============================================*/		

				$data = array(
				
				
					"nombre_categoriadenuncia" => trim(TemplateController::capitalize($_POST["nombre_categoria"])),
					"descripcion_categoriadenuncia" => trim($_POST["descripcion-denuncia"]),
					"fecha_creacion_categoriadenuncia" => date("Y-m-d")

				);
				
				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "categoriadenuncias?token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
							fncSweetAlert("success", "Operacion exitosa", "/catdenuncias");

						</script>';


				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error creando la categoria");

					</script>';

				}
		

			}else{

				echo '<script>

					fncFormatInputs();
					matPreloader("off");
					fncSweetAlert("close", "", "");
					fncNotie(3, "error de sintaxis");

				</script>';

				
			}
		}

	}

	/*=============================================
	Edición Categoría
	=============================================*/	

	
	public function edit($id){

		if(isset($_POST["idCategory"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idCategory"]){

				$select = "id_categoriadenuncia";

				$url = "categoriadenuncias?select=".$select."&linkTo=id_categoriadenuncia&equalTo=".$id;
				$method = "GET";
				$fields = array();
			
				$response = CurlController::request($url,$method,$fields);	
					

				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		
					if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["nombre-categoria"] )&&
			  		   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,180}$/', $_POST["descripcion-denuncia"])){

					   	/*=============================================
						Agrupamos la información 
						=============================================*/	
							
						$data = "nombre_categoriadenuncia=".trim(TemplateController::capitalize($_POST["nombre-categoria"])).
								 "&descripcion_categoriadenuncia=".trim($_POST["descripcion-denuncia"]).
								 "&fecha_actualizacion_categoriadenuncia=".date("Y-m-d");
						
					
						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "categoriadenuncias?id=".$id."&nameId=id_categoriadenuncia&token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
								fncSweetAlert("success", "Campos actualizados correctamente", "/catdenuncias");

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
							fncNotie(3, "Field syntax error");

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
