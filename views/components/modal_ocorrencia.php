<!-- Modal de Edição -->
<div class="modal fade" id="editModalOcorrencia" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar ocorrência</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_ocorrencia_id" name="edit_ocorrencia_id">

                    <div class="form-group">
                        <label for="edit_vaga">Nome da ocorrência</label>
                        <input type="text" class="form-control" id="edit_ocorrencia_descricao"
                            name="edit_ocorrencia_descricao" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-vermelho" name="update-ocorrencia">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Esse script fica responsável por preencher os campos do modal para edição -->
<script>
    $(document).ready(function () {
        $(".edit-btn").click(function () {
            var ocorrenciaId = $(this).data("id");
            var descricaoOcorrencia = $(this).data("descricao");

            $("#edit_ocorrencia_id").val(ocorrenciaId);
            $("#edit_ocorrencia_descricao").val(descricaoOcorrencia);
        });
    });
</script>