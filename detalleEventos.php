<?php
include_once 'rest/core_functions.php';
include_once 'layout/header.php';
include_once 'layout/navegacion.php';

$id =  base64_decode($_GET['id']);
$datosJson = file_get_contents("https://trailer.roman-company.com/TrailerMovilApiRest/view/evento.php/unico?id_evento=" . $id);

//$datosJson = file_get_contents("http://localhost/TrailerMovilApiRest/view/evento.php/unico?id_evento=". $id);
$products = json_decode($datosJson, true);
//var_dump($products);
$nombre = $products['datos']['nombre'];
$detalle = $products['datos']['detalle'];
$ubicacion = $products['datos']['ubicacion'];
$foto = $products['datos']['foto'];
$array_tiempo = explode(" ", $products['datos']['fecha_evento']);
$fecha_evento = $array_tiempo[0];
$hora_evento = $array_tiempo[1];
$precio = $products['datos']['precio'];
$estado = $products['datos']['estado'];
$contador_cards = 0;
$isDisponible = $products['datos']['numBoletosDisponibles'];

// JSON VARIABLES 
$data = file_get_contents('https://trailer.roman-company.com/TrailerMovilApiRest/view/evento.php?estado=active');

//$data = file_get_contents('http://localhost/TrailerMovilApiRest/view/evento.php?estado=active');


$eventos = json_decode($data)->datos;

include_once 'layout/header.php';
include_once 'layout/navegacion.php';

?>
<script src="js/jquery-3.6.0.js"></script>
<!-- Product section-->
<section id="complete-detail" class="py-5 text-white">
    <div class="detalle-evento">
        <div class="container px-4 px-lg-5 ">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                <?php
                                if($isDisponible == 0)
                                {
                             ?>
                             <span class="badge bg-danger" style="position: absolute;z-index: 99;margin: 5px;">AGOTADO</span>
                             <?php } ?>

                   <img class="card-img-top mb-5 mb-md-0" src="<?php echo $foto ?>" alt="<?php echo $nombre; ?>" /></div>
                <div class="col-md-6">


                    <h1 class="display-5 fw-bolder titulo-eve"><?php echo $nombre ?></h1>
                    <div class="row">
                        <div class="col-6">
                            <p class="time">Fecha:<span> <?php echo $fecha_evento ?> </span></p>
                        </div>
                        <div class="col-6">
                            <p class="time">Hora:<span> <?php echo $hora_evento ?> </span></p>
                        </div>

                        <div class="fs-1 precio-eve">
                            <span><?php echo  '$' . number_format($precio, 2) ?></span>

                        </div>
                        <div class="row ubi-eve">
                            <span> <?php echo $ubicacion ?> </span>
                        </div>
                        <p class="lead"><?php echo $detalle ?></p>

                        <?php
                                if($isDisponible > 0)
                                {
                             ?>
                             <div class="d-flex end_buttons">
                            <div class="col-1 boton_contador_eventos " onclick="subtractContadorProducts(this)">
                                <i class="bi bi-chevron-left"></i>
                            </div>
                            <p class="text-cont col-1" id="cantidad-asientos-event">1</p>
                            <div class="col-1 boton_contador_eventos" onclick="addContadorProducts(this,<?php echo $isDisponible; ?>)">
                                <i class="bi bi-chevron-right"></i>
                            </div>

              

                             <?php } ?>

                        
                    </div>
                </div>
            </div>
        </div>
</section>


<?php
                                if($isDisponible > 0)
                                {
                             ?>
                             <div id="paypal-button-container"></div>

              

                             <?php } ?>



