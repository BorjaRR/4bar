<?php
session_start();
include_once "./complementos/cabecera_main.php";
?>
<body>

<?php
include_once("./clases/DAO.php");
include_once("./clases/Restaurantes.php");

$dao = new Metodos();
$rest = $dao::recuperarRestaurante($_SESSION['restaurante']['email'], $_SESSION['restaurante']['pass']);
if($rest){
    $restaurante = new Restaurante($rest);
}else{
    header("Location:./utils/cierreSesion.php");
}
$fecha=$_REQUEST['fecha'];
$fechaF=explode("-", $fecha);
$fechaFormateada=$fechaF[2]."-".$fechaF[1]."-".$fechaF[0];
?>
    <div class="container-fluid index">
        <div class="row d-flex justify-content-center align-items-start">

            <div class="col-2 text-center tx-white menu p-0 sticky-top">
                <?php
                    include_once "./menu/menu.php";
                ?>
            </div>

            <div class="col-10 text-center tx-white pizarra p-0">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center align-items-center pt-3 titulo">
                        <div class="col-8 text-start">
                            <p class="tx-white text-uppercase">NUEVA RESERVA</p>
                        </div>
                        <div class="col-4">
                            <p class="fecha m-0">
                                <?php echo date("d-n-y"); ?>
                            </p>
                            <p class="comensales m-0">
                                <?php
                                $res = $dao::contarReservas($restaurante->getId());

                                ?>
                                Nº de reservas: <?php echo $res[0]; ?> (<?php echo $res[1]; ?>pax)
                            </p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-start align-items-start">
                        <div class="col-12 my-4 px-5 text-start">
                            <h4>Formulario de registro de nueva reserva para el dia <?php echo $fechaFormateada ?></h4>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-start align-items-start reservas">
                        <div class="col-5 text-start">
                            <form action="./utils/addReserva.php" method="get" class="nuevaFactura d-flex px-5 ">
                                <div class="columna-izquierda w-50">
                                    <label for="nombre">Nombre de la reserva</label>
                                    <input type="text" name="nombre" id="nombre" required>

                                    <label for="comensales">Comensales</label>
                                    <input type="text" name="comensales" id="comensales" class="esNumero" minlength="1" required>

                                    <label for="fecha">Fecha de la reserva</label>
                                    <input type="text" name="fecha" id="fecha" value="<?php echo $fecha ?>"required readonly>

                                    <label for="hora">Hora de la reserva*</label>
                                    <select name="hora" id="hora" class="my-2 d-block">
                                        <?php include "./complementos/seleccionHoras.php"; ?>
                                    </select>
    
                                    <label for="telefono">Teléfono de contacto</label>
                                    <input type="text" name="telefono" id="telefono" class="esNumero"  minlength="9" maxlength="9"required>

                                    <button id="generarReserva"><i class="icofont-plus-circle"></i> Añadir reserva</button>
                                </div>
                            </form>  
                        </div>
                        <div class="col-3 text-center pe-5 nota">
                            <div class="postit sqr"></div>
                            <div class="postit bg-postit-amarillo p-3">
                                <p class="tituloNota">
                                    Sugerencia:
                                </p>
                                <p>Recuerda indicar el nombre y apellidos de la reserva, asi como
                                    el número de comensales y un teléfono de contacto.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


<script src="./js/main.js"></script>
<?php
    include "./error/errores_facturas.php";
?>
</body>
</html>