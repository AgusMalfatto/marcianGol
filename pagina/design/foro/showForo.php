<?php

include ("../../php/session/validateSession.php");

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="../../css/styles.css" rel="stylesheet">

    <!-- Icons8 -->
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
  </head>
<body>   
    
<?php
    include 'templateMenu.php'; 
?>

<h1>Show FORO</h1>

<!-- Div para esconder el id del foro -->
<div id="id_foro_div"  class="d-none">
    <p id="id_foro"></p>
</div>

<div class="foro">   
    <div id="div_foro_title">
        <!-- Title of the foro -->
    </div>
    <div id="div_foro_description">
        <!-- Description of the foro -->
    </div>
    <div id="div_foro_league">
        <!-- League of the foro -->
    </div>
    <div id="div_img_content">
        <!-- Image of the foro -->
    </div>

    <!-- Deactivate and modify foro buttons (Just for admin users) -->
    <?php
        if($_SESSION['admin']) {
            echo "<button id='deactivate_foro' type='button' class='btn btn-primary' data-toggle='modal' data-target='#deactivateModal'>Desactivar Foro</button>";
            echo "<button id='modify_foro' type='button' class='btn btn-primary' data-toggle='modal' data-target='#modifyForoModal'>Modificar Foro</button>";
        }
    ?>
</div>

<!-- Modal to modify foro -->
<div class="modal fade" id="modifyForoModal" tabindex="-1" role="dialog" aria-labelledby="modificarForoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modificarForoModalLabel">Modificar Foro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de modificación -->
                <form id="modificarForoForm">
                    <div class="form-group">
                        <label for="nombreForo">Nombre del Foro</label>
                        <input type="text" class="form-control" id="anmeModifyForo" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="descripcionForo">Descripción del Foro</label>
                        <textarea class="form-control" id="descriptioMofidyForo" rows="3"><!-- Foro description --></textarea>
                    </div>
                    <div class="form-group">
                        <label for="fotoForo">Foto del Foro</label>
                        <input type="file" class="form-control-file" id="imageModifyForo">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="desactivarForoBtn" data-toggle='modal' data-target='#deactivateModal'>Desactivar Foro</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarModificacionBtn">Confirmar</button>
            </div>
        </div>
    </div>
</div>
 
<!-- Modal deactivate foro Confirmation-->
<div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Desactivar Foro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas desactivar el foro? No se podrá utilizar ni reactivar una vez desactivado.  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id='confirmDeactivateBtn'>Confirmar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal after deactivate foro -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="avisoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avisoModalLabel">Foro Desactivado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="avisoTexto">
                    <!-- Text to confirm deactivation -->
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<div id="filter-zone" class="btn">Filtrar y Ordenar</div>

<h3>Comment Section</h3>

<section id="comment-section">
    <div id="content-comment">
        <!-- Comments of the foro -->
    </div>
</section>

<script src="../../js/jquery-3.7.1.min.js"></script>

<!-- JavaScript de Bootstrap (jQuery es requerido) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

<!-- JS -->
<script src="../../js/foro/getForo.js"></script>
<script src="../../js/foro/manageForo.js"></script>

</body>
</html>