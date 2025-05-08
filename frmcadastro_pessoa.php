<?php

$msg = "";
require_once 'sessao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create-pessoa'])) {
    //Dados para a tabela de pessoa
    $rm = mysqli_real_escape_string($conexao, $_POST['cpRM']);
    $nome = mysqli_real_escape_string($conexao, $_POST['cpNOME']);
    $email = mysqli_real_escape_string($conexao, $_POST['cpEMAIL']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpCPF']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['cpTELEFONE']);
    $curso = intval($_POST['cpCURSO']);
    $turma = intval($_POST['cpTURMA']);
    $foto = $_FILES['cpFOTO'];
    $observacoes = mysqli_real_escape_string($conexao, $_POST['cpOBS']);

    //Dados para a tabela de acesso
    $nomeuser = mysqli_real_escape_string($conexao, $_POST['cpNOMEUSUARIO']);
    $senha = mysqli_real_escape_string($conexao, $_POST['cpSENHA']);
    $perfil = intval($_POST['cpPERFIL']);

    //REALIZA O UPLOAD DA IMAGEM NO BANCO E TAMBÉM NA PASTA ASSETS/IMAGES/UPLOADS
    $nomeFinal = './assets/images/uploads/' . time() . '.jpg';
    if (move_uploaded_file($foto['tmp_name'], $nomeFinal)) {
        $tamanhoImg = filesize($nomeFinal);
        $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg));
    }

    $sql = "INSERT INTO tblpessoa (pesrm, pesnome, pesemail, pescpf, pestelefone, curid, pesturma, pesobservacao, pesfoto) VALUES 
    ('$rm','$nome','$email','$cpf','$telefone','$curso','$turma','$observacoes','$mysqlImg')";

    if (mysqli_query($conexao, $sql)) {
        $idpessoa = mysqli_insert_id($conexao);
        if (!empty($idpessoa)) {
            $sql_acesso = "INSERT INTO tblusuario (pesid, usrnome, usrsenha, pflid, usrstatus) VALUES ('$idpessoa','$nomeuser','$senha','$perfil','1')";
            if (mysqli_query($conexao, $sql_acesso)) {
                $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Pessoa cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
            } else {
                $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao cadastrar pessoa: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-pessoa'])) {
    //Dados para a tabela de pessoa
    $idpessoa = intval($_POST['pessoa_id']);
    $rm = mysqli_real_escape_string($conexao, $_POST['RMnovo']);
    $nome = mysqli_real_escape_string($conexao, $_POST['NomeNovo']);
    $email = mysqli_real_escape_string($conexao, $_POST['EmailNovo']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['CpfNovo']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['TelefoneNovo']);
    $curso = intval($_POST['CursoNovo']);
    $turma = intval($_POST['TurmaNovo']);
    $observacoes = mysqli_real_escape_string($conexao, $_POST['ObsNovo']);

    //Dados para a tabela de acesso
    $nomeuser = mysqli_real_escape_string($conexao, $_POST['NomeUserNovo']);
    $senha = mysqli_real_escape_string($conexao, $_POST['SenhaNovo']);
    $perfil = intval($_POST['PerfilNovo']);

    if (!empty($idpessoa) && !empty($rm) && !empty($nome) && !empty($email) && !empty($cpf) && !empty($telefone) && !empty($curso) && !empty($turma) && !empty($observacoes)) {
        $sql = "UPDATE tblpessoa SET pesrm = '$rm', pesnome = '$nome', pesemail = '$email', pescpf = '$cpf', pestelefone = '$telefone', curid = '$curso', pesturma = '$turma', pesobservacao = '$observacoes' WHERE pesid = $idpessoa";
        if (mysqli_query($conexao, $sql)) {
            $sql_usuario = "UPDATE tblusuario SET usrnome = '$nomeuser', usrsenha = '$senha', pflid = '$perfil' WHERE pesid = $idpessoa";
            if (mysqli_query($conexao, $sql_usuario)) {
                $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Pessoa atualizada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
            } else {
                $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao atualizar pessoa: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
            }
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao atualizar pessoa: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span></button></div>";
        }
    } else {
        $mensagem = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Por favor, preencha todos os campos!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span></button></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include('views/components/header.php') ?>

<body>
    <?php include('./views/components/navbar.php') ?>

    <!-- Cadastro de pessoas -->
    <div class="card card-margin">
        <div class="card-body">
            <h2>Gerenciamento de pessoas</h2>
            <br>
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="form-row" enctype="multipart/form-data">

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="id_rm" class="form-label">RM</label>
                        <input type="text" class="form-control form-control-sm" id="id_rm" name="cpRM" maxlength="50"
                            required>
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="id_nomecompleto" class="form-label">Nome completo</label>
                    <input type="text" class="form-control form-control-sm" id="id_nomecompleto" name="cpNOME"
                        maxlength="50" required>
                </div>
                <div class="col-md-4">
                    <label for="id_email" class="form-label">Email</label>
                    <input type="email" class="form-control form-control-sm" id="id_email" name="cpEMAIL"
                        maxlength="300" required>
                </div>

                <div class="col-md-2">
                    <label for="id_cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control form-control-sm" id="CPFInput" oninput="criaMascara('CPF')"
                        maxlength="11" name="cpCPF" required>
                </div>
                <div class=" col-md-2">
                    <label for="CelularInput" class="form-label">Telefone</label>
                    <input type="text" class="form-control form-control-sm" id="CelularInput"
                        oninput="criaMascara('Celular')" maxLength="11" name="cpTELEFONE" required>
                </div>
                <?php
                $sql = "SELECT * FROM tblcurso";
                $cursos = mysqli_query($conexao, $sql);
                if (mysqli_num_rows($cursos) > 0) { ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Curso</label>
                            <select class="form-control form-control-sm" id="exampleFormControlSelect1" name="cpCURSO"
                                required>

                                <?php foreach ($cursos as $curso) { ?>
                                    <option value="<?= $curso['curid'] ?>"><?= $curso['curperiodo'] ?> -
                                        <?= $curso['curperiodicidade'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php
                } else { ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="disabledSelect">Curso</label>
                            <select id="disabledSelect" class="form-control form-control-sm" required>
                                <option>Nenhum curso cadastrado</option>
                            </select>
                        </div>
                    </div>
                <?php } ?>

                <div class="col-md-1">
                    <label for="id_turma" class="form-label">Turma</label>
                    <input type="number" class="form-control form-control-sm" id="id_turma" maxlength="1" name="cpTURMA"
                        accept="number" required>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="id_imagem">Escolha a foto</label>
                        <input type="file" class="form-control-file" id="id_imagem" accept="image/*" name="cpFOTO"
                            required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="id_observacao">Observações</label>
                        <textarea class="form-control" id="id_observacao" rows="3" maxlength="600" style="resize: none"
                            name="cpOBS"></textarea>
                    </div>
                </div>


                <div class="col-12">
                    <h5>Dados de acesso</h5>
                    <hr>
                </div>
                <div class="col-md-4">
                    <label for="id_nomeuser" class="form-label">Nome de usuário</label>
                    <input type="text" class="form-control form-control-sm" id="id_nomeuser" name="cpNOMEUSUARIO"
                        maxlength="15" required>
                </div>
                <div class="col-md-4">
                    <label for="id_senha" class="form-label">Senha</label>
                    <input type="password" class="form-control form-control-sm" id="id_senha" name="cpSENHA"
                        maxlength="300" required>
                </div>
                <?php
                $sql = "SELECT * FROM tblperfil";
                $perfis = mysqli_query($conexao, $sql);
                if (mysqli_num_rows($perfis) > 0) { ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="selectPerfil">Perfil</label>
                            <select class="form-control form-control-sm" id="selectPerfil" name="cpPERFIL" required>

                                <?php foreach ($perfis as $perfil) { ?>
                                    <option value="<?= $perfil['pflid'] ?>"><?= $perfil['pflnome'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php
                } else { ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="disabledSelect">Perfil</label>
                            <select id="disabledSelect" class="form-control form-control-sm" required>
                                <option>Nenhum curso cadastrado</option>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-vermelho" name="create-pessoa">Cadastrar</button>
                </div>
                <div class="col-md-12">
                    <div class="form-group"><?= $msg ?></div>
                </div>

            </form>
        </div>
    </div>

    <!-- Tabela de pessoas -->
    <div class="card card-table">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">RM</th>
                        <th scope="col">Nome completo</th>
                        <th scope="col">Email</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Turma</th>
                        <th scope="col">Observação</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select * from tblpessoa P INNER JOIN tblcurso C ON P.curid = C.curid 
						  INNER JOIN tblusuario U ON P.pesid = U.pesid";
                    $pessoas = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($pessoas) > 0) {
                        foreach ($pessoas as $pessoa) { ?>
                            <tr>
                                <td><?= htmlspecialchars($pessoa['pesrm']); ?></td>
                                <td><?= htmlspecialchars($pessoa['pesnome']); ?></td>
                                <td><?= htmlspecialchars($pessoa['pesemail']); ?></td>
                                <td><?= htmlspecialchars($pessoa['pescpf']); ?></td>
                                <td><?= htmlspecialchars($pessoa['pestelefone']); ?></td>
                                <td><?= htmlspecialchars($pessoa['curperiodo']); ?>
                                    <?= htmlspecialchars($pessoa['curperiodicidade']); ?>
                                </td>
                                <td><?= htmlspecialchars($pessoa['pesturma']); ?></td>
                                <td><?= htmlspecialchars($pessoa['pesobservacao']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm edit-btn" data-toggle="modal"
                                        data-target="#editModalPessoa" data-id="<?= $pessoa['pesid'] ?>"
                                        data-rm="<?= $pessoa['pesrm'] ?>" data-nome="<?= $pessoa['pesnome'] ?>"
                                        data-email="<?= $pessoa['pesemail'] ?>" data-cpf="<?= $pessoa['pescpf'] ?>"
                                        data-telefone="<?= $pessoa['pestelefone'] ?>" data-curso="<?= $pessoa['curid'] ?>"
                                        data-turma="<?= $pessoa['pesturma'] ?>" data-obs="<?= $pessoa['pesobservacao'] ?>"
                                        data-user="<?= $pessoa['usrnome'] ?>" data-senha="<?= $pessoa['usrsenha'] ?>"
                                        data-perfil="<?= $pessoa['pflid'] ?>">
                                        <span class="bi-pencil-fill"></span>&nbsp;Editar
                                    </button>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo '<h5>Nenhuma ocorrência cadastrada</h5>';
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('views/components/footer.php') ?>
    <?php include('views/components/modal_pessoas.php') ?>
    <script>
        function criaMascara(mascaraInput) {
            const maximoInput = document.getElementById(`${mascaraInput}Input`).maxLength;
            let valorInput = document.getElementById(`${mascaraInput}Input`).value;
            let valorSemPonto = document.getElementById(`${mascaraInput}Input`).value.replace(/([^0-9])+/g, "");
            const mascaras = {
                CPF: valorInput.replace(/[^\d]/g, "").replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4"),
                Celular: valorInput.replace(/[^\d]/g, "").replace(/^(\d{2})(\d{5})(\d{4})/, "($1) $2-$3"),
                CEP: valorInput.replace(/[^\d]/g, "").replace(/(\d{5})(\d{3})/, "$1-$2"),
                CNJ: valorInput.replace(/[^\d]/g, "").replace(/(\d{7})(\d{2})(\d{4})(\d{1})(\d{2})(\d{4})/, "$1-$2.$3.$4.$5.$6"),
            };

            valorInput.length === maximoInput ? document.getElementById(`${mascaraInput}Input`).value = mascaras[mascaraInput]
                : document.getElementById(`${mascaraInput}Input`).value = valorSemPonto;
        };
    </script>
</body>

</html>