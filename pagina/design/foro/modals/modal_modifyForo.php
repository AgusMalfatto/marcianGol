

<!-- Modal to modify foro -->
<div class="modal fade" id="modifyForoModal" tabindex="-1" role="dialog" aria-labelledby="modificarForoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-interact">
            <div class="modal-header">
                <h5 class="modal-title" id="modificarForoModalLabel">Modificar Foro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de modificación -->
                <form id="modificarForoForm">
                    <div class="form-group mt-3">
                        <label for="idForo" class="form-label h5 font-weight-bold">ID del Foro</label>
                        <input type="text" class="form-control" id="idModifyForo" placeholder="">
                    </div>
                    <div class="form-group mt-3">
                        <label for="nameModifyForo" class="form-label h5 font-weight-bold">Nombre del Foro</label>
                        <input type="text" class="form-control" id="nameModifyForo" placeholder="">
                    </div>
                    <div class="form-group mt-3">
                        <label for="descriptionModifyForo" class="form-label h5 font-weight-bold">Descripción del Foro</label>
                        <textarea class="form-control" id="descriptionMofidyForo" rows="3"></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="iamgeModifyForo" class="form-label h5 font-weight-bold">Principal del Foro</label>
                        <select class="form-control" id="imageModifyForo">
                        
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="leagueModifyForo" class="form-label h5 font-weight-bold">Liga del Foro</label>
                        <select class="form-control" id="leagueModifyForo">

                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deactivateForoBtn_modalModify" data-toggle='modal' data-target='#deactivateModal'>Desactivar Foro</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="modifyFormBtn" class='btn btn-primary'>Confirmar</button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
