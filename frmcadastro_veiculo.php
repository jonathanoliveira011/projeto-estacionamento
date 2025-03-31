<?php

require('config/conexao.php');
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create-veiculo'])) {
    $id_pessoa = intval($_POST['cpProp']);
    $marca = mysqli_real_escape_string($conexao, $_POST['nome_marca']);
    $modelo = mysqli_real_escape_string($conexao, $_POST['nome_modelo']);
    $placa = mysqli_real_escape_string($conexao, $_POST['nome_placa']);

    if (!empty($id_pessoa) && !empty($marca) && !empty($modelo) && !empty($placa)) {
        $sql = "INSERT INTO tblpessoaveiculo (pesid, veimarca, veimodelo, veiplaca) VALUES ('$id_pessoa', '$marca','$modelo','$placa')";

        if (mysqli_query($conexao, $sql)) {
            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Veículo cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao cadastrar veículo: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
        }
    } else {
        $mensagem = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Por favor, preencha todos os campos!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete-veiculo'])) {
    $veiculo_id = mysqli_real_escape_string($conexao, $_POST['delete-veiculo']);
    $sql = "DELETE FROM tblpessoaveiculo WHERE pveid = $veiculo_id";
    mysqli_query($conexao, $sql);

    if (mysqli_query($conexao, $sql)) {
        $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Veículo excluído com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
    } else {
        $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao excluir veículo: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-veiculo'])) {
    $id_veiculo = intval($_POST['edit_veiculo_id']);
    $id_pessoa = intval($_POST['cpProp']);
    $marca = mysqli_real_escape_string($conexao, $_POST['edit_marca']);
    $modelo = mysqli_real_escape_string($conexao, $_POST['edit_modelo']);
    $placa = mysqli_real_escape_string($conexao, $_POST['edit_placa']);
    
    if (!empty($id_veiculo) && !empty($id_pessoa) && !empty($marca) && !empty($modelo) && !empty($placa)) {
        $sql = "UPDATE tblpessoaveiculo SET pesid = '$id_pessoa', veimarca = '$marca', veimodelo = '$modelo', veiplaca = '$placa' WHERE pveid = '$id_veiculo'";

        if (mysqli_query($conexao, $sql)) {

            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Veículo atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao atualizar veículo: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
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
<?php include('views/components/header.php') ?>

<body>
    <?php include('views/components/navbar.php') ?>

    <div class="card-message"><?= $mensagem; ?></div>
    <div class="card card-vagas">
        <div class="card-body">
            <h2>Gerenciamento de veículos</h2>
            <br>
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="form-row">
                <div class="col-md-3">
                    <?php
                    $sql = "SELECT * FROM tblpessoa";
                    $pessoas = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($pessoas) > 0) { ?>
                        <div class="form-group">
                            <label for="selectPerfil">Pessoas</label>
                            <select class="form-control" id="selectPerfil" name="cpProp" required>

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
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="vaga">Marca</label>
                        <input type="text" class="form-control" id="marca" name="nome_marca" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="vaga">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="nome_modelo" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="vaga">Placa</label>
                        <input type="text" class="form-control" id="placa" name="nome_placa" required>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-vermelho" name="create-veiculo">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-table">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Placa</th>
                        <th scope="col">Proprietário</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select V.pveid, V.veimarca, V.veimodelo, V.veiplaca, P.pesnome, P.pesid FROM tblpessoaveiculo V INNER JOIN tblpessoa P ON V.pesid = P.pesid";
                    $veiculos = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($veiculos) > 0) {
                        foreach ($veiculos as $veiculo) { ?>
                            <tr>
                                <td><?= htmlspecialchars($veiculo['veimarca']); ?></td>
                                <td><?= htmlspecialchars($veiculo['veimodelo']); ?></td>
                                <td><?= htmlspecialchars($veiculo['veiplaca']); ?></td>
                                <td><?= htmlspecialchars($veiculo['pesnome']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm edit-btn" data-toggle="modal"
                                        data-target="#editModalVeiculo" data-id="<?= $veiculo['pveid'] ?>" data-pessoa="<?= $veiculo['pesid'] ?>"
                                        data-marca="<?= $veiculo['veimarca'] ?>" data-modelo="<?= $veiculo['veimodelo'] ?>"
                                        data-placa="<?= $veiculo['veiplaca'] ?>">
                                        <span class="bi-pencil-fill"></span>&nbsp;Editar
                                    </button>
                                    <form action="" method="POST" class="d-inline">
                                        <button onclick="return confirm('Tem certeza que deseja excluir a vaga?')" type="submit"
                                            class="btn btn-danger btn-sm" value="<?= $veiculo['pveid'] ?>"
                                            name="delete-veiculo"><span class="bi-trash3-fill"></span>&nbsp;Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo '<h5>Nenhum veículo cadastrado</h5>';
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('views/components/footer.php') ?>
    <?php include('views/components/modal_veiculo.php') ?>
</body>

</html>