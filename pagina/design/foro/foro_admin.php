<?php
include('../../php/session/validateSession.php');
?>

<!-- ARCHIVO CREADO COMO BASE PARA EL DISENO -->
<!doctype html>
<html lang="en">
  
  <?php
      include 'templates/head.php'; 
  ?>
  <body>


    <?php
      include 'templates/templateMenu.php'; 
    ?>

    <h1>Listado de Foros</h1>

    <div class="container">
        <table class="table table-striped" id="table_foroList">
            <thead>
                <tr>
                  <th class="sortable cursor-pointer" data-column="id">ID</th>
                  <th class="sortable cursor-pointer" data-column="nombre">Nombre</th>
                  <th class="sortable cursor-pointer" data-column="descripcion">Descripción</th>
                  <th class="sortable cursor-pointer" data-column="equipo">Equipo</th>
                  <th class="sortable cursor-pointer" data-column="liga">Liga</th>
                  <th class="sortable cursor-pointer" data-column="creacion">Creación</th>
                  <th class="sortable cursor-pointer" data-column="comentarios">Comentarios</th>
                  <th class="sortable cursor-pointer" data-column="activo">Activo</th>
                  <?php
                      if($_SESSION['admin']) {
                        echo '<th>Desactivar</th>';
                        echo '<th>Modificar</th>';
                      }
                  ?>
                  <th>Ver</th>
                </tr>
            </thead>
            <tbody id="tabla-body">
                <!-- Aquí se agregarán las filas dinámicamente -->
            </tbody>
        </table>
    </div>

    <?php
      include 'modals/modal_modifyForo.php'; 
      include 'modals/modal_alerts.php';
    ?>

    <!-- SCRIPTS -->
    <script src="../../js/foro/update/update.js"></script>
    <script src="../../js/foro/selects/fill_selects.js"></script>
    <script src="../../js/foro/validation/validations.js"></script>
    <script src="../../js/foro/getForoHome.js"></script>
    <script src="../../js/foro/foro_admin.js"></script>
  </body>
</html>