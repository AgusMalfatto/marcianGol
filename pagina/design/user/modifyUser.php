<?php

include ("../../php/session/validateSession.php");

?>
<html>
    <?php
        include ("../foro/templates/head.php");
    ?>
    
    <body>

    <?php
        include ("../foro/templates/templateMenu.php");
    ?>
<h1>Datos de Usuario</h1>

<div class="m-3">
    <form id="userDataForm">
        <div class="mb-3 col-4">
            <label for="id_user" class="form-label">ID de Usuario:</label>
            <input type="text" class="form-control" id="id_user" name="id_user">
        </div>
    
        <div class="mb-3 col-4">
            <label for="name_user" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="name_user" name="name_user">
        </div>
    
        <div class="mb-3 col-4">
            <label for="lastname_user" class="form-label">Apellido:</label>
            <input type="text" class="form-control" id="lastname_user" name="lastname_user">
        </div>
    
        <div class="mb-3 col-4">
            <label for="email_user" class="form-label">Email:</label>
            <input type="text" class="form-control" id="email_user" name="email_user">
        </div>
    
        <div class="mb-3 col-4">
            <label for="team_user" class="form-label">Equipo:</label>
            <select class="form-select" id="team_user" name="team_user">
                <!-- Options added dynamically -->
            </select>
        </div>
    
        <button type="button" class="btn btn-primary" id="send_dataUser_btn">Modificar Datos</button>
        <button type="button" class="btn btn-primary" id="send_deactivateUser_btn">Desactivar Cuenta</button>
    </form>

    <?php
    include ("../foro/modals/modal_alerts.php");
    ?>

</div>

    <script src="../../js/jquery-3.7.1.min.js"></script>

    <!-- JavaScript de Bootstrap (jQuery es requerido) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

    <script src="../../js/user/update/update.js"></script>
    <script src="../../js/user/validation/validations.js"></script>
    <script src="../../js/user/modifyUser.js"></script>

    </body>
</html>