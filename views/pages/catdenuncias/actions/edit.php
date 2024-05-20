<?php 
	
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "categoriadenuncias?select=".$select."&linkTo=id_categoriadenuncia&equalTo=".$security[0];;
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			
			if($response->status == 200){

				$category = $response->results[0];

			}else{

				echo '<script>

				window.location = "/catdenuncias";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/catdenuncias";

			</script>';
		

		}

	}


?>

<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $category->id_categoriadenuncia ?>" name="idCategory">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/catdenuncias.controller.php";

				$create = new CategoriasdenController();
				$create -> edit($category->id_categoriadenuncia);

			?>
			
			<div class="col-md-8 offset-md-2">	

				<!--=====================================
                Nombre de categoría
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Nombre</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="nombre-categoria"
					value="<?php echo $category->nombre_categoriadenuncia ?>"
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
					name="descripcion-denuncia"
					required><?php echo $category->descripcion_categoriadenuncia ?></textarea>
					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

			</div>
		

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/catdenuncias" class="btn btn-light border text-left">Atras</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>