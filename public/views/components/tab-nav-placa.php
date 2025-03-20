<nav class="nav nav-pills flex-column flex-sm-row">
    <a class="flex-sm-fill text-sm-center nav-link nav-opcao" onclick="<?php buscaPlaca() ?>" href="#">Buscar placa</a>
    <a class="flex-sm-fill text-sm-center nav-link nav-opcao" onclick="<?php cadastroPlaca() ?>" href="#">Cadastrar
        placa</a>
</nav>

<?php

function buscaPlaca()
{
    $GLOBALS['aba'] = 'busca-placa';
}
function cadastroPlaca()
{
    $GLOBALS['aba'] = 'cadastro-placa';
}

?>