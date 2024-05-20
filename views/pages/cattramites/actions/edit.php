<?php 
	
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "categoriatramites?select=".$select."&linkTo=id_categoriatramite&equalTo=".$security[0];;
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			
			if($response->status == 200){

				$category = $response->results[0];

			}else{

				echo '<script>

				window.location = "/cattramites";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/cattramites";

			</script>';
		

		}

	}


?>

<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $category->id_categoriatramite ?>" name="idCategory">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/cattramites.controller.php";

				$create = new CategoriastraController();
				$create -> edit($category->id_categoriatramite);

			?>
			
			<div class="col-md-8 offset-md-2">	

				<!--=====================================
                Nombre de categoría
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Name</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="nombre-categoria"
					value="<?php echo $category->nombre_categoriatramite ?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

			
				<div class="form-group mt-5">
					
					<label>Descripcion <sup class="text-danger">*</sup></label>

					<textarea 
					rows="7"
					type="text" 
					class="form-control"
					pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,180}"
					onchange="validateJS(event,'regex')"
					maxlength="180"
					name="descripcion-tramite"
					required><?php echo $category->descripcion_categoriatramite ?></textarea>
					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

			</div>
		

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/cattramites" class="btn btn-light border text-left">Atras</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>