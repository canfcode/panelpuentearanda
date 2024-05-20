<?php

class NegociosController{

	/*=============================================
	Creación de negocios
	=============================================*/	

	public function create(){

		if(isset($_POST["name-product"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}$/', $_POST["name-product"])&&



				preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["address-store"])&&

				//preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,100}$/', $_POST["mapa-negocio"])&&
				preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ :\/\.\:]{1,100}$/', $_POST["mapa-negocio"])&&

				/*preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email-store"])&&*/

				preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $_POST["email-store"])&&


				preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}$/', $_POST["about-store"] )

			){


				/*=============================================
				Proceso para configurar la galería ---logo
				=============================================*/		
				if(isset($_FILES["logo-store"]["tmp_name"]) && !empty($_FILES["logo-store"]["tmp_name"])){	

					$fields = array(
					
						"file"=>$_FILES["logo-store"]["tmp_name"],
						"type"=>$_FILES["logo-store"]["type"],
						"folder"=>"negocios/".$_POST["url-name_product"],
						"name"=>"logo",
						"width"=>270,
						"height"=>270
					);

					$saveImageProduct = CurlController::requestFile($fields);

				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Field logo error");

					</script>';

					return;
				}

			
					/*=============================================
					Validación Imagen galeria
					=============================================*/		
					$galleryProduct = array();
					$countGallery = 0;

				foreach (json_decode($_POST["gallery-product"],true) as $key => $value) {
					
					$countGallery++;

					$fields = array(
					
						"file"=>$value["file"],
						"type"=>$value["type"],
						"folder"=>"negocios/".$_POST["url-name_product"]."/galeria",
						"name"=>$_POST["url-name_product"]."_".mt_rand(100000000, 9999999999),
						"width"=>$value["width"],
						"height"=>$value["height"]
					);

					$saveImageGallery = CurlController::requestFile($fields);

					array_push($galleryProduct, $saveImageGallery);

				}

					/*=============================================
					Agrupamos el resumen
					=============================================*/		

					if(isset($_POST["inputSummary"])){

						$summaryProduct = array();
						

						for($i = 0; $i < $_POST["inputSummary"]; $i++){

							array_push($summaryProduct, trim($_POST["summary-product_".$i]));

						}

					}

					/* codigo cesar prueba validacion pagina web vacia */
					if(isset($_POST["pagina-web"]) && !empty($_POST["pagina-web"])){

					$pagina=$_POST["pagina-web"];
			
					}else{
					
					$pagina=null;
						

					}

			

				/*=============================================
				Agrupamos Redes Sociales
				=============================================*/	

				$socialNetwork = array();

				if(isset($_POST["facebook-store"]) && !empty($_POST["facebook-store"])){	

					array_push($socialNetwork, ["facebook"=> "https://facebook.com/".$_POST["facebook-store"]]);

				}

				if(isset($_POST["instagram-store"]) && !empty($_POST["instagram-store"])){	

					array_push($socialNetwork, ["instagram"=> "https://instagram.com/".$_POST["instagram-store"]]);

				}

				if(isset($_POST["twitter-store"]) && !empty($_POST["twitter-store"])){	

					array_push($socialNetwork, ["twitter"=> "https://twitter.com/".$_POST["twitter-store"]]);

				}

				if(isset($_POST["linkedin-store"]) && !empty($_POST["linkedin-store"])){	

					array_push($socialNetwork, ["linkedin"=> "https://linkedin.com/".$_POST["linkedin-store"]]);

				}

				if(isset($_POST["youtube-store"]) && !empty($_POST["youtube-store"])){	

					array_push($socialNetwork, ["youtube"=> "https://youtube.com/".$_POST["youtube-store"]]);

				}

				if(isset($_POST["tiktok-store"]) && !empty($_POST["tiktok-store"])){	

					array_push($socialNetwork, ["tiktok"=> "https://vt.tiktok.com/".$_POST["tiktok-store"]]);

				}


				if(count($socialNetwork) > 0){

					$socialNetwork = json_encode($socialNetwork);

				}else{

					$socialNetwork = null;
				}
	

					$data = array(
								
						"id_barrio_negocio" => $_POST["name-barrio"],
						"id_categorianegocio_negocio" => $_POST["name-category"],
						"nombre_negocio" => trim(TemplateController::capitalize($_POST["name-product"])),
						"url_negocio" => trim($_POST["url-name_product"]),
						"direccion_negocio" => trim($_POST["address-store"]),			
						"logo_negocio" => $saveImageProduct,
						"descripcion_negocio" => trim($_POST["about-store"]),
						"palabrasclave_negocio" => json_encode(explode(",",$_POST["tags-product"])),
						"servicios_negocio" => json_encode($summaryProduct),
						"banner_negocio" => json_encode($galleryProduct),
						"dirmapa_negocio" => trim($_POST["mapa-negocio"]),
						"correo_negocio" => trim(strtolower($_POST["email-store"])),
						"telefono_negocio" =>  trim($_POST["phone-store"]),
						"paginaweb_negocio" => $pagina,
						"redes_negocio" => $socialNetwork,
						"fecha_creacion_negocio" => date("Y-m-d")

					);

					/*=============================================
					Solicitud a la API
					=============================================*/		

					$url = "negocios?token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
								fncSweetAlert("success", "Negocio creado con exito", "/negocios");

							</script>';


					}else{

						echo '<script>

							//fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Error al guardar negocio");

						</script>';
									
					}

				}

			else{

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Field syntax error");

						</script>';
			
				}

			

			} // cierre inicial if

	} //cierra metodo

