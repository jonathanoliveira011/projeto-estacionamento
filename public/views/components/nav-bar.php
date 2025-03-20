<?php
$base_url = "/public/views/pages";
?>

<!-- BARRA DE NAVEGAÇÃO -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link text-white" href="projeto-estacionamentov2/public/index.php">PÁGINA INICIAL</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= $base_url ?>/escola.php">CONHEÇA NOSSA
                        ESCOLA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= $base_url ?>/projeto.php">NOSSO
                        PROJETO</a>
                </li>
                <!-- TEMPORÁRIO -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= $base_url ?>/cadastro-proprietarios.php">PROPRIETÁRIOS</a>
                </li>
            </ul>
        </div>
    </div>
</nav>