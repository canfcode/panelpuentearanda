<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/cattramites.controller.php";

				$create = new CategoriastraController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">	

				<!--=====================================
                Nombre de categoría tramite
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Nombre categoria</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateRepeat(event,'text','categorianegocios','nombre_categoriadenuncia')"
					name="nombre_categoria"
					required>

					<div class="valid-feedback">correcto.</div>
            		<div class="invalid-feedback">Error en el campo.</div>

				</div>


				<!--=====================================
                descripcion categoria tramite
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
					name="descripcion-tramite"
					required></textarea>

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