<link rel="stylesheet" href="../../../../assets/css/busca-placa.css">
<h1 class="titulo-placa">Digite a placa</h1>
<div class="container-form">
    <form action="">
        <input type="text" class="form-control" id="input-placa" placeholder="AAA1234/AAA1C34">
        <!-- OPÇÕES AVISO -->
        <div class="container mt-4 d-flex justify-content-center gap-3">
            <div class="form-check">
                <input type="radio" class="form-check-input" name="aviso" id="pneuFurado">
                <label class="btn-selecao" for="pneuFurado">
                    <img src="../../../../assets/images/pneu-furado.png" alt="Pneu Furado">
                    <span>Pneu Furado</span>
                </label>
            </div>

            <div class="form-check">
                <input type="radio" class="form-check-input" name="aviso" id="farolAceso">
                <label class="btn-selecao" for="farolAceso">
                    <img src="../../../../assets/images/farol-aceso.png" alt="Farol Aceso">
                    <span>Farol Aceso</span>
                </label>
            </div>

            <div class="form-check">
                <input type="radio" class="form-check-input" name="aviso" id="carroAberto">
                <label class="btn-selecao" for="carroAberto">
                    <img src="../../../../assets/images/carro-aberto.png" alt="Carro Aberto">
                    <span>Carro Aberto</span>
                </label>
            </div>

            <div class="form-check">
                <input type="radio" class="form-check-input" name="aviso" id="alarmeDisparado">
                <label class="btn-selecao" for="alarmeDisparado">
                    <img src="../../../../assets/images/alarme-disparado.png" alt="Alarme Disparado">
                    <span>Alarme Disparado</span>
                </label>
            </div>

            <div class="form-check">
                <input type="radio" class="form-check-input" name="aviso" id="outrosAvisos">
                <label class="btn-selecao" for="outrosAvisos">
                    <img src="../../../../assets/images/outros-avisos.png" alt="Outros Avisos">
                    <span>Outros avisos</span>
                </label>
            </div>
        </div>
        <!-- FIM OPÇÕES AVISO -->
        <button type="submit" name="envio-aviso" class="btn btn-aviso">Enviar aviso&nbsp;&nbsp;<i
                class="bi bi-arrow-right"></i></button>
    </form>
</div>