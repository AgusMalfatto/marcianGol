
// Returns true if the name of the foro is correct
function validateName(nameForo) {
    nameForo = nameForo.trim();

    if (nameForo === "" || /^\s+$/.test(nameForo)) {
        document.getElementById("avisoTexto").textContent = "No se admite un nombre vacío.";
        document.getElementById("avisoModalLabel").textContent = "Datos incorrectos";

        $('#confirmModal').modal('show');
        $("#nameModifyForo").addClass('border border-danger border-2');

        return false;
    }

    if (nameForo.length > 50) {
        document.getElementById("avisoTexto").textContent = "El nombre del foro no debe superar los 50 caracteres.";
        document.getElementById("avisoModalLabel").textContent = "Datos incorrectos";

        $('#confirmModal').modal('show');
        $("#nameModifyForo").addClass('border border-danger border-2');

        return false;
    }

    $("#nameModifyForo").removeClass('border border-danger border-2');

    return true;
}

// Returns true if the description of the foro is correct
function validateDescription(descriptionForo) {
    descriptionForo = descriptionForo.trim();

    if (descriptionForo === "" || /^\s+$/.test(descriptionForo)) {
        document.getElementById("avisoTexto").textContent = "No se admite una descripción vacía.";
        document.getElementById("avisoModalLabel").textContent = "Datos incorrectos";

        $('#confirmModal').modal('show');
        $("#descriptionMofidyForo").addClass('border border-danger border-2');

        return false;
    }

    if (descriptionForo.length > 50) {
        document.getElementById("avisoTexto").textContent = "La descripción del foro no debe superar los 150 caracteres.";
        document.getElementById("avisoModalLabel").textContent = "Datos incorrectos";

        $('#confirmModal').modal('show');
        $("#descriptionMofidyForo").addClass('border border-danger border-2');

        return false;
    }

    $("#descriptionMofidyForo").removeClass('border border-danger border-2');

    return true;
}
