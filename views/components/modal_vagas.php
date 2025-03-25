<!-- Modal de Edição -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Vaga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_vaga_id" name="vaga_id">

                    <div class="form-group">
                        <label for="edit_vaga">Número da Vaga</label>
                        <input type="number" class="form-control" id="edit_vaga" name="vaga" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tipo_vaga">Tipo da Vaga</label>
                        <select class="form-control" id="edit_tipo_vaga" name="novo_tipo_vaga" required>
                            <option value="NM">Normal</option>
                            <option value="ID">Idoso</option>
                            <option value="DF">Deficiente</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" name="update-vaga">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Esse script fica responsável por preencher os campos do modal para edição -->
<script>
    $(document).ready(function () {
        $(".edit-btn").click(function () {
            var vagaId = $(this).data("id");
            var numVaga = $(this).data("numero");
            var tipoVaga = $(this).data("tipo");

            $("#edit_vaga_id").val(vagaId);
            $("#edit_vaga").val(numVaga);
            $("#edit_tipo_vaga").val(tipoVaga);
        });
    });
</script>