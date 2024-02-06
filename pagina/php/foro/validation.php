<?php

/* ------------------------ FUNCTIONS FORO VALIDATION ------------------------ */

# Validate the length of the foro name
function is_name_valid($name) {
    return strlen($name) < 50;
}


# Validate the length of the foro description
function is_description_valid($description) {
    return strlen($description) < 150;
}


?>