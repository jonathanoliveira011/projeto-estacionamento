<?php

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', 'Agora@2025AgoraNows');
define('DBNAME', 'bdestacionamento');

$conexao = mysqli_connect(HOST, USER, PASS, DBNAME) or die('Não foi possível conectar');

$conne=mysqli_connect(HOST, USER, PASS, DBNAME);
if(isset($_POST['login'])){
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    $query = 'SELECT * FROM tblusuario WHERE email=? and usrsenha=?';
    $stmt=mysqli_prepare($conne,$query);
    mysqli_stmt_bind_param($stmt,'ss',$email,$pass);
    mysqli_stmt_execute($stmt);
    if(mysqli_stmt_fetch($stmt)){
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $usuario;
        echo "<script type='text/javascript'>alert('Logado com sucesso!');window.location.href='index.php';</script>";
    }else{
        echo 'Usuario ou senha inválidos.';
    }
 }

?>