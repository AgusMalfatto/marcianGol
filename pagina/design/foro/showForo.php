<?php

include ("../../php/session/validateSession.php");

?>


<h1>Show FORO</h1>

<div class="foro">   
    <h2 id="foro_title">
        <!-- Title of the foro -->
    </h2>
    <h4 id="foro_description">
        <!-- Description of the foro -->
    </h4>
</div>

<div id="filter-zone" class="btn">Filtrar y Ordenar</div>

<section id="comment-section">
    <div id="content-comment">
        <!-- Comments of the foro -->
    </div>
</section>

<script src="../../js/jquery-3.7.1.min.js"></script>
<script src="../../js/foro/getForo.js"></script>