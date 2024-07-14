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

    <div class="container content-adminUser">
        <table class="table table-striped" id="table_userList">
            <thead>
                <tr>
                    <th class="sortable cursor-point" data-column="id">ID</th>
                    <th class="sortable cursor-point" data-column="nombre">Nombre</th>
                    <th class="sortable cursor-point" data-column="apellido">Apellido</th>
                    <th class="sortable cursor-point" data-column="email">Email</th>
                    <th class="sortable cursor-point" data-column="equipo">Equipo</th>
                    <th class="sortable cursor-point" data-column="activo">Activo</th>
                    <th class="sortable cursor-point" data-column="admin">Admin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="table_user_body">
                <!-- Aquí se agregarán las filas dinámicamente -->
            </tbody>
        </table>
    </div>

    <?php
      include 'templates/footer.php';
      include 'modals/modal_alerts.php';
    ?>


    <!-- SCRIPTS -->
    <script src="../../js/foro/user_admin.js"></script>
  </body>
</html>