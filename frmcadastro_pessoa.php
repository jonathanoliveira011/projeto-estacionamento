<?php

include('config/conexao.php');
$msg = "";

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
                header('Location: /index.php');
            } else {
                $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao cadastrar pessoa: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include('views/components/header.php') ?>

<body class="body_cadpessoa">
    <div class="col-2"></div>
    <div class="col-8">
        <div class="card card-form">
            <div class="card-body">
                <div class="div_head">
                    <img src="../assets/images/logo-etec1.png" class="logo_cadpessoa">
                    <h1>Cadastro de pessoas</h1>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>Dados pessoais</h5>
                        <hr>
                        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="form-row"
                            enctype="multipart/form-data">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="id_rm" class="form-label">RM</label>
                                    <input type="text" class="form-control form-control-sm" id="id_rm" name="cpRM"
                                        maxlength="50" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label for="id_nomecompleto" class="form-label">Nome completo</label>
                                <input type="text" class="form-control form-control-sm" id="id_nomecompleto"
                                    name="cpNOME" maxlength="50" required>
                            </div>
                            <div class="col-md-4">
                                <label for="id_email" class="form-label">Email</label>
                                <input type="email" class="form-control form-control-sm" id="id_email" name="cpEMAIL"
                                    maxlength="300" required>
                            </div>

                            <div class="col-md-2">
                                <label for="id_cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control form-control-sm" id="CPFInput"
                                    oninput="criaMascara('CPF')" maxlength="11" name="cpCPF" required>
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
                                        <select class="form-control form-control-sm" id="exampleFormControlSelect1"
                                            name="cpCURSO" required>

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
                                <input type="number" class="form-control form-control-sm" id="id_turma" maxlength="1"
                                    name="cpTURMA" accept="number" required>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="id_imagem">Escolha a foto</label>
                                    <input type="file" class="form-control-file" id="id_imagem" accept="image/*"
                                        name="cpFOTO" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="id_observacao">Observações</label>
                                    <textarea class="form-control" id="id_observacao" rows="3" maxlength="600"
                                        style="resize: none" name="cpOBS"></textarea>
                                </div>
                            </div>


                            <div class="col-12">
                                <h5>Dados de acesso</h5>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <label for="id_nomeuser" class="form-label">Nome de usuário</label>
                                <input type="text" class="form-control form-control-sm" id="id_nomeuser"
                                    name="cpNOMEUSUARIO" maxlength="15" required>
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
                                        <select class="form-control form-control-sm" id="selectPerfil" name="cpPERFIL"
                                            required>

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
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-vermelho" name="create-pessoa">Cadastrar</button>
                            </div>
                            <div class="col-md-9">
                                <?= $msg ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2"></div>



    <?php include('views/components/footer.php') ?>
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