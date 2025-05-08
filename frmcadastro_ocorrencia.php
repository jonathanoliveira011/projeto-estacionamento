<?php

//include('config/conexao.php');
$mensagem = "";

require_once 'sessao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create-ocorrencia'])) {
    $ocorrencia = $_POST['ocorrencia_name'];

    if (!empty($ocorrencia)) {
        $ocorrencia_c = mysqli_real_escape_string($conexao, $ocorrencia);

        $sql = "INSERT INTO tblocorrencia (ocodescricao) VALUES ('$ocorrencia_c')";

        if (mysqli_query($conexao, $sql)) {
            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Ocorrência cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao cadastrar ocorrência: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
        }
    } else {
        $mensagem = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Por favor, preencha o campo!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete-ocorrencia'])) {
    $ocorrencia_id = mysqli_real_escape_string($conexao, $_POST['delete-ocorrencia']);
    $sql = "DELETE FROM tblocorrencia WHERE ocoid = $ocorrencia_id";
    mysqli_query($conexao, $sql);

    if (mysqli_query($conexao, $sql)) {
        $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Ocorrência excluída com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
    } else {
        $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao excluir ocorrência: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-ocorrencia'])) {
    $ocorr_id = intval($_POST['edit_ocorrencia_id']);
    $ocorr_descricao = $_POST['edit_ocorrencia_descricao'];


    if (!empty($ocorr_id) && !empty($ocorr_descricao)) {
        $sql = "UPDATE tblocorrencia SET ocodescricao = '$ocorr_descricao' WHERE ocoid = '$ocorr_id'";

        if (mysqli_query($conexao, $sql)) {

            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Ocorrência atualizada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao atualizar ocorrência: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
        }
    } else {
        $mensagem = "<div class='alert alert-warning'>Por favor, preencha todos os campos!</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include('./views/components/header.php') ?>

<body>
    <?php include('./views/components/navbar.php') ?>
    <div class="card-message"><?= $mensagem; ?></div>
    <div class="card card-margin">
        <div class="card-body">
            <h2>Gerenciamento de ocorrências</h2>
            <br>
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <label for="vaga">Nome da ocorrência</label>
                    <input type="text" class="form-control" id="perfil" name="ocorrencia_name" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-vermelho" id="cad_pfl"
                        name="create-ocorrencia">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-table">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome da ocorrência</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tblocorrencia";
                    $ocorrencias = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($ocorrencias) > 0) {
                        foreach ($ocorrencias as $ocorrencia) { ?>
                            <tr>
                                <td><?= htmlspecialchars($ocorrencia['ocodescricao']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm edit-btn" data-toggle="modal"
                                        data-target="#editModalOcorrencia" data-id="<?= $ocorrencia['ocoid'] ?>"
                                        data-descricao="<?= $ocorrencia['ocodescricao'] ?>">
                                        <span class="bi-pencil-fill"></span>&nbsp;Editar
                                    </button>
                                    <form action="" method="POST" class="d-inline">
                                        <button onclick="return confirm('Tem certeza que deseja excluir a ocorrência?')"
                                            type="submit" name="delete-ocorrencia" value="<?= $ocorrencia['ocoid'] ?>"
                                            class="btn btn-danger btn-sm"><span
                                                class="bi-trash3-fill"></span>&nbsp;Excluir</button>
                                    </form>
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

    <?php include('./views/components/footer.php') ?>
    <?php include('./views/components/modal_ocorrencia.php') ?>
</body>

</html>