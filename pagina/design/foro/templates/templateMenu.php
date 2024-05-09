<!-- MENÚ -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="../../css/styles.css" rel="stylesheet">

  </head>

<!-- Barra de navegacion -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../foro/home.php">MarcianGol</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Pricing</a>
            </li>


            <?php

              if($_SESSION['admin']) {
                echo '<li><a class="nav-link" href="createForo.php">Crear Foro</a></li>';                
                echo '<li><a class="nav-link" href="foro_admin.php">Ver Foros</a></li>';
                echo '<li><a class="nav-link" href="#">Ver Usuarios</a></li>';
              }
            ?>
            <li class="nav-item">
              <a class="nav-link" href="../../php/session/destroySession.php" action="">Log Out</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    
    <!-- JQUERY SCRIPT -->
    <script src="../../js/jquery-3.7.1.min.js"></script>
