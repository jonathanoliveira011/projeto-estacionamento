<?php

include('config/conexao.php');
$mensagem = "";

require_once 'sessao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create-perfil'])) {
    $perfil = $_POST['perfil'];

    if (!empty($perfil)) {
        $perfil_c = mysqli_real_escape_string($conexao, $perfil);

        $sql = "INSERT INTO tblperfil (pflnome) VALUES ('$perfil_c')";

        if (mysqli_query($conexao, $sql)) {
            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Perfil cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao cadastrar perfil: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
        }
    } else {
        $mensagem = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Por favor, preencha o campo!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete-perfil'])) {
    $perfil_id = mysqli_real_escape_string($conexao, $_POST['delete-perfil']);
    $sql = "DELETE FROM tblperfil WHERE pflid = $perfil_id";
    mysqli_query($conexao, $sql);

    if (mysqli_query($conexao, $sql)) {
        $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Perfil excluído com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
    } else {
        $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao excluir perfil: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-perfil'])) {
    $perfil_id = intval($_POST['perfil_id']);
    $nome_perfil = $_POST['nome_perfil'];


    if (!empty($perfil_id) && !empty($nome_perfil)) {
        $sql = "UPDATE tblperfil SET pflnome = '$nome_perfil' WHERE pflid = '$perfil_id'";

        if (mysqli_query($conexao, $sql)) {

            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Perfil atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao atualizar perfil: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
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
    <div class="card">
        <div class="card-body">
            <h2>Gerenciamento de perfil</h2>
            <br>
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <label for="vaga">Nome do perfil</label>
                    <input type="text" class="form-control" id="perfil" name="perfil" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-vermelho" id="cad_pfl" name="create-perfil">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-table">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome do perfil</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tblperfil";
                    $perfis = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($perfis) > 0) {
                        foreach ($perfis as $perfil) { ?>
                            <tr>
                                <td><?= htmlspecialchars($perfil['pflnome']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm edit-btn" data-toggle="modal"
                                        data-target="#editModalPerfil" data-id="<?= $perfil['pflid'] ?>"
                                        data-nome="<?= $perfil['pflnome'] ?>">
                                        <span class="bi-pencil-fill"></span>&nbsp;Editar
                                    </button>
                                    <form action="" method="POST" class="d-inline">
                                        <button onclick="return confirm('Tem certeza que deseja excluir o perfil?')"
                                            type="submit" name="delete-perfil" value="<?= $perfil['pflid'] ?>"
                                            class="btn btn-danger btn-sm"><span
                                                class="bi-trash3-fill"></span>&nbsp;Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo '<h5>Nenhum perfil cadastrado</h5>';
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('./views/components/footer.php') ?>
    <?php include('./views/components/modal_perfil.php') ?>
</body>

</html>