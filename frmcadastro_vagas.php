<?php
require './config/conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create-vaga'])) {
    $vaga = isset($_POST['vaga']) ? $_POST['vaga'] : null;
    $tipo_vaga = isset($_POST['tipo_vaga']) ? $_POST['tipo_vaga'] : null;

    if (!empty($vaga) && !empty($tipo_vaga)) {
        $vaga_convertida = intval($vaga);
        $tipo_vaga_convertido = mysqli_real_escape_string($conexao, $tipo_vaga);

        $sql = "INSERT INTO tblestacionamento (estvaga, esttipovaga) VALUES ('$vaga_convertida', '$tipo_vaga_convertido')";

        if (mysqli_query($conexao, $sql)) {
            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Vaga cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao cadastrar vaga: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
        }
    } else {
        $mensagem = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Por favor, preencha todos os campos!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete-vaga'])) {
    $vaga_id = mysqli_real_escape_string($conexao, $_POST['delete-vaga']);
    $sql = "DELETE FROM tblestacionamento WHERE estid = $vaga_id";
    mysqli_query($conexao, $sql);

    if (mysqli_query($conexao, $sql)) {
        $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Vaga excluída com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
    } else {
        $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao excluir vaga: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-vaga'])) {
    $vaga_id = intval($_POST['vaga_id']);
    $nova_vaga = intval($_POST['vaga']);
    $novo_tipo_vaga = mysqli_real_escape_string($conexao, $_POST['novo_tipo_vaga']);

    if (!empty($vaga_id) && !empty($nova_vaga) && !empty($novo_tipo_vaga)) {
        $sql = "UPDATE tblestacionamento SET estvaga = '$nova_vaga', esttipovaga = '$novo_tipo_vaga' WHERE estid = '$vaga_id'";

        if (mysqli_query($conexao, $sql)) {

            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Vaga atualizada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao atualizar vaga: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
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
<?php include('./views/components/header.php'); ?>

<body>
    <?php include('./views/components/navbar.php'); ?>

    <div class="card-message"><?= $mensagem; ?></div>
    <div class="card card-vagas">
        <div class="card-body">
            <h2>Gerenciamento de vagas</h2>
            <br>
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <label for="vaga">Número da vaga</label>
                    <input type="number" class="form-control" id="vaga" name="vaga" required min="0">
                </div>
                <div class="form-group">
                    <label for="tipo_vaga">Tipo da vaga</label>
                    <select class="form-control" id="tipo_vaga" name="tipo_vaga" required>
                        <option value="NM">Normal</option>
                        <option value="ID">Idoso</option>
                        <option value="DF">Deficiente</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-vermelho" name="create-vaga">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-table">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Número da Vaga</th>
                        <th scope="col">Tipo da Vaga <span class="badge badge-danger">NM - Normal</span>&nbsp;
                            <span class="badge badge-danger">ID - Idoso</span>&nbsp;
                            <span class="badge badge-danger">DF - Deficiente</span>&nbsp;
                        </th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tblestacionamento";
                    $vagas = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($vagas) > 0) {
                        foreach ($vagas as $vaga) { ?>
                            <tr>
                                <td><?= htmlspecialchars($vaga['estvaga']); ?></td>
                                <td><?= htmlspecialchars($vaga['esttipovaga']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm edit-btn" data-toggle="modal"
                                        data-target="#editModal" data-id="<?= $vaga['estid']; ?>"
                                        data-numero="<?= $vaga['estvaga'] ?>" data-tipo="<?= $vaga['esttipovaga']; ?>">
                                        <span class="bi-pencil-fill"></span>&nbsp;Editar
                                    </button>
                                    <form action="" method="POST" class="d-inline">
                                        <button onclick="return confirm('Tem certeza que deseja excluir a vaga?')" type="submit"
                                            name="delete-vaga" value="<?= $vaga['estid'] ?>" class="btn btn-danger btn-sm"><span
                                                class="bi-trash3-fill"></span>&nbsp;Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo '<h5>Nenhuma vaga cadastrada</h5>';
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('./views/components/footer.php'); ?>
    <!-- Este código inclui o modal (pop-up) de edição das vagas -->
    <?php include('views/components/modal_vagas.php') ?>

</body>

</html>