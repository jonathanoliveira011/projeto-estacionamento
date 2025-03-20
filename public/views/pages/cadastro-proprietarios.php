<?php
session_start();
$GLOBALS['aba'] = 'busca-placa';
require '../../../config/conexao.php';
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Controle de Estacionamento - Etec Monte Mor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../../assets/css/cadastro-proprietario.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include('../components/nav-bar.php') ?>
    <!-- PÁGINA PRINCIPAL -->
    <div class="card">
        <div class="card-body">
            <?php
            include('../components/tab-nav-placa.php');
            if ($_SESSION['aba'] == 'busca-placa') {
                include('../components/campos-cadastro-prop.php');
                include('../components/tabela-proprietarios.php');
            } else {
                include('../components/form-busca-placa.php');
            }
            ?>
        </div>
    </div>
</body>

</html>