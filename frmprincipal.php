<?php

//Contador de pessoas cadastradas
$sql = "select count(pesnome) from tblpessoa";
$pessoas = mysqli_query($conexao, $sql);
try {
    $contagem_pessoas = mysqli_fetch_array($pessoas);
} catch (Exception $e) {
    echo "Erro ao buscar dados: " . $e->getMessage();
}

//Contador de veículos cadastrados
$sql = "select count(veiplaca) from tblpessoaveiculo";
$veiculos = mysqli_query($conexao, $sql);
try {
    $contagem_veiculos = mysqli_fetch_array($veiculos);
} catch (Exception $e) {
    echo "Erro ao buscar dados: " . $e->getMessage();
}

//Contador de vagas cadastradas
$sql = "select count(estvaga) from tblestacionamento";
$vagas = mysqli_query($conexao, $sql);
try {
    $contagem_vagas = mysqli_fetch_array($vagas);
} catch (Exception $e) {
    echo "Erro ao buscar dados: " . $e->getMessage();
}

//Contador de ocorrências registradas
$sql = "select count(pocid) from tblpessoaocorrencia";
$ocorrencias = mysqli_query($conexao, $sql);
try {
    $contagem_ocorrencias = mysqli_fetch_array($ocorrencias);
} catch (Exception $e) {
    echo "Erro ao buscar dados: " . $e->getMessage();
}

?>
<div class="card" style="margin: 1em 2em;">
    <div class="card-body">
        <div class="container-projeto">
            <h1 class="titulo-projeto">Conheça nosso projeto</h1>
            <p class="paragrafo-projeto">
                Nós somos alunos da faculdade Univesp e criamos esse projeto com intuito de auxiliar a escola Etec Monte
                Mor
                a identificar os veículos e seus respectivos donos em caso de problemas no estacionamento.
                Nosso trabalho será entregue a matéria de Projeto Integrador I.
            </p>
            <ul class="lista-projeto">
                <li class="item-projeto">Desenvolvedores:
                    <span class="texto-projeto">Abner, Andrezza, Celso, Flavio, Jonathan, Leandro e Lucas</span>
                </li>
                <li class="item-projeto">Orientador:
                    <span class="texto-projeto">Prof. Gabriel Vitoriano Braga</span>
                </li>
                <li class="item-projeto">Cursos:
                    <span class="texto-projeto">Tecnologia de Informação | Ciência de Dados | Engenharia da
                        Computação</span>
                </li>
                <li class="item-projeto">Faculdade:
                    <span class="texto-projeto">Univesp</span>
                </li>
            </ul>
            <p class="paragrafo-projeto">
                Esse projeto foi desenvolvido com o intuito de auxiliar a escola Etec Monte Mor a identificar os
                veículos e seus respectivos donos em caso de problemas no estacionamento.
            </p>
        </div>
    </div>
</div>

<!-- Campos de exibição -->
<div class="card card-vaga">
    <div class="card-body">
        <h3 class="titulo-dash">Dashboard</h3>
        <div class="row">

            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Usuários cadastrados</h6>
                        <h3 class="card-title"><?= $contagem_pessoas[0] ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Veículos cadastrados</h6>
                        <h3 class="card-title"><?= $contagem_veiculos[0] ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Vagas cadastradas</h6>
                        <h3 class="card-title"><?= $contagem_vagas[0] ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Quantidade de ocorrências registradas</h6>
                        <h3 class="card-title"><?= $contagem_ocorrencias[0] ?></h3>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>