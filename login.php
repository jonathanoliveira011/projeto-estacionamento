<?php
session_start(); // Inicia a sessão no topo sempre
include('config/conexao.php'); // Sua conexão com o banco
$mensagem = "";

// Quando clicar no botão "login"
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['pass']);

    // Consulta o usuário no banco
    $query = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $resultado = mysqli_query($conexao, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Comparar senha enviada com senha do banco (se usar senha simples)
        if ($senha === $usuario['senha']) {
            // Login correto
            $_SESSION['logado'] = true;
            $_SESSION['usuario'] = $usuario['email'];
            header('Location: index.php');
            exit();
        } else {
            $mensagem = "Senha incorreta.";
        }
    } else {
        $mensagem = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Page</title>
</head>
<body>
    <div class='container'>
        <div class='row'>
            <div class='col-lg-4'></div>
            <div class='col-lg-4'>

            <!-- Mostra mensagem de erro, se tiver -->
            <?php if (!empty($mensagem)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>

            <form method='POST'>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Login</h4>
                    <p>Digite as suas credenciais!</p>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name='email' id="floatingInput" placeholder="name@example.com" required>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name='pass' id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <input class="btn btn-primary" type="submit" value='Login' name='login'>
            </form>
            </div>
            <div class='col-lg-4'></div>
        </div>
    </div>
</body>
</html>