<!-- mas eventos  -->
<section class="mas_eventos">
    <h2>Eventos Sugeridos </h2>
    <div class="container-fluid py-5 bg-dark">
        <div class="container">
            <div class="row g-5 d-flex justify-content-center justify-content-md-evenly" id="container-cards">
                <?php foreach ($eventos as $evento) :
                    $fecha = explode(" ", $evento->fecha_evento)[1];
                    $id_evento = base64_encode($evento->id_evento);
                    $isDisponibleMore = $evento->numBoletosDisponibles;

                    if ($id == ($evento->id_evento)) {
                        continue;
                    }
                ?>
                    <!-- card -->
                    <div class="col-12 col-sm-6 col-md-5 col-lg-3">
                        <div class="card m-auto border-0">
                            <div class="image-wrapper-card">
                            <?php
                                if($isDisponibleMore == 0)
                                {
                             ?>
                             <span class="badge bg-danger" style="position: absolute;z-index: 99;right: 0;margin: 5px;">AGOTADO</span>
                             <?php } ?>

                                <img src="<?php echo $evento->foto; ?>" alt="<?php echo $evento->nombre; ?>">
                            </div>
                            <div class="card-body text-center">
                                <h3 class="card-title"><?php echo $evento->nombre; ?></h3>
                                <p class="event-price-card"><i class="bi bi-currency-dollar"></i><strong><?php echo number_format($evento->precio, 2); ?></strong></p=>
                                <p><i class="bi bi-calendar-date"></i> <strong><?php echo $fecha; ?></strong></p>
                                <p><i class="bi bi-geo-alt-fill"></i> <strong><?php echo $evento->ubicacion; ?></strong></p>
                                <a href="<?php echo "./detalleEventos.php?id=" . $id_evento; ?>" class="btn btn-card btn-purple">Ver más</a>
                            </div>
                        </div>
                    </div>
                    <!-- card /> -->

                <?php
                    $contador_cards++;
                    if ($contador_cards >= 4) {
                        break;
                    }
                endforeach; ?>
            </div>
        </div>
    </div>
    <div class="container-button-fixed">
        <button class="btn-float btn-purple" id="btn-top"><i class="bi bi-caret-up-fill"></i></button>
    </div>
</section>

<style>
    #paypal-button-container{
        display:flex;
        margin-top:1.5rem;
        justify-content: center;
    }
</style>

<script src="https://www.paypal.com/sdk/js?client-id=AW5M_dedVij9riC3tZgWWL7mY7oXZFbWmZiv3oVcwbpRhzt5AhHp_x9Q1WmVLRLiaxgXgkomfSZJvVPx&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>

<script>
    let compra  = null
    var precio = 0
    var cantBoletos = 0

   
    function initPayPalButton() {
        console.log("INIT PAYPAL BUTTON")
        paypal.Buttons({
            style: {
                shape: 'pill',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',

            },

            createOrder: function(data, actions) 
            {
                cantBoletos = document.getElementById('cantidad-asientos-event').innerText
                let precioEvento = '<?php echo $precio;?>'
                console.log("cantBoletos :  "+cantBoletos)

                precio = cantBoletos * parseFloat(precioEvento)
                console.log("precio :  "+precio)

                return actions.order.create({
                    purchase_units: [{"amount":{"currency_code":"USD","value":precio.toFixed(2)}}]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData)
                {
                    console.log('COMPRA REALIZADA CON EXITO')
                    // Full available details
                    /*console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                    console.log("//////////////////////////////////////////////////////////")*/
                    var jsonData = JSON.parse(JSON.stringify(orderData))
                    compra = jsonData.purchase_units[0].payments.captures[0].id;

                    // Show a success message within this page, e.g.
                    /*const element = document.getElementById('paypal-button-container');
                    element.innerHTML = '';
                    element.innerHTML = '<h3>Thank you for your payment!</h3>';*/
                    
                    saveBD(precio,compra,cantBoletos)



                    // Or go to another URL:  actions.redirect('thank_you.html');

                });
            },

            onError: function(err)
            {
                compra = null
                console.log(err);
            }
        }).render('#paypal-button-container');
    }
    console.log("INIT PAYPAL")
    initPayPalButton();
    function saveBD(total_,recibo_,boletos_)
    {
        /**
         * in evento_ int,in email varchar(70),in total decimal(10,2),in cantBoletos_ smallint,
                                       in recibopaypal text
         * **/
        var url = "https://trailer.roman-company.com/TrailerMovilApiRest/view/compras.php"

        //var url = "http://localhost/TrailerMovilApiRest/view/compras.php"

        $.ajax({
            url: url,
            method:"POST",
            data:JSON.stringify({
                email:'<?php echo $_SESSION["email"];?>',
                evento : '<?php echo $id;?>',
                total : total_,
                cantBoletos : boletos_,
                recibopaypal : recibo_
            })
        }).done(function(datos)
        {
            var json_string = JSON.stringify(datos)
            var json_parse = JSON.parse(json_string)

            if (json_parse.status == 200)
            {

                Swal.fire({
                    title: 'Pago realizado con éxito',
                    text: "ID transacción #"+compra,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#61428f',
                    allowOutsideClick:false,
                    confirmButtonText: 'Seguir Comprando'
                }).then((result) =>
                {
                    window.location.href = "./index.php"
                })

            }else{
                Swal.fire(
                    'Error BASE DATOS ROMMAN COMPANY',
                    'No se ha podido guardar el pago.',
                    'error'
                )
            }

        }).fail(function(error)
        {
            console.log("ERROR REGISTRO BD")
            console.log(error)
            alert('ERROR SERVER ROMMAN COMPANY')
        })
    }
</script>

<?php
include_once 'layout/footer.php';
?>

