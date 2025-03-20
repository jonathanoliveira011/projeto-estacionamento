<div class="container-tabela">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tb_proprietario";
                $proprietarios = mysqli_query($conexao, $sql);
                if (mysqli_num_rows($proprietarios) > 0) {
                    foreach ($proprietarios as $proprietario) {
                        ?>

                        <tr>
                            <td><?= $proprietario['nome'] ?></td>
                            <td><?= $proprietario['telefone'] ?></td>
                            <td><?= $proprietario['placa'] ?></td>
                            <td>
                                <a href="../pages/proprietarios/cadastro-proprietarios.php?id=<?= $proprietario['id_proprietario'] ?>"
                                    class="btn btn-success btn-sm"><span class="bi-pencil-fill"></span>&nbsp;Editar</a>
                                <form action="../../../actions/acoes.php" method="POST" class="d-inline">
                                    <button onclick="return confirm('Tem certeza que deseja excluir o proprietário ?')"
                                        type="submit" name="delete_proprietario" value="<?= $proprietario['id_proprietario'] ?>"
                                        class="btn btn-danger btn-sm"><span class="bi-trash3-fill"></span>&nbsp;Excluir</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<h5>Nenhum proprietário cadastrado</h5>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>