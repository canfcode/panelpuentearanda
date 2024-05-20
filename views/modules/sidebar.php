<aside class="main-sidebar sidebar-light-warning elevation-4">
    
    <!-- Brand Logo -->
    <a href="#" class="navbar-warning" style="background-color: white;">
     <!-- <img src="views/assets/img/template/logoapp.png" style="opacity: .8">-->
     <!--  <span class="brand-text font-weight-light">AdminLTE 3</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">

          <!--<img src="<?php //echo TemplateController::returnImg($_SESSION["admin"]->id_user,$_SESSION["admin"]->picture_user,$_SESSION["admin"]->method_user) ?>" class="img-circle elevation-2" alt="User Image">-->

          <img src="<?php echo TemplateController::returnImg($_SESSION["admin"]->id_user,$_SESSION["admin"]->foto_user,$_SESSION["admin"]->metaut_user) ?>" class="img-circle elevation-2" alt="Foto Usuario">
                 
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION["admin"]->usuario_user ?></a>
        </div>
        
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="/" class="nav-link <?php if (empty($routesArray)): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Inicio
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admins" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "admins"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                administradores
              </p>
            </a>
          </li>

             <li class="nav-item">
            <a href="/barrios" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "barrios"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-street-view"></i>
              <p>
                Zonas
              </p>
            </a>
          </li>  

          <li class="nav-item">
            <a href="/catnegocios" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "catnegocios"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-th-list"></i>
              <p>
                Categoria Negocios
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/negocios" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "negocios"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Negocios
              </p>
            </a>
          </li>

           <li class="nav-item">
            <a href="/catnoticias" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "catnoticias"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Categoria Noticias
              </p>
            </a>
          </li>     

          <li class="nav-item">
            <a href="/noticias" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "noticias"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-font"></i>
              <p>
                Noticias
              </p>
            </a>
          </li>

           <li class="nav-item">
            <a href="/catcursos" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "catcursos"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Categoria curso
              </p>
            </a>
          </li>  
           
          <li class="nav-item">
            <a href="/cursos" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "cursos"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-graduation-cap "></i>
              <p>
                Cursos
              </p>
            </a>
          <li>   


           <li class="nav-item">
            <a href="cattramites" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "cattramites"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-th-list"></i>
              <p>
                Categorias tramites
              </p>
            </a>
          <li>  


          <li class="nav-item">
            <a href="/tramites" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "tramites"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-font"></i>
              <p>
                Tramites
              </p>
            </a>
          <li>   
       

            <li class="nav-item">
            <a href="catdenuncias" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "catdenuncias"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-th-list"></i>
              <p>
                Categorias Denuncias
              </p>
            </a>
          <li>    


           <li class="nav-item">
            <a href="/denuncias" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "denuncias"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-font"></i>
              <p>
                Denuncias
              </p>
            </a>
          <li>  
            

           <li class="nav-item">
            <a href="/gpqrs" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "gpqrs"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-font"></i>
              <p>
                Gestion Dependencias
              </p>
            </a>
          <li>  



          <li class="nav-item">
            <a href="/mensajes" class="nav-link <?php if (!empty($routesArray) && $routesArray[1] == "mensajes"): ?>active<?php endif ?>">
              <i class="nav-icon fas fa-comments"></i>
              <p>
                Mensajes
              </p>
            </a>
          <li>     


          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>