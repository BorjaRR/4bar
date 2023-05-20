<?php
session_start();
include_once "./complementos/cabecera_main.php";
?>
<body>

<?php
include_once("./clases/DAO.php");
include_once("./clases/Restaurantes.php");
include_once("./clases/Mesas.php");
include_once("./clases/Cuentas.php");
include_once("./clases/Platos.php");


$dao = new Metodos();
$rest = $dao::recuperarRestaurante($_SESSION['restaurante']['email'], $_SESSION['restaurante']['pass']);
if($rest){
    $restaurante = new Restaurante($rest);
}else{
    header("Location:./utils/cierreSesion.php");
}

$cuenta = $dao::localizarCuenta($_REQUEST['num_mesa'], $_SESSION['restaurante']['id']);
$num_mesa = $_REQUEST['num_mesa'];
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
                            <p class="tx-white text-uppercase">CUENTA DE MESA: <?php echo $_REQUEST['num_mesa'] ?></p>
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
                    <div class="row d-flex justify-content-center align-items-start">
                        <div class="col-12 text-start py-4">
                            <a href="main.php" class="volver">Volver al inicio</a>
                        </div>
                        <hr>
                        <div class="col-6 cuenta">
                            <table class="tablaCuenta w-100" style="border:1px solid white">
                                <tr class="bg-gray">
                                    <td>Cantidad</td>
                                    <td>Producto</td>
                                    <td>Precio</td>
                                    <td>Total</td>
                                    <td style="border:none; background-color:transparent;"></td>
                                </tr>
                                <?php
                                    $precioFinal =0;
                                    
                                    $cuenta = $dao::localizarCuenta($_REQUEST['num_mesa'], $_SESSION['restaurante']['id']);
                                    
                                    foreach($_SESSION['cuentasNF'] as $key => $valor){
                                        if($valor['num_mesa']==$_REQUEST['num_mesa']){
                                            for($j=0;$j<sizeof($valor['platos']);$j++){
                                                $plato=unserialize($valor['platos'][$j]);
                                                $cantidad=$plato->getCantidad();
                                                $nombre=$plato->getNombre();
                                                $precio = $plato->getPrecio();
                                                $total=$plato->getCantidad()*$plato->getPrecio();
                                                $precioFinal+=$total;
                                                echo"<tr>
                                                        <td>$cantidad</td>
                                                        <td>$nombre</td>
                                                        <td>$precio</td>
                                                        <td>$total</td>
                                                        <td>
                                                            <a href=\"./utils/eliminarPlatoToMesa.php?num_mesa=$num_mesa&cantidad=$cantidad&nombre=$nombre&
                                                            total=$total\">
                                                                <i class=\"icofont-minus-circle\"></i>
                                                            </a>
                                                        </td>
                                                    </tr>";
                                            }
                                        }
                                    }

                                ?>
                                <tr style="border-top:1px solid white">
                                    <td colspan="3" class="text-end"></td>
                                    <td class="">Subtotal..... <?php echo $precioFinal; ?>€</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"></td>
                                    <td class="">IVA 10%..... <?php $iva = $precioFinal*0.1; echo $iva; ?>€</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"></td>
                                    <td class="">Total........ <?php echo $precioFinal + $iva; ?>€</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="./js/main.js"></script>
<?php
    include "./error/errores_platos.php";
?>
</body>
</html>