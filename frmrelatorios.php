<?php

require_once 'sessao.php';
$mensagem = "";

?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include('./views/components/header.php'); ?>

<body>
    <?php include('./views/components/navbar.php'); ?>
    <div class="card card-margin">
        <div class="card-body">
            <h2 class="card-title">Relatórios</h2>
            <form action="gera_relatorio.php" method="POST">
                <div class="row">
                    <div class="col-md-3">
                        <label for="tipo-relatorio">Selecione o relatório desejado:</label>
                        <select name="tipo-relatorio" id="tipo-relatorio" class="form-control"
                            onchange="escondeCampos()">
                            <option value="veiculos_cadastrados">Veículos cadastrados</option>
                            <option value="ocorrencias_registradas">Ocorrências registradas</option>
                            <option value="pessoas_cadastradas">Pessoas cadastradas</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="campo_placa" style="display: none;">
                        <label for="placa">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa" placeholder="Digite a placa">
                    </div>
                    <div class="col-md-3" id="campo_data_inicio" style="display: none;">
                        <label for="data_inicio">Data inicial</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio">
                    </div>
                    <div class="col-md-3" id="campo_data_final" style="display: none;">
                        <label for="data_final">Data final</label>
                        <input type="date" class="form-control" id="data_final" name="data_final">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-vermelho" name="emitir-relatorio">Gerar Relatório</button>
                    </div>
            </form>
        </div>
    </div>
</body>
<script>
    function escondeCampos() {
        const selectRelatorio = document.getElementById('tipo-relatorio');
        const campoPlaca = document.getElementById('campo_placa');
        const campoDataInicio = document.getElementById('campo_data_inicio');
        const campoDataFinal = document.getElementById('campo_data_final');

        switch (selectRelatorio.value) {
            case 'veiculos_cadastrados':
                campoPlaca.style.display = 'none';
                campoDataInicio.style.display = 'none';
                campoDataFinal.style.display = 'none';
                break;
            case 'ocorrencias_registradas':
                campoPlaca.style.display = 'block';
                campoDataInicio.style.display = 'block';
                campoDataFinal.style.display = 'block';
                break;
            default:
                break;
        }
    }
</script>
<?php include('views/components/footer.php') ?>

</html>