<!-- Modal de Edição -->
<div class="modal fade" id="editModalPessoa" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Pessoa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_pessoa_id" name="pessoa_id">

                    <div class="form-group">
                        <label for="id_rm" class="form-label">RM</label>
                        <input type="text" class="form-control form-control-sm" id="edit_id_rm" name="RMnovo"
                            maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label for="id_nomecompleto" class="form-label">Nome completo</label>
                        <input type="text" class="form-control form-control-sm" id="edit_id_nomecompleto"
                            name="NomeNovo" maxlength="50" required>
                    </div>

                    <div class="form-group">
                        <label for="id_email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" id="edit_id_email" name="EmailNovo"
                            maxlength="300" required>
                    </div>

                    <div class="form-group">
                        <label for="id_cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control form-control-sm" id="EditCPFInput" name="CpfNovo"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="CelularInput" class="form-label">Telefone</label>
                        <input type="text" class="form-control form-control-sm" id="EditCelularInput"
                            name="TelefoneNovo" required>
                    </div>
                    <?php
                    $sql = "SELECT * FROM tblcurso";
                    $cursos = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($cursos) > 0) { ?>
                        <div class="form-group">
                            <label for="edit_id_curso">Curso</label>
                            <select class="form-control form-control-sm" id="edit_id_curso" name="CursoNovo" required>

                                <?php foreach ($cursos as $curso) { ?>
                                    <option value="<?= $curso['curid'] ?>"><?= $curso['curperiodo'] ?> -
                                        <?= $curso['curperiodicidade'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php
                    } else { ?>
                        <div class="form-group">
                            <label for="edit_id_curso">Curso</label>
                            <select id="edit_id_curso" class="form-control form-control-sm" name="CursoNovo" required>
                                <option>Nenhum curso cadastrado</option>
                            </select>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="id_turma" class="form-label">Turma</label>
                        <input type="number" class="form-control form-control-sm" id="edit_id_turma" maxlength="1"
                            name="TurmaNovo" accept="number" required>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="id_observacao">Observações</label>
                            <textarea class="form-control" id="edit_id_obs" rows="3" maxlength="600"
                                style="resize: none" name="ObsNovo"></textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <h5>Dados de acesso</h5>
                        <hr>
                    </div>
                    <div class="form-group">
                        <label for="id_nomeuser" class="form-label">Nome de usuário</label>
                        <input type="text" class="form-control form-control-sm" id="edit_id_user" name="NomeUserNovo"
                            maxlength="15" required>
                    </div>
                    <div class="form-group">
                        <label for="id_senha" class="form-label">Senha</label>
                        <input type="password" class="form-control form-control-sm" id="edit_id_senha" name="SenhaNovo"
                            maxlength="300" required>
                    </div>
                    <?php
                    $sql = "SELECT * FROM tblperfil";
                    $perfis = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($perfis) > 0) { ?>
                        <div class="form-group">
                            <label for="selectPerfil">Perfil</label>
                            <select class="form-control form-control-sm" id="edit_id_perfil" name="PerfilNovo" required>

                                <?php foreach ($perfis as $perfil) { ?>
                                    <option value="<?= $perfil['pflid'] ?>"><?= $perfil['pflnome'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php
                    } else { ?>
                        <div class="form-group">
                            <label for="edit_id_perfil">Perfil</label>
                            <select id="edit_id_perfil" class="form-control form-control-sm" name="PerfilNovo" required>
                                <option>Nenhum curso cadastrado</option>
                            </select>
                        </div>
                    <?php } ?>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-vermelho" name="update-pessoa">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Esse script fica responsável por preencher os campos do modal para edição -->
<script>
    $(document).ready(function () {
        $(".edit-btn").click(function () {
            var pessoaId = $(this).data("id");
            var rm = $(this).data("rm");
            var nome = $(this).data("nome");
            var email = $(this).data("email");
            var cpf = $(this).data("cpf");
            var telefone = $(this).data("telefone");
            var curso = $(this).data("curso");
            var turma = $(this).data("turma");
            var obs = $(this).data("obs");
            var user = $(this).data("user");
            var senha = $(this).data("senha");
            var perfil = $(this).data("perfil");

            $("#edit_pessoa_id").val(pessoaId);
            $("#edit_id_rm").val(rm);
            $("#edit_id_nomecompleto").val(nome);
            $("#edit_id_email").val(email);
            $("#EditCPFInput").val(cpf);
            $("#EditCelularInput").val(telefone);
            $("#edit_id_curso").val(curso);
            $("#edit_id_turma").val(turma);
            $("#edit_id_obs").val(obs);
            $("#edit_id_user").val(user);
            $("#edit_id_senha").val(senha);
            $("#edit_id_perfil").val(perfil);
        });
    });

    $('#EditCelularInput').mask('(00) 00000-0000');
    $('#EditCPFInput').mask('000.000.000-00');
</script>