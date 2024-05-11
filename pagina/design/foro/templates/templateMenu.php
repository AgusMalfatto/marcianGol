<!-- MENÚ -->

<head>
    <?php
        include 'head.php'; 
    ?>

  </head>

<!-- Barra de navegacion -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../foro/home.php" title="Inicio"><i class="las la-futbol la-2x"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            
            <?php

                if($_SESSION['admin']) {
                  echo '<li><a class="nav-link" href="/marciangol/pagina/design/foro/createForo.php" title="Crear Foro"><i class="las la-plus-circle la-2x"></i></a></li>';                
                  echo '<li><a class="nav-link" href="/marciangol/pagina/design/foro/foro_admin.php" title="Ver Foros"><i class="las la-th-list la-2x"></i></a></li>';
                  echo '<li><a class="nav-link" href="/marciangol/pagina/design/foro/user_admin.php" title="Ver Usuarios"><i class="las la-users la-2x"></i></a></li>';
                } 
            ?>

            <li class="nav-item">
              <a class="nav-link" href="/marciangol/pagina/design/user/modifyUser.php" title="Usuario"><i class="las la-user la-2x"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../php/session/destroySession.php" action="" title="Cerrar Sesión"><i class="las la-sign-out-alt la-2x"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    
    <!-- JQUERY SCRIPT -->
    <script src="../../js/jquery-3.7.1.min.js"></script>
