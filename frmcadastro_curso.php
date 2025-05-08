<?php
//require './config/conexao.php';

$mensagem = "";

require_once 'sessao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create-curso'])) {
    $nome_curso = isset($_POST['nome_curso']) ? $_POST['nome_curso'] : null;
    $periocidade_curso = isset($_POST['periocidade_curso']) ? $_POST['periocidade_curso'] : null;

    if (!empty($nome_curso) && !empty($periocidade_curso)) {
        $nome_curso_c = mysqli_real_escape_string($conexao, $nome_curso);
        $periocidade_curso_c = mysqli_real_escape_string($conexao, $periocidade_curso);

        $sql = "INSERT INTO tblcurso (curperiodo, curperiodicidade) VALUES ('$nome_curso_c', '$periocidade_curso_c')";

        if (mysqli_query($conexao, $sql)) {
            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Curso cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao cadastrar curso: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
        }
    } else {
        $mensagem = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>Por favor, preencha todos os campos!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button></div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete-curso'])) {
    $curso_id = mysqli_real_escape_string($conexao, $_POST['delete-curso']);
    $sql = "DELETE FROM tblcurso WHERE curid = $curso_id";
    mysqli_query($conexao, $sql);

    if (mysqli_query($conexao, $sql)) {
        $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Curso excluído com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
    } else {
        $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao excluir curso: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update-curso'])) {
    $curso_id = intval($_POST['edit_curso_id']);
    $periodo_novo = mysqli_real_escape_string($conexao, $_POST['edit_curso']);
    $periodicidade_novo = mysqli_real_escape_string($conexao, $_POST['edit_periocidade_curso']);



    if (!empty($curso_id) && !empty($periodo_novo) && !empty($periodicidade_novo)) {
        $sql = "UPDATE tblcurso SET curperiodo = '$periodo_novo', curperiodicidade = '$periodicidade_novo' WHERE curid = '$curso_id'";

        if (mysqli_query($conexao, $sql)) {

            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Curso atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Erro ao atualizar curso: " . mysqli_error($conexao) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
        }
    } else {
        $mensagem = "<div class='alert alert-warning'>Por favor, preencha todos os campos!</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include('./views/components/header.php'); ?>

<body>
    <?php include('./views/components/navbar.php'); ?>

    <div class="card-message"><?= $mensagem; ?></div>
    <div class="card card-margin">
        <div class="card-body">
            <h2>Gerenciamento de Cursos</h2>
            <br>
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <label for="vaga">Período</label>
                    <input type="text" class="form-control" id="nome_curso" name="nome_curso" required>
                </div>
                <div class="form-group">
                    <label for="tipo_vaga">Periodicidade</label>
                    <select class="form-control" id="periocidade_curso" name="periocidade_curso" required>
                        <option value="Bimestre">Bimestre</option>
                        <option value="Semestre">Semestre</option>
                        <option value="Anual">Anual</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-vermelho" name="create-curso">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-table">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Período</th>
                        <th scope="col">Periodicidade</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tblcurso";
                    $cursos = mysqli_query($conexao, $sql);
                    if (mysqli_num_rows($cursos) > 0) {
                        foreach ($cursos as $curso) { ?>
                            <tr>
                                <td><?= htmlspecialchars($curso['curperiodo']); ?></td>
                                <td><?= htmlspecialchars($curso['curperiodicidade']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm edit-btn" data-toggle="modal"
                                        data-target="#editModalCurso" data-id="<?= $curso['curid']; ?>"
                                        data-periodo="<?= $curso['curperiodo'] ?>"
                                        data-periodicidade="<?= $curso['curperiodicidade']; ?>">
                                        <span class="bi-pencil-fill"></span>&nbsp;Editar
                                    </button>
                                    <form action="" method="POST" class="d-inline">
                                        <button onclick="return confirm('Tem certeza que deseja excluir a vaga?')" type="submit"
                                            name="delete-curso" value="<?= $curso['curid'] ?>"
                                            class="btn btn-danger btn-sm"><span
                                                class="bi-trash3-fill"></span>&nbsp;Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo '<h5>Nenhum curso cadastrado</h5>';
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('./views/components/footer.php'); ?>
    <!-- Este código inclui o modal (pop-up) de edição das vagas -->
    <?php include('views/components/modal_curso.php') ?>

</body>

</html>