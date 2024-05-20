<?php 
	
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "categorianegocios?select=".$select."&linkTo=id_categorianegocio&equalTo=".$security[0];;
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			
			if($response->status == 200){

				$category = $response->results[0];

			}else{

				echo '<script>

				window.location = "/catnegocios";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/catnegocios";

			</script>';
		

		}

	}


?>

<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $category->id_categorianegocio ?>" name="idCategory">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/catnegocios.controller.php";

				$create = new CategoriasnController();
				$create -> edit($category->id_categorianegocio);

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
					name="name-category"
					value="<?php echo $category->nombre_categorianegocio ?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

				

				<div class="form-group mt-2">
					
					<label>Icono categoria</label>
			
					<label for="customFile" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<img src="<?php echo TemplateController::srcImg() ?>views/img/categorias/<?php echo $category->icono_categorianegocio ?>" class="img-fluid changePicture" style="width:150px">

						</figure>

					</label>

					<div class="custom-file">
						
						<input 
						type="file" 
						id="customFile" 
						class="custom-file-input"
						accept="image/*"
						onchange="validateImageJS(event,'changePicture')"
						name="image-category">

						<div class="valid-feedback">Correcto.</div>
            			<div class="invalid-feedback">Error en el campo.</div>

						<label for="customFile" class="custom-file-label">Buscar Imagen</label>

					</div>

				</div>

			</div>
		

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="categories" class="btn btn-light border text-left">Atras</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>