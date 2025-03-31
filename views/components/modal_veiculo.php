<!-- Modal de Edição -->
<div class="modal fade" id="editModalVeiculo" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar veículo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_veiculo_id" name="edit_veiculo_id">
                    <?php
                    $sql = "SELECT * FROM tblpessoa";
                    $pessoas = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($pessoas) > 0) { ?>
                        <div class="form-group">
                            <label for="selectPerfil">Pessoas</label>
                            <select class="form-control" id="edit_select_pessoa" name="cpProp" required>

                                <?php foreach ($pessoas as $pessoa) { ?>
                                    <option value="<?= $pessoa['pesid'] ?>"><?= $pessoa['pesnome'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php
                    } else { ?>
                        <div class="form-group">
                            <label for="disabledSelect">Pessoas</label>
                            <select id="disabledSelect" class="form-control" required>
                                <option>Nenhuma pessoa cadastrada</option>
                            </select>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="edit_marca">Marca</label>
                        <input type="text" class="form-control" id="edit_marca" name="edit_marca" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_modelo">Modelo</label>
                        <input type="text" class="form-control" id="edit_modelo" name="edit_modelo" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_placa">Placa</label>
                        <input type="text" class="form-control" id="edit_placa" name="edit_placa" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-vermelho" name="update-veiculo">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Esse script fica responsável por preencher os campos do modal para edição -->
<script>
    $(document).ready(function () {
        $(".edit-btn").click(function () {
            var veiculoId = $(this).data("id");
            var pessoaId = $(this).data("pessoa");
            var marca = $(this).data("marca");
            var modelo = $(this).data("modelo");
            var placa = $(this).data("placa");

            $("#edit_select_pessoa").val(pessoaId);
            $("#edit_veiculo_id").val(veiculoId);
            $("#edit_marca").val(marca);
            $("#edit_modelo").val(modelo);
            $("#edit_placa").val(placa);
        });
    });
</script>