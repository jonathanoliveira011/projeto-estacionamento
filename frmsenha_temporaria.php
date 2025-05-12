<?php
session_start();
require_once('./config/conexao.php');
$mensagem = "";

if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $query = "SELECT * FROM tblusuario WHERE pesid = $id";
    $resultado = mysqli_query($conexao, $query);
    $usuario = mysqli_fetch_assoc($resultado);

    if ($usuario['usrsenha_temporaria'] == 0) {
        header('Location: index.php');
        exit();
    }
}

if (isset($_POST['senha_temporaria']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['user_id'];
    $nova_senha = mysqli_real_escape_string($conexao, $_POST['pass']);
    //$nova_senha = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    $sql = "UPDATE tblusuario SET usrsenha = '$nova_senha', usrsenha_temporaria = 0 WHERE pesid = '$id'";
    mysqli_query($conexao, $sql);

    unset($_SESSION['user_id']);
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<?php include('./views/components/header.php'); ?>

<body class="corpo-login">
    <div class="login-container">
        <div class="card card-login p-4">
            <h4 class="text-center mb-3 titulo-senha">Alterar senha</h4>
            <p class="subtitulo-senha">A senha digita foi uma senha temporária. Digite a senha desejada para alteração
                no sistema.</p>
            <form method="POST">
                <div class="mb-3">
                    <label for="senha" class="form-label label-campo">Senha</label>
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn w-100 btn-login" name='senha_temporaria'>Alterar senha
                        temporária</button>
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
</body>

</html>