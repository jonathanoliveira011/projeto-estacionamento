<script>
    // Carregar marcas ao abrir a página
    fetch('https://parallelum.com.br/fipe/api/v1/carros/marcas')
        .then(response => response.json())
        .then(data => {
            const selectMarca = document.getElementById('marca');
            selectMarca.innerHTML = '<option value="">Selecione a marca</option>';

            data.forEach(marca => {
                const option = document.createElement('option');
                option.value = marca.codigo;
                option.textContent = marca.nome;
                selectMarca.appendChild(option);
            });
        });

    // Carregar modelos ao selecionar uma marca
    document.getElementById('marca').addEventListener('change', function () {
        const marcaId = this.value;
        const selectModelo = document.getElementById('modelo');
        selectModelo.innerHTML = '<option value="">Carregando modelos...</option>';
        selectModelo.disabled = true;

        if (marcaId) {
            fetch(`https://parallelum.com.br/fipe/api/v1/carros/marcas/${marcaId}/modelos`)
                .then(response => response.json())
                .then(data => {
                    selectModelo.innerHTML = '<option value="">Selecione o modelo</option>';
                    data.modelos.forEach(modelo => {
                        const option = document.createElement('option');
                        option.value = modelo.codigo;
                        option.textContent = modelo.nome;
                        selectModelo.appendChild(option);
                    });
                    selectModelo.disabled = false;
                });
        } else {
            selectModelo.innerHTML = '<option value="">Selecione uma marca primeiro</option>';
            selectModelo.disabled = true;
        }
    });
</script>