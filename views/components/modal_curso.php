<!-- Modal de Edição -->
<div class="modal fade" id="editModalCurso" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_curso_id" name="edit_curso_id">

                    <div class="form-group">
                        <label for="edit_vaga">Período</label>
                        <input type="text" class="form-control" id="edit_curso" name="edit_curso" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tipo_vaga">Periodicidade</label>
                        <select class="form-control" id="edit_periocidade_curso" name="edit_periocidade_curso" required>
                            <option value="Bimestre">Bimestre</option>
                            <option value="Semestre">Semestre</option>
                            <option value="Anual">Anual</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-vermelho" name="update-curso">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Esse script fica responsável por preencher os campos do modal para edição -->
<script>
    $(document).ready(function () {
        $(".edit-btn").click(function () {
            var cursoId = $(this).data("id");
            var periodo = $(this).data("periodo");
            var periodicidade = $(this).data("periodicidade");

            $("#edit_curso_id").val(cursoId);
            $("#edit_curso").val(periodo);
            $("#edit_periocidade_curso").val(periodicidade);
        });
    });
</script>