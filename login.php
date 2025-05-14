<?php
require_once('./config/conexao.php');
session_start();
$mensagem = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conexao, $_POST['username']);
    $senha = mysqli_real_escape_string($conexao, $_POST['pass']);

    // Consulta o usuário no banco
    $query = "SELECT * FROM tblusuario WHERE usrnome = '$username' LIMIT 1";
    $resultado = mysqli_query($conexao, $query);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
        if ($senha === $usuario['usrsenha']) {
            // Verifica se o usuário está ativo
            if ($usuario['usrstatus'] == 1) {
                // Verifica se a senha é temporária
                if ($usuario['usrsenha_temporaria'] == 1) {
                    $_SESSION['user_id'] = $usuario['pesid'];
                    header('Location: frmsenha_temporaria.php');
                } else {
                    $_SESSION['logado'] = true;
                    $_SESSION['usuario'] = $usuario['pesid'];
                    header('Location: index.php');
                }
            } else {
                $mensagem = "Usuário inativo.";
            }
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
                    <label for="pass" class="form-label label-campo">Senha</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="pass" name="pass" required>
                        <div class="input-group-append">
                            <button class="btn btn-login" type="button" id="show-password"><i class="bi bi-eye-fill"
                                    id="icon-pass"></i></button>
                        </div>
                    </div>
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
    <script>
        document.getElementById('show-password').addEventListener('click', function () {
            var passwordField = document.getElementById('pass');
            var icon = document.getElementById('icon-pass');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        });
    </script>
</body>

</html>