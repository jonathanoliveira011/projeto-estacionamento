<!-- Modal de Edição -->
<div class="modal fade" id="editModalPerfil" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_perfil_id" name="perfil_id">

                    <div class="form-group">
                        <label for="edit_vaga">Nome do perfil</label>
                        <input type="text" class="form-control" id="edit_nome_perfil" name="nome_perfil" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-vermelho" name="update-perfil">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Esse script fica responsável por preencher os campos do modal para edição -->
<script>
    $(document).ready(function () {
        $(".edit-btn").click(function () {
            var perfilId = $(this).data("id");
            var nomePerfil = $(this).data("nome");

            $("#edit_perfil_id").val(perfilId);
            $("#edit_nome_perfil").val(nomePerfil);
        });
    });
</script>