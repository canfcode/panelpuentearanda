<?php 
	
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "barrios?select=".$select."&linkTo=id_barrio&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			

			if($response->status == 200){

				$barrio = $response->results[0];

			}else{

				echo '<script>

				window.location = "/barrios";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/barrios";

			</script>';
		

		}

	}


?>

<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $barrio->id_barrio ?>" name="idBarrio">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/barrios.controller.php";

				$create = new BarriosController();
				$create -> edit($barrio->id_barrio);

			?>
			
			<div class="col-md-8 offset-md-2">	

				<!--=====================================
                Nombre zona
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Nombre</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}"
					maxlength="50"
					onchange="validateJS(event,'text&number')"
					name="zona"
					value="<?php echo $barrio->nombre_barrio ?>"
					required>

					<div class="valid-feedback">Correcto.</div>
            		<div class="invalid-feedback">Datos invalidos.</div>

				</div>

               			
			</div>
		

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/barrios" class="btn btn-light border text-left">Atras</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>