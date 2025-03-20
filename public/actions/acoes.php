<?php
session_start();
require '../../config/conexao.php';

if (isset($_POST['create_proprietario'])) {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
    $placa = mysqli_real_escape_string($conexao, $_POST['placa']);

    $sql = "INSERT INTO tb_proprietario (nome, telefone, placa) VALUES ('$nome', '$telefone', '$placa')";
    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['msg'] = 'Proprietário cadastrado com sucesso!';
        header('Location: ../views/pages/proprietarios/cadastro-proprietarios.php');
        exit;
    } else {
        $_SESSION['msg'] = 'Erro ao cadastrar proprietário!';
        header('Location: ../views/pages/proprietarios/cadastro-proprietarios.php');
        exit;
    }
}

if (isset($_POST['update_proprietario'])) {
    $_SESSION['update'] = 'true';
    $id_proprietario = mysqli_real_escape_string($conexao, $_POST['id_proprietario']);

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
    $placa = mysqli_real_escape_string($conexao, $_POST['placa']);


    $sql = "UPDATE tb_proprietario SET nome = '$nome', telefone = '$telefone', placa = '$placa'";
    $sql .= " WHERE id_proprietario = $id_proprietario";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['msg'] = 'Proprietário atualizado com sucesso!';
        header('Location: ../views/pages/proprietarios/cadastro-proprietarios.php');
        $_SESSION['update'] = 'false';
        exit;
    } else {
        $_SESSION['msg'] = 'Erro ao atualizar proprietário!';
        header('Location: ../views/pages/proprietarios/cadastro-proprietarios.php');
        $_SESSION['update'] = 'false';
        exit;
    }
}

if (isset($_POST['delete_proprietario'])) {
    $prop_id = mysqli_real_escape_string($conexao, $_POST['delete_proprietario']);
    $sql = "DELETE FROM tb_proprietario WHERE id_proprietario = $prop_id";
    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['msg'] = 'Proprietário excluído com sucesso!';
        header('Location: ../views/pages/proprietarios/cadastro-proprietarios.php');
        exit;
    } else {
        $_SESSION['msg'] = 'Erro ao excluir proprietário!';
        header('Location: ../views/pages/proprietarios/cadastro-proprietarios.php');
        exit;
    }
}

?>