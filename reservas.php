<?php
include_once 'layout/header.php';
include_once 'layout/navegacion.php';

?>

<div class="containerReservasAsiento">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="display: none">
                <h5 class="modal-title" id="exampleModalLabel">Seleccione su asiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="d-flex justify-content-around">
                        <div class="d-flex flex-column align-items-center">
                            <p>Disponible</p>
                            <label for="1" class="asiento">
                                <input type="checkbox" disabled name="asientos" id="1" class="check">
                                <img src="./img/chair.svg" class="img-chair">
                                <span></span>
                                <p>A-1</p>
                            </label>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <p>Seleccionado</p>
                            <label for="" class="asiento">
                                <input type="checkbox" checked disabled name="asientos" class="check">
                                <img src="./img/chair.svg" class="img-chair">
                                <span></span>
                                <p>A-2</p>
                            </label>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <p>Reservado</p>
                            <label for="" class="asiento reserved">
                                <input type="checkbox" name="asientos" disabled class="check">
                                <img src="./img/chair.svg" class="img-chair">
                                <span></span>
                                <p>A-3</p>
                            </label>
                        </div>
                    </div>
                </div>
                <br>
                <!--<h3 class="text-center my-3">Listado de asientos</h3>-->
                <div class="container">
                    <div class="row d-flex justify-content-center" id="contenedor-asientos"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-purple">Guardar reservación</button>
            </div>
        </div>
    </div>
</div>

<?php
include_once "carritoDeCompras.php";
include_once 'layout/footer.php';
?>

<script>
    generarAsientos(35)
</script>

<style>

    .modal-footer {
        display: flex;
        flex-wrap: wrap;
        flex-shrink: 0;
        align-items: center;
        justify-content: flex-end;
        padding: 0.75rem;
        /* border-top: 1px solid #dee2e6; */
        /* border-bottom-right-radius: calc(0.3rem - 1px); */
        /* border-bottom-left-radius: calc(0.3rem - 1px); */
    }

    .containerReservasAsiento{
        height: auto;
        width: 100vw;
        background-color: white;
    }
    .modal-dialog{
        margin: 0px auto !important;
    }

    .modal-content {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: white;
        background-clip: padding-box;
        border: 0px solid rgba(0,0,0,0);
        border-bottom: 0px;
        border-radius: 0rem;
        outline: 0;
    }

    .modal-body {
        position: relative;
        flex: 1 1 auto;
        /* padding: 1rem; */
    }

</style>
