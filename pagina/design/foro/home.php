<?php
include('../../php/session/validateSession.php');
?>

<!-- ARCHIVO CREADO COMO BASE PARA EL DISENO -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="../../css/styles.css" rel="stylesheet">
  </head>
  <body>


    <?php
      include 'templateMenu.php'; 
    ?>

    <!-- Foros -->
    <section id="foros_section">
      <div class="d-flex flex-wrap justify-content-center text-center" id="foros_div">
        <!-- Foros add in js -->
      </div>
    </section>

    <section id="trend-foro">
      <div class="card">
        <div class="row g-0" id="trend-div">
          
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../js/jquery-3.7.1.min.js"></script>
    <script src="../../js/foro/getForoHome.js"></script>
  </body>
</html>