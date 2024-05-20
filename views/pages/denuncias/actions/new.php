
<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/denuncias.controller.php";

				$create = new DenunciasController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">	

				<label class="text-danger float-right"><sup>*</sup> Obligatorio</label>

				<!--=====================================
                Nombre del tramite
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Nombre<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,100}"
					onchange="validateRepeat(event,'text&number','products','name_product')"
					maxlength="50"
					name="nombre-noticia"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>


				<!--=====================================
		        Categoría tramite
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Categoria<sup class="text-danger">*</sup></label>

		            <?php 

		            $url = "categoriadenuncias?select=id_categoriadenuncia,nombre_categoriadenuncia";
		            $method = "GET";
		            $fields = array();

		            $categories = CurlController::request($url, $method, $fields)->results;

		            ?>

		            <div class="form-group">
		                
		                <select
		                class="form-control select2"
		                name="nombre-categorianotica"
		                style="width:100%"
		                onchange="changeCategory(event, 'products')"
		                required>

		                    <option value="">Seleccione Categoria</option>

		                    <?php foreach ($categories as $key => $value): ?>	

		                        <option value="<?php echo $value->id_categoriadenuncia ?>"><?php echo $value->nombre_categoriadenuncia ?></option>
		                      
		                    <?php endforeach ?>

		                </select>

		                <div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

		            </div>

		        </div>
				
		 		        
				<!--=====================================
                Imagen del tramite
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Imagen<sup class="text-danger">*</sup></label>
			
					<label for="customFileCover" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<img src="<?php echo TemplateController::srcImg() ?>views/img/default/default-cover.jpg" class="img-fluid changeCover">

						</figure>

					</label>

					<div class="custom-file">
						
						<input 
						type="file" 
						id="customFileCover" 
						class="custom-file-input"
						accept="image/*"
						onchange="validateImageJS(event,'changeCover')"
						name="cover-store"
						required>

						<div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

						<label for="customFileCover" class="custom-file-label">Choose file</label>

					</div>

				</div>
		        <!--=====================================
		        Contenido del tramite
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Contenido<sup class="text-danger">*</sup></label>

		            <textarea
		            class="summernote"
		            name="cuerpo-noticia"
		            required
		            ></textarea>

		            <div class="valid-feedback">Valid.</div>
		            <div class="invalid-feedback">Please fill out this field.</div>

		        </div>

		        <!--=====================================
                resumen del curso en 160 caracteres              
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Descripcion<sup class="text-danger">*</sup></label>
					<input 
					type="text" 
					class="form-control"
					pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,160}"
					onchange="validateRepeat(event,'text&number','products','name_product')"
					maxlength="160"
					name="resumen-noticia"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>
	      
			</div>
		
		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/denuncias" class="btn btn-light border text-left">Atras</a>
					
					<button type="submit" class="btn bg-dark float-right saveBtn">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>