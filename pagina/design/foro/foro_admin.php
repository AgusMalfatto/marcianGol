<?php
include('../../php/session/validateSession.php');
include('../../php/session/validateAdmin.php');
?>

<!-- ARCHIVO CREADO COMO BASE PARA EL DISENO -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    <link href="../../css/styles.css" rel="stylesheet">
  </head>
  <body>


    <?php
      include 'templateMenu.php'; 
    ?>

    <h1>Administración de Foros</h1>

    <div class="container">
        <h2>Tabla dinámica con Bootstrap</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Foro</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Equipo</th>
                    <th>Liga</th>
                    <th>Creación</th>
                    <th>Activo</th>
                    <th>Desactivar</th>
                    <th>Modificar</th>
                    <th>Ver Foro</th>
                </tr>
            </thead>
            <tbody id="tabla-body">
                <!-- Aquí se agregarán las filas dinámicamente -->
            </tbody>
        </table>
    </div>

    <?php
      include 'template_modifyForo.php'; 
      include 'modal_deactivate.php';
    ?>

    <!-- SCRIPTS -->
    <script src="../../js/foro/getForoHome.js"></script>
    <script src="../../js/foro/foro_admin.js"></script>
  </body>
</html>