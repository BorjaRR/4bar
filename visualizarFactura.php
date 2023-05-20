<?php
session_start();
include_once "./complementos/cabecera_main.php";
?>
<body>

<?php
include_once("./clases/DAO.php");
include_once("./clases/Restaurantes.php");
include_once("./clases/Platos.php");


$dao = new Metodos();
$rest = $dao::recuperarRestaurante($_SESSION['restaurante']['email'], $_SESSION['restaurante']['pass']);
if($rest){
    $restaurante = new Restaurante($rest);
}else{
    header("Location:./utils/cierreSesion.php");
}

$factura = $dao::localizarFactura($_REQUEST['num_factura'], $_SESSION['restaurante']['id']);
// print_r($factura);
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
                            <p class="tx-white text-uppercase">FACTURA NÚMERO <?php echo $_REQUEST['num_factura'] ?></p>
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
                    <div class="row d-flex justify-content-center align-items-start platos">
                        <div class="col-12 text-center py-4">
                            <a href="historialFacturas.php" class="volver">Volver al historial</a>
                        </div>
                        <div class="col-10 p-4 mb-5 hojaFactura" id="hojaFactura">
                            <div class="container-fluid">
                                <div class="row d-flex justify-content-center align-items-start">
                                    <div class="col-12">
                                        <p class="text-uppercase">Factura completa</p>
                                    </div>
                                    <div class="col-4 bg-gray text-start">
                                        <p class="mb-0 mt-3">Datos del restaurante:</p>
                                        <hr class="my-2">
                                        <p class="mb-0"><?php echo $_SESSION['restaurante']['nombre']; ?></p>
                                        <p class="mb-0">NIF <?php echo $_SESSION['restaurante']['NIF']; ?></p>
                                        <p class="mb-0"><?php echo $_SESSION['restaurante']['direccion']; ?></p>
                                        <p class="mb-0">Email: <?php echo $_SESSION['restaurante']['email']; ?></p>
                                        <p>Teléfono: <?php echo $_SESSION['restaurante']['telefono']; ?></p>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-4 text-start p-0">
                                        
                                        <div class="bg-gray px-3 pb-2 mb-2">
                                            <p>Fecha de emisión: <?php echo $factura['fecha']; ?></p>
                                            <p>N. de factura: <?php echo $factura['num_factura']; ?></p>
                                            <p>ID de factura: <?php echo $factura['id']; ?></p>
                                        </div>
                                        <div class="px-2">
                                            <p style="margin-bottom:4rem;">Sello del restaurante</p>
                                        </div>
                                    </div>
                                    <div class="col-12 text-start bg-gray my-3">
                                        <p class="mb-0 mt-3">Datos del cliente</p>
                                        <hr class="my-2">
                                        <p class="mb-0">Nombre de la empresa: <?php echo $factura['empresa']; ?></p>
                                        <p class="mb-0">Dirección fiscal: <?php echo $factura['direccion']; ?>, <?php echo $factura['cp']." ". $factura['ciudad']." ".$factura['provincia']; ?></p>
                                        <p class="">Teléfono: <?php echo $factura['telefono'];?></p>
                                    </div>
                                    <div class="col-12 tablaFactura text-start mb-3 p-0">
                                        <table class="w-100">
                                            <tr class="bg-gray">
                                                <th>Cantidad</th>
                                                <th>Descripcion</th>
                                                <th>PVP</th>
                                                <th>Total</th>
                                            </tr>
                                            <?php
                                                $platos = $dao->decoder($factura['platos']);
                                                $platos = json_decode($platos);
                                                // print_r($platos);
                                                for($i=0;$i<sizeof($platos);$i++){
                                                    $plato = unserialize($platos[$i]);
                                                    $nombre=$plato->getNombre();
                                                    $cantidad=$plato->getCantidad();
                                                    $precio=$plato->getPrecio();
                                                    $total = $precio*$cantidad;
                                                    echo "
                                                    <tr>
                                                        <td>".$nombre."</td>
                                                        <td>".$cantidad."</td>
                                                        <td class=\"text-end\">".$precio."</td>
                                                        <td class=\"text-end\">".$total."</td>
                                                    </tr>
                                                    ";
                                                }
                                            ?>
                                        </table>
                                    </div>
                                    <div class="col-4 bg-gray">
                                        <p>Observaciones:</p>
                                        <p><?php echo $factura['observaciones'];?></p>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-4 text-end p-0">
                                        <?php
                                            $precio = $factura['precio'];
                                            $iva = $precio*0.1;
                                            $precioIva = $precio+$iva;
                                        ?>
                                        <p class="bg-gray p-2 mb-0">
                                            Subtotal:
                                            <?php echo $precio;?>€
                                        </p>
                                        <p class="bg-lightgray p-2 mb-0">IVA 10%: <?php echo $iva;?></p>
                                        <p class="bg-gray p-2 mb-0">Total con IVA: <?php echo $precioIva;?>€</p>    
                                    </div>
                                    <div class="col-12 mt-3">
                                        <a href="imprimirFactura.php?num_factura=<?php echo $_REQUEST['num_factura']; ?>" class="btn btn-primary">Descargar PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="./js/main.js"></script>

</script>
</body>
</html>