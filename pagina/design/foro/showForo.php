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
</div>

<div id="filter-zone" class="btn">Filtrar y Ordenar</div>

<h3>Comment Section</h3>

<section id="comment-section">
    <div id="content-comment">
        <!-- Comments of the foro -->
    </div>
</section>

<!-- JS -->
<script src="../../js/jquery-3.7.1.min.js"></script>
<script src="../../js/foro/getForo.js"></script>

</body>
</html>