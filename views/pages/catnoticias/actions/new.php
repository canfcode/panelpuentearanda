<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/catnoticias.controller.php";

				$create = new CategoriasnotiController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">	

				<!--=====================================
                Nombre de categoría
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Nombre categoria</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateRepeat(event,'text','categorianegocios','nombre_categorianegocio')"
					name="name-category"
					required>

					<div class="valid-feedback">correcto.</div>
            		<div class="invalid-feedback">Error en el campo.</div>

				</div>


				<!--=====================================
                descripcion categoria noticia
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Descripcion <sup class="text-danger">*</sup></label>

					<textarea 
					rows="7"
					type="text" 
					class="form-control"
					pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}"
					onchange="validateJS(event,'regex')"
					maxlength="500"
					name="about-store"
					required></textarea>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>
				<!--=====================================
                Icono de categoría
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Icono categoria</label>
			
					<label for="customFile" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<img src="views/assets/img/categorias/default.jpg" class="img-fluid changePicture" style="width:150px">

						</figure>

					</label>

					<div class="custom-file">
						
						<input 
						type="file" 
						id="customFile" 
						class="custom-file-input"
						accept="image/*"
						onchange="validateImageJS(event,'changePicture')"
						name="image-category"
						required>

						<div class="valid-feedback">Correcto.</div>
            			<div class="invalid-feedback">Error en el campo.</div>

						<label for="customFile" class="custom-file-label">Buscar imagen</label>

					</div>

				</div>

			</div>
		

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/catnoticias" class="btn btn-light border text-left">Atras</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>