<?php

class CategoriasnotiController{

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

			if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name-category"] )&&
			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}$/', $_POST["about-store"] ) 
				){

				
				if(isset($_FILES["image-category"]["tmp_name"]) && !empty($_FILES["image-category"]["tmp_name"])){	
					// quitar espaciones en nombre de la imgen
					$nomimgcatnoti = str_replace(" ", "-",$_POST["name-category"] );

					$fields = array(
					
						"file"=>$_FILES["image-category"]["tmp_name"],
						"type"=>$_FILES["image-category"]["type"],
						"folder"=>"categorianoticia/".$nomimgcatnoti,
						"name"=>$nomimgcatnoti,
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
				
				
					"nombre_categorianoticia" => trim(TemplateController::capitalize($_POST["name-category"])),
					"descripcion_categorianoticia" => trim($_POST["about-store"]),
					"icono_categorianoticia" => $saveImageCategory,
					"fecha_creacion_categorianoticia" => date("Y-m-d")

				);

				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "categorianoticias?token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
							fncSweetAlert("success", "Operacion exitosa", "/catnoticias");

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

				$select = "icono_categorianoticia";

				$url = "categorianoticias?select=".$select."&linkTo=id_categorianoticia&equalTo=".$id;
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
							$nomimgcatnoti = str_replace(" ", "-",$_POST["name-category"] );
						if(isset($_FILES["image-category"]["tmp_name"]) && !empty($_FILES["image-category"]["tmp_name"])){		
								$fields = array(
								
									"file"=>$_FILES["image-category"]["tmp_name"],
									"type"=>$_FILES["image-category"]["type"],
									"folder"=>"categorianoticia/".$nomimgcatnoti,
									"name"=>$_POST["name-category"],
									"width"=>170,
									"height"=>170
								);

								$saveImageCategory = CurlController::requestFile($fields);

								

						}else{

							$saveImageCategory = $response->results[0]->icono_categorianoticia;

						}

					   	/*=============================================
						Agrupamos la información 
						=============================================*/	

						$data = "nombre_categorianoticia=".trim(TemplateController::capitalize($_POST["name-category"]))."&icono_categorianoticia=".$saveImageCategory;


						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "categorianoticias?id=".$id."&nameId=id_categorianoticia&token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
								fncSweetAlert("success", "Campos actualizados correctamente", "/catnoticias");

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

