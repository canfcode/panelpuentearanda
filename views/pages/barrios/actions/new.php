<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate>
	
		<div class="card-header">

			<?php

			 	require_once "controllers/barrios.controller.php";

				$create = new BarriosController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">	

				<!--=====================================
                Nombre de subcategoría
                ======================================-->
				
					<div class="form-group mt-5">
					
					<label>Nombre Zona</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="zona"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

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