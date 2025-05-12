<?php
require_once 'sessao.php';
require 'vendor/autoload.php';
use Dompdf\Dompdf;

function gerarRelatorio($conteudo, $nome_relatorio, $orientacao)
{
    $dompdf = new Dompdf();
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->loadHtml($conteudo);
    $dompdf->setPaper('A4', $orientacao);
    $dompdf->render();
    $dompdf->stream("relatorio_" . $nome_relatorio . ".pdf", array("Attachment" => true));
    header('Location: frmrelatorios.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emitir-relatorio'])) {
    $tipo_relatorio = mysqli_real_escape_string($conexao, $_POST['tipo-relatorio']);

    switch ($tipo_relatorio) {
        case 'veiculos_cadastrados':
            $sql_veiculos = "select V.veimarca, V.veimodelo, V.veiplaca, P.pesnome, P.pesrm from tblpessoaveiculo V INNER JOIN tblpessoa P ON V.pesid = P.pesid;";
            $resultado_veiculos = mysqli_query($conexao, $sql_veiculos);

            $css = file_get_contents("assets/css/relatorios.css");
            $conteudo_html = "<html><head>";
            $conteudo_html .= "
                <style>$css</style>
            ";
            $conteudo_html .= "</head>
                <body>
                    <div class='box_title'><h1>Relatório de Veículos Cadastrados</h1></div>
                    <p>Este relatório apresenta os veículos registrados até o momento.</p>
                    <table>
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Nome do Proprietário</th>
                                <th>RM do Proprietário</th>
                            </tr>
                        </thead>
                        <tbody>";

            while ($row = mysqli_fetch_assoc($resultado_veiculos)) {
                $conteudo_html .= "<tr><td>{$row['veiplaca']}</td><td>{$row['veimarca']}</td><td>{$row['veimodelo']}</td>
                <td>{$row['pesnome']}</td><td>{$row['pesrm']}</td></tr>";
            }

            $conteudo_html .= "</tbody></table></body></html>";

            gerarRelatorio($conteudo_html, $tipo_relatorio, 'portrait');
            break;


        case 'ocorrencias_registradas':
            $placa = mysqli_real_escape_string($conexao, $_POST['placa']);
            $data_inicio = mysqli_real_escape_string($conexao, $_POST['data_inicio']);
            $data_final = mysqli_real_escape_string($conexao, $_POST['data_final']);

            if (!empty($placa)) {
                $sql_ocorrencias = "SELECT 
                                    P.pesnome, 
                                    P.pesrm, 
                                    V.veiplaca, 
                                    O.pocdatahora, 
                                    O.pocobservacao 
                                    FROM 
                                    tblpessoaocorrencia O 
                                    INNER JOIN tblpessoa P ON O.pesid = P.pesid 
                                    INNER JOIN tblpessoaveiculo V ON O.pveid = V.pveid 
                                    INNER JOIN tblocorrencia OC ON O.ocoid = OC.ocoid 
                                    WHERE 
                                    O.pocdatahora BETWEEN '$data_inicio' AND '$data_final 23:59:59'
                                    AND V.veiplaca = '$placa';";
            } else {
                $sql_ocorrencias = "SELECT 
                                    P.pesnome, 
                                    P.pesrm, 
                                    V.veiplaca, 
                                    O.pocdatahora, 
                                    O.pocobservacao 
                                    FROM 
                                    tblpessoaocorrencia O 
                                    INNER JOIN tblpessoa P ON O.pesid = P.pesid 
                                    INNER JOIN tblpessoaveiculo V ON O.pveid = V.pveid 
                                    INNER JOIN tblocorrencia OC ON O.ocoid = OC.ocoid 
                                    WHERE 
                                    O.pocdatahora BETWEEN '$data_inicio' AND '$data_final 23:59:59';";
            }

            $resultado_ocorrencias = mysqli_query($conexao, $sql_ocorrencias);

            $css = file_get_contents("assets/css/relatorios.css");
            $conteudo_html = "<html><head>";
            $conteudo_html .= "
                <style>$css</style>
            ";
            $conteudo_html .= "</head>
                <body>
                    <div class='box_title'><h1>Relatório de Ocorrências Registradas</h1></div>
                    <p>Este relatório apresenta os registros de ocorrências registradas.</p>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome do proprietário</th>
                                <th>RM do proprietário</th>
                                <th>Placa</th>
                                <th>Data e Hora</th>
                                <th>Ocorrência</th>
                            </tr>
                        </thead>
                        <tbody>";

            while ($row = mysqli_fetch_assoc($resultado_ocorrencias)) {
                $data_conv = date('d/m/Y H:i', strtotime($row['pocdatahora']));

                $conteudo_html .= "<tr><td>{$row['pesnome']}</td><td>{$row['pesrm']}</td><td>{$row['veiplaca']}</td>
                <td>{$data_conv}</td><td>{$row['pocobservacao']}</td></tr>";
            }

            $conteudo_html .= "</tbody></table></body></html>";
            gerarRelatorio($conteudo_html, $tipo_relatorio, 'portrait');
            break;

        case 'pessoas_cadastradas':
            $sql_pessoas = "select P.pesrm, P.pesnome, P.pesemail, P.pescpf, P.pestelefone, P.pesturma, P.pesobservacao, C.curperiodo, C.curperiodicidade from tblpessoa P INNER JOIN tblcurso C ON P.curid = C.curid;";
            $resultado_pessoas = mysqli_query($conexao, $sql_pessoas);

            $css = file_get_contents("assets/css/relatorios.css");
            $conteudo_html = "<html><head>";
            $conteudo_html .= "
                <style>$css</style>
            ";
            $conteudo_html .= "</head>
                <body>
                    <div class='box_title'><h1>Relatório de Pessoas Cadastradas</h1></div>
                    <p>Este relatório apresenta as pessoas cadastradas.</p>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>RM</th>
                                <th>Email</th>
                                <th>CPF</th>
                                <th>Telefone</th>
                                <th>Turma</th>
                                <th>Observação</th>
                                <th>Período</th>
                                <th>Periodicidade</th>
                            </tr>
                        </thead>
                        <tbody>";

            while ($row = mysqli_fetch_assoc($resultado_pessoas)) {
                $conteudo_html .= "<tr><td>{$row['pesnome']}</td><td>{$row['pesrm']}</td><td>{$row['pesemail']}</td>
                <td>{$row['pescpf']}</td><td>{$row['pestelefone']}</td><td>{$row['pesturma']}</td><td>{$row['pesobservacao']}</td><td>{$row['curperiodo']}</td><td>{$row['curperiodicidade']}</td></tr>";
            }

            $conteudo_html .= "</tbody></table></body></html>";
            gerarRelatorio($conteudo_html, $tipo_relatorio, 'landscape');
            break;

        default:
            exit("Relatório inválido.");
    }
}
?>