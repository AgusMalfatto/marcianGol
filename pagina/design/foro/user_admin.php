<?php
include('../../php/session/validateSession.php');
include('../../php/session/validateAdmin.php');
?>


<!doctype html>
<html lang="en">
  
  <?php
      include 'templates/head.php'; 
  ?>
  <body>


    <?php
      include 'templates/templateMenu.php'; 
    ?>

    <h1>Administración de Usuarios</h1>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Equipo</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="table_user_body">
                <!-- Aquí se agregarán las filas dinámicamente -->
            </tbody>
        </table>
    </div>

    <?php
      include 'modals/modal_alerts.php';
    ?>


    <!-- SCRIPTS -->
    <script src="../../js/foro/user_admin.js"></script>
  </body>
</html>