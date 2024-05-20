<?php 
	
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "relations?rel=negocios,categorianegocios,barrios&type=negocio,categorianegocio,barrio&select=".$select."&linkTo=id_negocio&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
	
			if($response->status == 200){

				$datanegocio = $response->results[0];

			}else{

				echo '<script>

				window.location = "/negocios";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/negocios";

			</script>';
		

		}

	}


?>


<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $datanegocio->id_negocio ?>" name="idProduct">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/negocios.controller.php";

				$create = new NegociosController();
				$create -> edit($datanegocio->id_negocio);

				//echo'<pre>';print_r($datanegocio->id_negocio); echo'</pre>';

			?>
			
			<div class="col-md-8 offset-md-2">	

				<label class="text-danger float-right"><sup>*</sup> Obligatorio</label>

				<!--=====================================
                Nombre del producto
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre negocio <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					readonly
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}"
					onchange="validateRepeat(event,'text&number','negocios','nombre_negocio')"
					maxlength="50"
					name="name-product"
					value="<?php echo $datanegocio->nombre_negocio?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

				<!--=====================================
                Url de la tienda
                ======================================-->

				<div class="form-group mt-2">
					
					<label>url negocio <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					readonly
					name="url-name_product"
					value="<?php echo $datanegocio->url_negocio ?>"
					required>

				</div>

				<!--=====================================
		        Categoría
		        ======================================-->
		          <div class="form-group mt-2">
		            
		            <label>Categoria negocio<sup class="text-danger">*</sup></label>

		            <?php 

		            $url = "categorianegocios?select=id_categorianegocio,nombre_categorianegocio";
		            $method= "GET";
		            $fields = array();

		            $categories = CurlController::request($url, $method, $fields)->results;

		            ?>

		            <div class="form-group">
		                
		                <select
		                class="form-control select2"
		                name="name-category"
		                style="width:100%"
		                onchange="changeCategory(event, 'products')"
		                required>

		                    <option value=""><?php echo $datanegocio->nombre_categorianegocio; ?></option>

		                    <?php foreach ($categories as $key => $value): ?>	

		                        <option value="<?php echo $value->id_categorianegocio ?>"><?php echo $value->nombre_categorianegocio ?></option>
		                      
		                    <?php endforeach ?>

		                </select>

		                <div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

		            </div>

		        </div>
				
				
				<!--=====================================
		        lista zonas
		        ======================================-->
		     	<div class="form-group mt-2">
		            
		            <label>Zona negocio<sup class="text-danger">*</sup></label>

		            <?php 

		            $url = "barrios?select=id_barrio,nombre_barrio";
		            $method= "GET";
		            $fields = array();

		            $categories = CurlController::request($url, $method, $fields)->results;

		            ?>

		            <div class="form-group">
		                
		                <select
		                class="form-control select2"
		                name="name-barrio"
		                style="width:100%"
		                onchange="changeCategory(event, 'products')"
		                required>

		                    <option value=""><?php echo $datanegocio->nombre_barrio; ?></option>

		                    <?php foreach ($categories as $key => $value): ?>	

		                        <option value="<?php echo $value->id_barrio ?>"><?php echo $value->nombre_barrio ?></option>
		                      
		                    <?php endforeach ?>

		                </select>

		                <div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

		            </div>

		        </div>
					
		        <!--=====================================
                Logo negocio
                ======================================-->
                
				<div class="form-group mt-2">
					
					<label>Logo negocio <sup class="text-danger">*</sup></label>
			
					<label for="customFile" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							


							<img src="<?php echo TemplateController::srcImg() ?>views/img/negocios/<?php echo $datanegocio->url_negocio ?>/<?php echo $datanegocio->logo_negocio ?>" class="img-fluid changeImage" style="width:150px">


						</figure>

					</label>

					<div class="custom-file">
						
						<input 
						type="file" 
						id="customFile" 
						class="custom-file-input"
						accept="image/*"
						onchange="validateImageJS(event,'changeImage')"
						name="logo-store"
						required>

						<div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

						<label for="customFile" class="custom-file-label">Buscar logo</label>

					</div>

				</div>
				

		        <!--=====================================
		        Descripción del negocio
		        ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Descripcion negocio <sup class="text-danger">*</sup></label>

					<textarea 
					rows="7"
					type="text" 
					class="form-control"
					pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}"
					onchange="validateJS(event,'regex')"
					maxlength="500"
					name="about-store"
					required><?php echo $datanegocio->descripcion_negocio ?></textarea>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

				
		        <!--=====================================
                Palabras Claves
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Palabras clave</label>

					<input 
					type="text" 
					class="form-control tags-input"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="tags-product"
					value="<?php echo implode(",",json_decode($datanegocio->palabrasclave_negocio,true)) ?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>	
			

				<!--=====================================
		        Resumen del producto
		        ======================================-->
		          <div class="form-group mt-2">
		         	
		        	<label>Servicios del producto<sup class="text-danger">*</sup> Ej: Peliqueria,manicura</label>

		        	<?php foreach (json_decode($datanegocio->servicios_negocio, true) as $key => $value): ?>

			        	<input type="hidden" name="inputSummary" value="<?php echo $key+1 ?>">

			        	<div class="input-group mb-3 inputSummary">
			        	 	
			        		 <div class="input-group-append">
			        		 	<span class="input-group-text">
			        		 		<button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(<?php echo $key ?>,'inputSummary')">&times;</button>
			        		 	</span>
			        		 </div>

			        		<input
			                class="form-control py-4" 
			                type="text"
			                name="summary-product_<?php echo $key ?>"
			                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
			                onchange="validateJS(event,'regex')"
			                value="<?php echo $value ?>"
			                required>

			                <div class="valid-feedback">Valid.</div>
	                		<div class="invalid-feedback">Please fill out this field.</div>

			        	</div>

		        	<?php endforeach ?>

		        	<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputSummary')">Agregar</button>

		        </div>


		  
		        <!--=====================================
		        Banner negocio
		        ======================================-->
		        
		        
		        <div class="form-group mt-2">
		        	
		        	<label>Galeria negocio: <sup class="text-danger">*</sup></label> 

		        	<div class="dropzone mb-3">

		        		<?php foreach (json_decode($datanegocio->banner_negocio,true) as $value): ?>

		            		<div class="dz-preview dz-file-preview"> 

		            			<div class="dz-image">
		            			 	
		            			 	<img class="img-fluid" src="<?php echo TemplateController::srcImg() ?>views/img/negocios/<?php echo $datanegocio->url_negocio ?>/galeria/<?php echo $value ?>">

		            			</div>

		            			<a class="dz-remove" data-dz-remove remove="<?php echo $value?>" onclick="removeGallery(this)">Eliminar</a>

		            		</div>   
		            		
            			<?php endforeach ?>
		        	 	
		        		<div class="dz-message">
		        			
		        			Arrastra tus imágenes aquí, size max 500px * 500px

		        		</div>

		        	</div>

		        	<input type="hidden" name="gallery-product-old" value='<?php echo $datanegocio->banner_negocio ?>'>

		        	<input type="hidden" name="gallery-product">

		        	<input type="hidden" name="delete-gallery-product">

		        </div>

		        <!--=====================================
                Dirección
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Direccion <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="address-store"
					value="<?php echo $datanegocio->direccion_negocio?>"
					required>


					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

				<!--=====================================
                mapa negocio
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Codigo Mapa <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}"
					onchange="validateRepeat(event,'text&number','products')"
					maxlength="50"
					name="mapa-negocio"
					value="<?php echo $datanegocio->dirmapa_negocio?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

				<!--=====================================
                Teléfono
                ======================================-->

                <div class="form-group mt-2 mb-5">
					
					<label>Telefono <sup class="text-danger">*</sup></label>

					<div class="input-group">

						<div class="input-group-append">
							<span class="input-group-text dialCode">+57</span>
						</div>

						<input 
						type="text" 
						class="form-control"
						pattern="[-\\(\\)\\0-9 ]{1,}"
						onchange="validateJS(event,'phone')"
						name="phone-store"
						value="<?php echo $datanegocio->telefono_negocio?>"
						required>

					</div>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

				<!--=====================================
                Correo electrónico
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Correo electronico <sup class="text-danger">*</sup></label>

					<input 
					type="email" 
					class="form-control"
					pattern="^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$"
					onchange="validateRepeat(event,'email')"
					name="email-store"
					value="<?php echo $datanegocio->correo_negocio?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

				<!--=====================================
                pagina web de negocio
                ======================================-->
                	<div class="form-group mt-2">
					
					<label>Pagina web</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}"
					maxlength="100"
					name="pagina-web"
					value="<?php echo $datanegocio->paginaweb_negocio?>"
					onchange="validateJS(event,'regex')"
					>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

				<!--=====================================
                Redes Sociales de la tienda
                ======================================-->

   				<div class="form-group mt-2">
                    
                    <label>Redes sociales</label>

                    <?php

                    $facebook = ""; 
                    $instagram = ""; 
                    $twitter = ""; 
                    $linkedin = ""; 
                    $youtube = ""; 
                    $tiktok = "";

                    if($datanegocio->redes_negocio != null){

                        foreach (json_decode($datanegocio->redes_negocio, true) as $key => $value) {

                            if(array_keys($value)[0] == "facebook"){

                                $facebook = explode("/",$value[array_keys($value)[0]])[3];

                            }

                            if(array_keys($value)[0] == "instagram"){

                                $instagram = explode("/",$value[array_keys($value)[0]])[3];

                            }

                            if(array_keys($value)[0] == "twitter"){

                                $twitter = explode("/",$value[array_keys($value)[0]])[3];

                            }

                            if(array_keys($value)[0] == "linkedin"){

                                $linkedin = explode("/",$value[array_keys($value)[0]])[3];

                            }

                            if(array_keys($value)[0] == "youtube"){

                                $youtube = explode("/",$value[array_keys($value)[0]])[3];

                            }

                             if(array_keys($value)[0] == "tiktok"){

                                $tiktok = explode("/",$value[array_keys($value)[0]])[3];

                            }
                            
                        }


                    }

                    ?>

                    <!--=====================================
                    Facebook
                    ======================================-->

                    <div class="input-group mb-5">
                        
                        <div class="input-group-append">    
                            <span class="input-group-text">https://facebook.com/</span>
                        </div>

                        <input type="text"
                        class="form-control"
                        name="facebook-store"
                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validateJS(event,'regex')"+
                        value="<?php echo $facebook ?>"
                        >   

                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>

                    </div>

                    <!--=====================================
                    instagram
                    ======================================-->

                    <div class="input-group mb-5">
                        
                        <div class="input-group-append">    
                            <span class="input-group-text">https://instagram.com/</span>
                        </div>

                        <input type="text"
                        class="form-control"
                        name="instagram-store"
                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validateJS(event,'regex')"
                        value="<?php echo $instagram ?>"
                        >   

                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>

                    </div>

                    <!--=====================================
                    twitter
                    ======================================-->

                    <div class="input-group mb-5">
                        
                        <div class="input-group-append">    
                            <span class="input-group-text">https://twitter.com/</span>
                        </div>

                        <input type="text"
                        class="form-control"
                        name="twitter-store"
                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validateJS(event,'regex')"
                        value="<?php echo $twitter ?>"
                        >   

                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>

                    </div>

                    <!--=====================================
                    linkedin
                    ======================================-->

                    <div class="input-group mb-5">
                        
                        <div class="input-group-append">    
                            <span class="input-group-text">https://linkedin.com/</span>
                        </div>

                        <input type="text"
                        class="form-control"
                        name="linkedin-store"
                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validateJS(event,'regex')"
                        value="<?php echo $linkedin ?>"
                        >   

                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>

                    </div>

                    <!--=====================================
                    youtube
                    ======================================-->

                    <div class="input-group mb-5">
                        
                        <div class="input-group-append">    
                            <span class="input-group-text">https://youtube.com/</span>
                        </div>

                        <input type="text"
                        class="form-control"
                        name="youtube-store"
                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validateJS(event,'regex')"
                        value="<?php echo $youtube ?>"
                        >   

                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>

                    </div>

                    <!--=====================================
                    tiktok
                    ======================================-->

                    	<div class="input-group mb-5">
                		
                		<div class="input-group-append">	
                			<span class="input-group-text">https://vt.tiktok.com/</span>
                		</div>

                		<input type="text"
                		class="form-control"
                		name="tiktok-store"
                		value="<?php echo $tiktok ?>"
                		pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
						onchange="validateJS(event,'regex')"
                		>	

                		<div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

                	</div>

   				 </div>


			</div>
		
		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/negocios" class="btn btn-light border text-left">Atras</a>
					
					<button type="submit" class="btn bg-dark float-right saveBtn">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>
