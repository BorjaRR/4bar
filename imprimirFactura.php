
<?php
session_start();
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
$num_factura=$_REQUEST['num_factura'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="./css/styles_main.css">
    <style>
        
    </style>
    <!--JQUERY SCRIPT-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>	
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script>
        $(document).ready(function(){
            imprimirPDF();
        })
        function imprimirPDF() {

            var pdf = new jsPDF('p', 'mm', 'a4');
            pdf.addHTML($('#hojaFactura')[0], function () {
                pdf.setTextColor(255,0,0);
                pdf.save('factura_<?php echo $num_factura;?>.pdf');
            });
            
        }
    </script>
    <!-- fuente zen kurenaido -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet"> 
<title>4BAR</title>
</head>

<body>
    <div class="container-fluid index">
        <div class="row d-flex justify-content-center align-items-start" style="width:70%;justify-content:center;">
            <div class="col-10 p-4 hojaFactura" id="hojaFactura">
                <table style="width:100%;border:none; color:#000 !important;">
                    <tr style="margin-bottom:10px; margin-bottom:10px;border:none">
                        <td colspan="4" style="text-align:center;border:none;color:#000;">
                            <h2>FACTURA COMPLETA</h2>
                        </td>
                    </tr>
                    <tr style="margin-bottom:10px;margin-bottom:10px;border:none">
                        <td style="width:35%;border:none">
                            <p style="margin-bottom:0; margin-top:2rem;">Datos del restaurante:</p>
                            <hr style="margin:1rem 0;">
                            <div style="background-color:#bebebe; padding: 1rem;">
                                <p style="margin-bottom:0;"><?php echo $_SESSION['restaurante']['nombre']; ?></p>
                                <p style="margin-bottom:0;">NIF <?php echo $_SESSION['restaurante']['nif']; ?></p>
                                <p style="margin-bottom:0;"><?php echo $_SESSION['restaurante']['direccion']; ?></p>
                                <p style="margin-bottom:0;">Email: <?php echo $_SESSION['restaurante']['email']; ?></p>
                                <p>Teléfono: <?php echo $_SESSION['restaurante']['telefono']; ?></p>
                            </div>
                        </td>
                        <td colspan="2" style="width:35%;border:none">
                            
                        </td>
                        <td  style="width:35%;border:none;">
                            <div style="border:1px solid black; padding:1rem 2rem; margin-bottom:1rem;">
                                <p>Fecha de emisión: <?php echo $factura['fecha']; ?></p>
                                <p>N. de factura: <?php echo $factura['num_factura']; ?></p>
                                <p>ID de factura: <?php echo $factura['id']; ?></p>
                            </div>
                            <div class="px-2"  style="padding:0 1rem;">
                                <p style="margin-bottom:4rem;">Sello del restaurante</p>
                            </div>
                        </td>
                    </tr>
                    <tr style="margin-bottom:10px;margin-bottom:10px;border:none; padding-left:3rem;">
                        <td class="text-start my-3" colspan="4" style="text-align:start;border:none;margin:2rem">
                            <p class="mb-0 mt-3">Datos del cliente</p>
                            <hr class="my-2">
                            <div class="bg-gray ps-3">
                                <p class="mb-0">Nombre de la empresa: <?php echo $factura['empresa']; ?></p>
                                <p class="mb-0">Dirección fiscal: <?php echo $factura['direccion']; ?>, <?php echo $factura['cp']." ". $factura['ciudad']." ".$factura['provincia']; ?></p>
                                <p class="">Teléfono: <?php echo $factura['telefono'];?></p>
                            </div>
                        </td>
                    </tr>
                
                    <tr style="margin-bottom:10px;background-color:#bebebe;border:none;">
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
                    <tr style="margin-bottom:10px;border:none;">
                        <td style="width:35%;background-color:#bebebe;border:none;" class="ps-3">
                            <p>Observaciones:</p>
                            <p><?php echo $factura['observaciones'];?></p>
                        </td>
                        <td style="border:none;" colspan="2"></td>
                        <td class="text-end" style="width:35%;border:none;">
                            <?php
                                $precio = $factura['precio'];
                                $iva = $precio*0.1;
                                $precioFinal = $precio*$iva;
                            ?>
                            <p style="background-color:#bebebe;padding:1rem;margin-bottom:0;">
                            Subtotal:
                            <?php echo $precio;?>€
                            </p>
                            <p style="background-color:#e7e7e7;padding:1rem;margin-bottom:0;">IVA: <?php echo $iva;?>€</p>
                            <p style="background-color:#bebebe;padding:1rem;margin-bottom:0;">Total: <?php echo $precioFinal;?>€</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


<script src="./js/main.js"></script>

</body>
</html>