//}//cierra la clase
	
/*=============================================
	Edición negocio
=============================================*/
public function edit($id){


		if(isset($_POST["idProduct"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idProduct"]){

				$select = "*";

				$url = "negocios?select=".$select."&linkTo=id_negocio&equalTo=".$id;
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url,$method,$fields);

				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		
					if(preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["name-product"])&&
						  preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["address-store"])&&
						  preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["mapa-negocio"])&&
				          preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $_POST["email-store"])&&
				          preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}$/', $_POST["about-store"] )
					   
					){
						$galleryProduct = array();
						$countGallery = 0;
						$countGallery2 = 0;
						$continueEdit = false;

						if(!empty($_POST['gallery-product'])){	

							/*=============================================
							Proceso para configurar la galería
							=============================================*/		
							foreach (json_decode($_POST["gallery-product"],true) as $key => $value) {
								
								$countGallery++;

								$fields = array(
								
									"file"=>$value["file"],
									"type"=>$value["type"],
									"folder"=>"negocios/".$_POST["url-name_product"]."/galeria",
									"name"=>$_POST["url-name_product"]."_".mt_rand(100000000, 9999999999),
									"width"=>$value["width"],
									"height"=>$value["height"]
								);

								$saveImageGallery = CurlController::requestFile($fields);

								array_push($galleryProduct, $saveImageGallery);

								if($countGallery == count($galleryProduct)){

									if(!empty($_POST['gallery-product-old'])){

										foreach (json_decode($_POST['gallery-product-old'],true) as $key => $value) {

											$countGallery2++;
											array_push($galleryProduct, $value);
										}

										if(count(json_decode($_POST['gallery-product-old'],true)) == $countGallery2){

						  					$continueEdit = true;

						  				}

									}else{

										$continueEdit = true;

									}


								}

							}

						}else{

							if(!empty($_POST['gallery-product-old'])){

								$countGallery2 = 0;

								foreach (json_decode($_POST['gallery-product-old'],true) as $key => $value) {

									$countGallery2++;
									array_push($galleryProduct, $value);
								}

								if(count(json_decode($_POST['gallery-product-old'],true)) == $countGallery2){

				  					$continueEdit = true;

				  				}

							}

						}

						/*=============================================
			 			Eliminamos archivos basura del servidor
						=============================================*/

						if(!empty($_POST['delete-gallery-product'])){

							foreach (json_decode($_POST['delete-gallery-product'],true) as $key => $value) {

								$fields = array(
								
								 "deleteFile"=> "negocios/".$_POST["url-name_product"]."/galeria/".$value


								);

								$picture = CurlController::requestFile($fields);

							}

						}

						/*=============================================
			 			Validamos que no venga la galería vacía
						=============================================*/

						if(count($galleryProduct) == 0){

			  				echo '<script>

								fncFormatInputs();

								fncNotie(3, "The gallery cannot be empty");

							</script>';

							return;

			  			}

						if($continueEdit){

							/*=============================================
							Validación Imagen
							=============================================*/		

							if(isset($_FILES["logo-store"]["tmp_name"]) && !empty($_FILES["logo-store"]["tmp_name"])){	

								$fields = array(
								
									"file"=>$_FILES["logo-store"]["tmp_name"],
									"type"=>$_FILES["logo-store"]["type"],
									"folder"=>"negocios/".$_POST["url-name_product"],
									"name"=>"logo",
									"width"=>270,
									"height"=>270
								);

								$saveImageProduct = CurlController::requestFile($fields);

							}else{

								$saveImageProduct = $response->results[0]->image_product;
							}

							/*=============================================
							Agrupamos el resumen
							=============================================*/		

							if(isset($_POST["inputSummary"])){

								$summaryProduct = array();
								

								for($i = 0; $i < $_POST["inputSummary"]; $i++){

									array_push($summaryProduct, trim($_POST["summary-product_".$i]));

								}

							}

							/* validamos pagina web */

							if(isset($_POST["pagina-web"]) && !empty($_POST["pagina-web"])){

							$pagina=$_POST["pagina-web"];
			
							}else{
					
							$pagina=null;
						

							}

							/*=============================================
							Agrupamos Redes Sociales
							=============================================*/	

							$socialNetwork = array();

							if(isset($_POST["facebook-store"]) && !empty($_POST["facebook-store"])){	

								array_push($socialNetwork, ["facebook"=> "https://facebook.com/".$_POST["facebook-store"]]);

							}

							if(isset($_POST["instagram-store"]) && !empty($_POST["instagram-store"])){	

								array_push($socialNetwork, ["instagram"=> "https://instagram.com/".$_POST["instagram-store"]]);

							}

							if(isset($_POST["twitter-store"]) && !empty($_POST["twitter-store"])){	

								array_push($socialNetwork, ["twitter"=> "https://twitter.com/".$_POST["twitter-store"]]);

							}

							if(isset($_POST["linkedin-store"]) && !empty($_POST["linkedin-store"])){	

								array_push($socialNetwork, ["linkedin"=> "https://linkedin.com/".$_POST["linkedin-store"]]);

							}

							if(isset($_POST["youtube-store"]) && !empty($_POST["youtube-store"])){	

								array_push($socialNetwork, ["youtube"=> "https://youtube.com/".$_POST["youtube-store"]]);

							}

							if(isset($_POST["tiktok-store"]) && !empty($_POST["tiktok-store"])){	

								array_push($socialNetwork, ["tiktok"=> "https://vt.tiktok.com/".$_POST["tiktok-store"]]);

							}


							if(count($socialNetwork) > 0){

								$socialNetwork = json_encode($socialNetwork);

							}else{

								$socialNetwork = null;
							}
							

						   	/*=============================================
							Agrupamos la información 
							=============================================*/		

							$data = "id_barrio_negocio=".$_POST["name-barrio"].
							        "&id_categorianegocio_negocio=".$_POST["name-category"].	
									"&nombre_negocio=".trim(TemplateController::capitalize($_POST["name-product"])).
									"&url_negocio=".trim($_POST["url-name_product"]).
									"&direccion_negocio=".trim($_POST["address-store"]).
									"&logo_negocio=".$saveImageProduct.
									"&descripcion_negocio=".trim($_POST["about-store"]).
									"&palabrasclave_negocio=".json_encode(explode(",",$_POST["tags-product"])).
									"&servicios_negocio=".json_encode($summaryProduct).
									"&banner_negocio=".json_encode($galleryProduct).
									"&dirmapa_negocio=".trim($_POST["mapa-negocio"]).
									"&correo_negocio=".trim(strtolower($_POST["email-store"])).
									"&telefono_negocio=". trim($_POST["phone-store"]).
									"&paginaweb_negocio".$pagina.
									"&redes_negocio=".$socialNetwork;


							/*=============================================
							Solicitud a la API
							=============================================*/		

							$url = "negocios?id=".$id."&nameId=id_negocio&token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";
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
										fncSweetAlert("success", "Operacion exitosa", "/negocios");

									</script>';


							}else{

								echo '<script>

									//fncFormatInputs();
									matPreloader("off");
									fncSweetAlert("close", "", "");
									fncNotie(3, "Error editando negocio");

								</script>';

							}

						}
				

					}else{

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Error en el formulario");

						</script>';

						
					}

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
					fncNotie(3, "Error editando el registro");

				</script>';

				
			}
		}

	}


}//cierra clase

	
