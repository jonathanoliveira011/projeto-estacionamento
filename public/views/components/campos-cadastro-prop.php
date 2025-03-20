<h1 class="titulo-cadastro">Cadastro de proprietários</h1>
<form class="formulario" action="../../../actions/acoes.php" method="POST">
    <input type="hidden" name="id_proprietario" value="<?= $proprietario['id_proprietario'] ?>">
    <div class="form-group">
        <label for="nome" class="label-login">Nome do proprietário</label>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Fulano da Silva" required>
    </div>
    <div class="form-group">
        <label for="telefone" class="label-login">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(xx) xxxxx-xxxx" required>
    </div>
    <div class="form-group">
        <label for="placa" class="label-login">Placa</label>
        <input type="text" class="form-control" id="placa" name="placa" placeholder="AAA1234/AAA1C34" required>
    </div>
    <button type="submit" class="btn btn-cadastrar" name="create_proprietario">Cadastrar</button>
</form>