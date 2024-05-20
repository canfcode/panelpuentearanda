<?php 
	
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "relations?rel=denuncias,categoriadenuncias&type=denuncia,categoriadenuncia&select=".$select."&linkTo=id_denuncia&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
	
			if($response->status == 200){

				$datacurso = $response->results[0];

			}else{

				echo '<script>

				window.location = "/denuncias";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/denuncias";

			</script>';
		

		}

	}


?>



<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
		
		<input type="hidden" value="<?php echo $datacurso->id_denuncia ?>" name="idDenuncia">

		<div class="card-header">

			<?php

			 	require_once "controllers/denuncias.controller.php";

				$create = new DenunciasController();
				$create -> edit($datacurso->id_denuncia);
				

			?>
			
			<div class="col-md-8 offset-md-2">	

				<label class="text-danger float-right"><sup>*</sup> Obligatorio</label>

				<!--=====================================
                Nombre de la denuncia
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Nombre<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					readonly
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,100}"
					onchange="validateRepeat(event,'text&number','products','name_product')"
					maxlength="50"
					name="nombre-noticia"
					value="<?php echo $datacurso->nombre_denuncia?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>


				<!--=====================================
		        Categoría denuncia
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
		                
		                required>

		                    <option value=""><?php echo $datacurso->nombre_categoriadenuncia ?></option>

		                    <?php foreach ($categories as $key => $value): ?>	

		                        <option value="<?php echo $value->id_categoriadenuncia ?>"><?php echo $value->nombre_categoriadenuncia?></option>
		                      
		                    <?php endforeach ?>

		                </select>

		                <div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

		            </div>

		        </div>
				
		 		        
				<!--=====================================
                Imagen de portada denuncia
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Imagen Curso<sup class="text-danger">*</sup></label>
			
					<label for="customFileCover" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<?php $rutaimg = strtr($datacurso->nombre_denuncia, " ", "-"); ?>

							<img src="<?php echo TemplateController::srcImg() ?>views/img/denuncias/<?php echo $rutaimg ?>/<?php echo $datacurso->imagen_denuncia ?>" class="img-fluid changeCover">

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
		        Cuerpo de la Noticia 
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Contenido de la denuncia<sup class="text-danger">*</sup></label>

		            <textarea
		            class="summernote"
		            name="cuerpo-noticia"
		            required
		            ><?php echo $datacurso->contenido_denuncia?></textarea>

		            <div class="valid-feedback">Valid.</div>
		            <div class="invalid-feedback">Please fill out this field.</div>

		        </div>

		        <!--=====================================
                resumern de la noticia en 160 caracteres                ======================================-->

                <div class="form-group mt-2">
					
					<label>Descripcion<sup class="text-danger">*</sup></label>
					<input 
					type="text" 
					class="form-control"
					pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,180}"
					onchange="validateRepeat(event,'text&number','products','name_product')"
					maxlength="180"
					name="resumen-noticia"
					value="<?php echo $datacurso->descripcion_denuncia?>"
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