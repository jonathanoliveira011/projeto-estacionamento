<?php

require_once('config/conexao.php');
$mensagem = "";

require_once 'sessao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create-ocorrencia-placa'])) {
    $placa = mysqli_real_escape_string($conexao, $_POST['cpPlaca']);
    $ocorrencia = intval($_POST['cpOcorrencia']);

    if (!empty($placa) && !empty($ocorrencia)) {
        $sql_placa = "SELECT * FROM tblpessoaveiculo WHERE veiplaca = '$placa'";
        $sql_ocorrencia = "SELECT * FROM tblocorrencia WHERE ocoid = '$ocorrencia'";

        $veiculo = mysqli_query($conexao, $sql_placa);
        $ocorrencia = mysqli_query($conexao, $sql_ocorrencia);

        if (mysqli_num_rows($veiculo) > 0) {
            if (mysqli_num_rows($ocorrencia) > 0) {

                $veiculo = mysqli_fetch_assoc($veiculo);
                $ocorrencia = mysqli_fetch_assoc($ocorrencia);

                //Busca telefone da pessoa no banco
                $sql_telefone = "SELECT pesnome, pestelefone FROM tblpessoa WHERE pesid = " . $veiculo['pesid'];

                //Busca o telefone da pessoa
                $telefone = mysqli_query($conexao, $sql_telefone);
                $telefone_pessoa = mysqli_fetch_assoc($telefone);

                //Cria a query para inserir a ocorrência e configura o telefone para envio da mensagem no whatsapp
                $sql_pessoaocorrencia = "INSERT INTO tblpessoaocorrencia (pesid, pveid, ocoid, pocdatahora, pocobservacao) VALUES (" . $veiculo['pesid'] . ", " . $veiculo['pveid'] . ", " . $ocorrencia['ocoid'] . ", NOW(), '" . $ocorrencia['ocodescricao'] . "')";
                $numero = preg_replace('/\D/', '', $telefone_pessoa['pestelefone']);

                // Envia mensagem via WhatsApp
                enviaMensagem($numero, "Olá " . $telefone_pessoa['pesnome'] . ", uma nova ocorrência foi registrada para o veículo de placa: " . $placa . ".\nDescrição da ocorrência: " . $ocorrencia['ocodescricao'] . ".");

                //Verifica se a inserção foi realizada com sucesso
                if (mysqli_query($conexao, $sql_pessoaocorrencia)) {
                    $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Ocorrência enviada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
                } else {
                    $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao cadastrar ocorrência: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span></button></div>";
                }

            } else {
                $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Ocorrência não encontrada.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span></button></div>";
            }

        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Placa não cadastrada.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span></button></div>";
        }
    } else {
        $mensagem = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Por favor, preencha todos os campos!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span></button></div>";
    }
}

function enviaMensagem($numero, $mensagem)
{
    $params = array(
        'token' => 'XXX',
        'to' => '+55' . $numero,
        'body' => $mensagem
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance112404/messages/chat",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" . $err . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span></button></div>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include('views/components/header.php') ?>

<body>
    <?php include('views/components/navbar.php') ?>
    <div class="container-placa">
        <div class="card">
            <div class="card-body">
                <?= $mensagem; ?>
                <h2>Buscar placa</h2>
                <br>
                <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <label for="id_placa">Placa</label>
                        <input type="text" class="form-control" id="id_placa" name="cpPlaca">
                    </div>
                    <?php
                    $sql = "SELECT * FROM tblocorrencia ORDER BY ocodescricao ASC";
                    $ocorrencias = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($ocorrencias) > 0) { ?>
                        <div class="form-group">
                            <label for="id_pessoa">Ocorrências</label>
                            <select class="form-control" id="id_ocorrencia" name="cpOcorrencia" required>
                                <?php foreach ($ocorrencias as $ocorrencia) { ?>
                                    <option value="<?= $ocorrencia['ocoid'] ?>"><?= $ocorrencia['ocodescricao'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php
                    } else { ?>
                        <div class="form-group">
                            <label for="disabledSelect">Perfil</label>
                            <select id="disabledSelect" class="form-control" required>
                                <option>Nenhum curso cadastrado</option>
                            </select>
                        </div>
                    <?php } ?>
                    <div>
                        <button type="submit" class="btn btn-vermelho" name="create-ocorrencia-placa">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include('views/components/footer.php') ?>
</body>

</html>