
<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/negocios.controller.php";

				$create = new NegociosController();
				$create -> create();

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
					pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}"
					onchange="validateRepeat(event,'text&number','products','name_product')"
					maxlength="50"
					name="name-product"
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

		                    <option value="">Seleccione una categoria</option>

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

		                    <option value="">Seleccione una zona</option>

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
							
							<img src="<?php echo TemplateController::srcImg() ?>views/img/negocios/default/default-image.jpg" class="img-fluid changeImage" style="width:150px">

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
					required></textarea>

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
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>	
			

				<!--=====================================
		        Resumen del producto
		        ======================================-->
		        

		        <div class="form-group mt-2">
		         	
		        	<label>Servicios negocio<sup class="text-danger">*</sup> Ex: peluqueria, manicura</label>

		        	<input type="hidden" name="inputSummary" value="1">

		        	<div class="input-group mb-3 inputSummary">
		        	 	
		        		 <div class="input-group-append">
		        		 	<span class="input-group-text">
		        		 		<button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(0,'inputSummary')">&times;</button>
		        		 	</span>
		        		 </div>

		        		<input
		                class="form-control py-4" 
		                type="text"
		                name="summary-product_0"
		                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
		                onchange="validateJS(event,'regex')"
		                required>

		                <div class="valid-feedback">Valid.</div>
                		<div class="invalid-feedback">Please fill out this field.</div>

		        	</div>

		        	<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputSummary')">Agregar</button>

		        </div>
		    
		        <!--=====================================
		        Banner negocio
		        ======================================-->
		        
		        <div class="form-group mt-2">
		        	
		        	<label>Galeria negocio: <sup class="text-danger">*</sup></label> 

		        	<div class="dropzone mb-3">
		        	 	
		        		<div class="dz-message">
		        			
		        			Arraste aca las imagenes, tamaño max 500px * 500px

		        		</div>

		        	</div>

		        	<input type="hidden" name="gallery-product">

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
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ :\/\.\:]{1,100}"
					maxlength="100"
					onchange="validateJS(event,'regex')"
					name="mapa-negocio"
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
					onchange="validateJS(event,'regex')"
					>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>
				<!--=====================================
                Redes Sociales del negocio
                ======================================-->

                <div class="form-group mt-2">
                	
                	<label>Redes Sociales</label>

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
						onchange="validateJS(event,'regex')"
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
                		pattern='^[-()=%&$;_*\"#?¿!¡:.,0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,180}$'
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

			
