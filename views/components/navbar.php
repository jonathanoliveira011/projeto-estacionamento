<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand item-navbar" href="../index.php">ETEC - Monte Mor</a>
    <button class="navbar-toggler btn-drop" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
        <i class="bi bi-list"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">

            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                <!-- MENU VISÍVEL APENAS PARA LOGADOS -->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle item-navbar" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cadastros
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="../frmcadastro_vagas.php">Vagas</a>
                        <a class="dropdown-item" href="../frmcadastro_perfil.php">Perfil</a>
                        <a class="dropdown-item" href="../frmcadastro_curso.php">Curso</a>
                        <a class="dropdown-item" href="../frmcadastro_ocorrencia.php">Ocorrência</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link item-navbar" href="../frmcadastro_veiculo.php">Veículos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link item-navbar" href="../frmcadastro_pessoa.php">Pessoa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link item-navbar" href="../frmrelatorios.php">Relatórios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link item-navbar" href="../frmbusca_placa.php">Buscar placa</a>
                </li>

                <!-- BOTÃO DE LOGOUT -->
                <li class="nav-item">
                    <a class="nav-link item-navbar" href="../logout.php">Sair</a>
                </li>

            <?php else: ?>
                <!-- MENU VISÍVEL PARA VISITANTES (não logados) -->

                <li class="nav-item">
                    <a class="nav-link item-navbar" href="../login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link item-navbar" href="../cadastro.php">Cadastro</a>
                </li>

            <?php endif; ?>

        </ul>
    </div>
</nav>