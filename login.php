<?php
require_once('./config/conexao.php');
session_start();
$mensagem = "";

// Quando clicar no botão "login"
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conexao, $_POST['username']);
    $senha = mysqli_real_escape_string($conexao, $_POST['pass']);

    // Consulta o usuário no banco
    $query = "SELECT * FROM tblusuario WHERE usrnome = '$username' LIMIT 1";
    $resultado = mysqli_query($conexao, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Comparar senha enviada com senha do banco (se usar senha simples)
        if ($senha === $usuario['usrsenha']) {
            // Login correto
            $_SESSION['logado'] = true;
            $_SESSION['usuario'] = $usuario['pesid'];
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
<html lang="pt-br">

<?php include('./views/components/header.php'); ?>

<body class="corpo-login">
    <div class="login-container">
        <div class="card card-login p-4">
            <img src="../assets/images/logo-etec1.png" alt="Logo">
            <h4 class="text-center mb-3 titulo-login">Login</h4>
            <form method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label label-campo">Nome de Usuário</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label label-campo">Senha</label>
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn w-100 btn-login" name='login'>Entrar</button>
                </div>
                <?php if (!empty($mensagem)): ?>
                    <div class="mb-3">
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensagem; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <!--
    <div class='container'>
        <div class='row'>
            <div class='col-lg-4'></div>
            <div class='col-lg-4'>

                <?php if (!empty($mensagem)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $mensagem; ?>
                    </div>
                <?php endif; ?>

                <form method='POST'>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name='username' id="floatingInput" required>
                        <label for="floatingInput">Nome de usuário</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name='pass' id="floatingPassword"
                            placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <input class="btn btn-primary" type="submit" value='Login' name='login'>
                </form>
            </div>
            <div class='col-lg-4'></div>
        </div>
    </div>-->
</body>

</html>