<?php

class CategoriasnController{

	/*=============================================
	Creación categorías
	=============================================*/	

	public function create(){

		if(isset($_POST["name-category"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name-category"] )){
			    
				$nomimgcatnego = str_replace(" ", "-",$_POST["name-category"] );
				
				if(isset($_FILES["image-category"]["tmp_name"]) && !empty($_FILES["image-category"]["tmp_name"])){	

					$fields = array(
					
						"file"=>$_FILES["image-category"]["tmp_name"],
						"type"=>$_FILES["image-category"]["type"],
						"folder"=>"categorias/".$nomimgcatnego,
						"name"=>$nomimgcatnego,
						"width"=>170,
						"height"=>170
					);

					$saveImageCategory = CurlController::requestFile($fields);

					

				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Field image error");

					</script>';

					return;
				}

			   	/*=============================================
				Agrupamos la información 
				=============================================*/		

				$data = array(
				
				
					"nombre_categorianegocio" => trim(TemplateController::capitalize($_POST["name-category"])),
					"icono_categorianegocio" => $saveImageCategory,
					"fecha_creacion_categorianegocio" => date("Y-m-d")

				);

				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "categorianegocios?token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
							fncSweetAlert("success", "Operacion exitosa", "/catnegocios");

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

				$select = "icono_categorianegocio";

				$url = "categorianegocios?select=".$select."&linkTo=id_categorianegocio&equalTo=".$id;
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url,$method,$fields);

				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		
					if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name-category"] )){

						/*=============================================
						Validar cambio imagen
						=============================================*/	
						$nomimgcatnego = str_replace(" ", "-",$_POST["name-category"] );
						
						if(isset($_FILES["image-category"]["tmp_name"]) && !empty($_FILES["image-category"]["tmp_name"])){		
								$fields = array(
								
							"file"=>$_FILES["image-category"]["tmp_name"],
							"type"=>$_FILES["image-category"]["type"],
							"folder"=>"categorias/".$nomimgcatnego,
							"name"=>$nomimgcatnego,
							"width"=>170,
							"height"=>170
								);

								$saveImageCategory = CurlController::requestFile($fields);

						}else{

							$saveImageCategory = $response->results[0]->icono_categorianegocio;

						}

					   	/*=============================================
						Agrupamos la información 
						=============================================*/	

						$data = "nombre_categorianegocio=".trim(TemplateController::capitalize($_POST["name-category"]))."&icono_categorianegocio=".$saveImageCategory;


						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "categorianegocios?id=".$id."&nameId=id_categorianegocio&token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
								fncSweetAlert("success", "Campos actualizados correctamente", "/catnegocios");

							</script>';
	
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

