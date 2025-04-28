<?php
session_start();
include('config/conexao.php'); // sua conexão com o banco

$mensagem = "";

// Quando o formulário for enviado
if (isset($_POST['cadastrar'])) {
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['pass']);

    // Criptografa a senha
    $senhaSegura = password_hash($senha, PASSWORD_DEFAULT);

    // Insere no banco
    $query = "INSERT INTO usuarios (email, senha) VALUES ('$email', '$senhaSegura')";

    if (mysqli_query($conexao, $query)) {
        $mensagem = "Usuário cadastrado com sucesso! Agora faça login.";
        header('Location: login.php');
        exit();
    } else {
        $mensagem = "Erro ao cadastrar usuário: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <div class='container'>
        <div class='row'>
            <div class='col-lg-4'></div>
            <div class='col-lg-4'>

            <!-- Mensagem de erro ou sucesso -->
            <?php if (!empty($mensagem)): ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>

            <form method='POST'>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Cadastrar Novo Usuário</h4>
                    <p>Preencha os campos abaixo:</p>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name='email' id="floatingInput" placeholder="name@example.com" required>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name='pass' id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <input class="btn btn-success" type="submit" value='Cadastrar' name='cadastrar'>
            </form>
            </div>
            <div class='col-lg-4'></div>
        </div>
    </div>
</body>
</html>
