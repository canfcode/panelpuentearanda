<?php

class BarriosController{

	/*=============================================
	Creación zonas o barrios
	=============================================*/	

	public function create(){

		if(isset($_POST["zona"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,150}$/', $_POST["zona"] )){


			   	/*=============================================
				Agrupamos la información 
				=============================================*/		

				$data = array(	
				
					"nombre_barrio" => trim(TemplateController::capitalize($_POST["zona"])),
					"fecha_creacion_barrio" => date("Y-m-d")

				);
				
				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "barrios?token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";

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
							fncSweetAlert("success", "Zona creada correctamente", "/barrios");

						</script>';


				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error guardando la informacion");

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
	Edición Barrio
	=============================================*/	

	public function edit($id){

		if(isset($_POST["idBarrio"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idBarrio"]){

				$select = "nombre_barrio";

				$url = "barrios?select=".$select."&linkTo=id_barrio&equalTo=".$id;
				$method = "GET";
				$fields = array();
				
				$response = CurlController::request($url,$method,$fields);

				if($response->status == 200){

					if(preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,150}$/', $_POST["zona"] )){

					   	/*=============================================
						Agrupamos la información 
						=============================================*/		

						$data = "nombre_barrio=".trim(TemplateController::capitalize($_POST["zona"]));

						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "barrios?id=".$id."&nameId=id_barrio&token=".$_SESSION["admin"]->token_user."&table=usuarios&suffix=user";

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
								fncSweetAlert("success", "Datos actualizados", "/barrios");

							</script>';
	
						}else{

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncNotie(3, "Error al editar registro");

							</script>';
							
						}

					}else{

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "error de sintaxis en los campos");

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

}

