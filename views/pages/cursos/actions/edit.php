<?php 
	
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "relations?rel=cursos,categoriacursos&type=curso,categoriacurso&select=".$select."&linkTo=id_curso&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
	
			if($response->status == 200){

				$datacurso = $response->results[0];

			}else{

				echo '<script>

				window.location = "/cursos";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/cursos";

			</script>';
		

		}

	}


?>



<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
		
		<input type="hidden" value="<?php echo $datacurso->id_curso ?>" name="idCurso">

		<div class="card-header">

			<?php

			 	require_once "controllers/cursos.controller.php";

				$create = new CursosController();
				$create -> edit($datacurso->id_curso);
				

			?>
			
			<div class="col-md-8 offset-md-2">	

				<label class="text-danger float-right"><sup>*</sup> Obligatorio</label>

				<!--=====================================
                Nombre de la ticia
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Nombre Curso<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					readonly
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,100}"
					onchange="validateRepeat(event,'text&number','products','name_product')"
					maxlength="50"
					name="nombre-noticia"
					value="<?php echo $datacurso->nombre_curso?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>


				<!--=====================================
		        Categoría noticia
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Categoria Curso<sup class="text-danger">*</sup></label>

		            <?php 

		            $url = "categoriacursos?select=id_categoriacurso,nombre_categoriacurso";
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

		                    <option value=""><?php echo $datacurso->nombre_categoriacurso ?></option>

		                    <?php foreach ($categories as $key => $value): ?>	

		                        <option value="<?php echo $value->id_categoriacurso ?>"><?php echo $value->nombre_categoriacurso?></option>
		                      
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
					
					<label>Imagen Curso<sup class="text-danger">*</sup></label>
			
					<label for="customFileCover" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<?php $rutaimg = strtr($datacurso->nombre_curso, " ", "-"); ?>

							<img src="<?php echo TemplateController::srcImg() ?>views/img/cursos/<?php echo $rutaimg ?>/<?php echo $datacurso->imagen_curso ?>" class="img-fluid changeCover">

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
		            
		            <label>Contenido del curso<sup class="text-danger">*</sup></label>

		            <textarea
		            class="summernote"
		            name="cuerpo-noticia"
		            required
		            ><?php echo $datacurso->contenido_curso?></textarea>

		            <div class="valid-feedback">Valid.</div>
		            <div class="invalid-feedback">Please fill out this field.</div>

		        </div>

		        <!--=====================================
                resumern de la noticia en 160 caracteres                ======================================-->

                <div class="form-group mt-2">
					
					<label>Descripcion del curso<sup class="text-danger">*</sup></label>
					<input 
					type="text" 
					class="form-control"
					pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,180}"
					onchange="validateRepeat(event,'text&number','products','name_product')"
					maxlength="180"
					name="resumen-noticia"
					value="<?php echo $datacurso->descripcion_curso?>"
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