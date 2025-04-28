<?php
session_start();
include('config/conexao.php');

// Se não estiver logado, manda pro login
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: login.php');
    exit();
}
?>