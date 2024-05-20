<?php 
	
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "relations?rel=noticias,categorianoticias&type=noticia,categorianoticia&select=".$select."&linkTo=id_noticia&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
	
			if($response->status == 200){

				$datanoticia = $response->results[0];

			}else{

				echo '<script>

				window.location = "/noticias";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/noticias";

			</script>';
		

		}

	}


?>



<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
		
		<input type="hidden" value="<?php echo $datanoticia->id_noticia ?>" name="idNoticia">

		<div class="card-header">

			<?php

			 	require_once "controllers/noticias.controller.php";

				$create = new NoticiasController();
				$create -> edit($datanoticia->id_noticia);
				

			?>
			
			<div class="col-md-8 offset-md-2">	

				<label class="text-danger float-right"><sup>*</sup> Obligatorio</label>

				<!--=====================================
                Nombre de la ticia
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Titulo Noticia <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					readonly
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,100}"
					onchange="validateRepeat(event,'text&number','products','name_product')"
					maxlength="50"
					name="nombre-noticia"
					value="<?php echo $datanoticia->titulo_noticia?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>


				<!--=====================================
		        Categoría noticia
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Categoria Noticia<sup class="text-danger">*</sup></label>

		            <?php 

		            $url = "categorianoticias?select=id_categorianoticia,nombre_categorianoticia";
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

		                    <option value=""><?php echo $datanoticia->nombre_categorianoticia ?></option>

		                    <?php foreach ($categories as $key => $value): ?>	

		                        <option value="<?php echo $value->id_categorianoticia ?>"><?php echo $value->nombre_categorianoticia ?></option>
		                      
		                    <?php endforeach ?>

		                </select>

		                <div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

		            </div>

		        </div>
				
		 		        
				<!--=====================================
                Imagen de portada noticia
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Imagen portada<sup class="text-danger">*</sup></label>
			
					<label for="customFileCover" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<?php $rutaimg = strtr($datanoticia->titulo_noticia, " ", "-"); ?>

							<img src="<?php echo TemplateController::srcImg() ?>views/img/noticias/<?php echo $rutaimg ?>/<?php echo $datanoticia->imagen_noticia ?>" class="img-fluid changeCover">

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
		            
		            <label>Cuerpo de la noticia<sup class="text-danger">*</sup></label>

		            <textarea
		            class="summernote"
		            name="cuerpo-noticia"
		            required
		            ><?php echo $datanoticia->cuerpo_noticia?></textarea>

		            <div class="valid-feedback">Valid.</div>
		            <div class="invalid-feedback">Please fill out this field.</div>

		        </div>

		        <!--=====================================
                resumern de la noticia en 160 caracteres                ======================================-->

                <div class="form-group mt-2">
					
					<label>Resumen de la notica<sup class="text-danger">*</sup></label>
					<input 
					type="text" 
					class="form-control"
					pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,180}"
					onchange="validateRepeat(event,'text&number','products','name_product')"
					maxlength="180"
					name="resumen-noticia"
					value="<?php echo $datanoticia->resumen_noticia?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>
	      
			</div>
		
		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/admins" class="btn btn-light border text-left">Atras</a>
					
					<button type="submit" class="btn bg-dark float-right saveBtn">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>