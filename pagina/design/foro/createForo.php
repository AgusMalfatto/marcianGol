<?php

include ("../../php/session/validateSession.php");
include ("../../php/session/validateAdmin.php");
include ("templateMenu.php");

?>
<!DOCTYPE html>
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
    
</html>

<h1>CREATE FORO</h1>

<!-- Formulario de modificación sin modal -->
<div class="container">
    <h2>Modificar Foro</h2>
    <form id="modificarForoForm">
        <div class="form-group">
            <label for="nameCreateForo">Nombre del Foro</label>
            <input type="text" class="form-control" id="nameCreateForo" placeholder="Nombre del Foro">
        </div>
        <div class="form-group">
            <label for="descriptionCreateForo">Descripción del Foro</label>
            <textarea class="form-control" id="descriptionCreateForo" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="imageCreateForo">Principal del Foro</label>
            <select class="form-control-file mt-4 mb-4" id="imageCreateForo">
            </select>
        </div>
        <div class="form-group">
            <label for="leagueCreateForo">Liga del Foro</label>
            <select class="form-control-file mt-4 mb-4" id="leagueCreateForo">
            </select>
        </div>
        <button type="button" class="btn btn-primary" id="createForoButton">Confirmar</button>
        <button type="button" class="btn btn-primary" id="cleanCreateFormButton">Limpiar</button>
    </form>
</div>

<!-- Modal after deactivate foro -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="avisoModalLabel" aria-hidden="true">
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
                    <!-- Text to alert errors on the form -->
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="../../js/jquery-3.7.1.min.js"></script>

<!-- JavaScript de Bootstrap (jQuery es requerido) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

<!-- JS -->
<script src="../../js/foro/createForo.js"></script>


</body>