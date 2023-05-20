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
                            <p class="tx-white text-uppercase">Listado de facturas</p>
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
                    <div class="row d-flex justify-content-start align-items-start platos">
                        <div class="col-12 text-start py-3"> 
                            <a href="?limit=10"><i class="icofont-plus-circle"></i> Mostrar 10 más</a> 
                        </div>
                        <div class="col-12">
                            <table class="tablaFacturas w-100">
                                <tr class="titulos">
                                    <th class="text-center ps-4 text-uppercase">Id</th>
                                    <th class="text-center ps-3 text-uppercase">Fecha</th>
                                    <th class="text-center ps-3 text-uppercase">Empresa</th>
                                    <th class="text-center ps-3 text-uppercase">Contacto</th>
                                    <th class="text-center ps-3 text-uppercase"></th>
                                </tr>
                                
                                <?php
                                //el limite es de 10, cada vez que añado 10 el limite cambia
                                if(!isset($_REQUEST['limit'])){
                                    $_SESSION['limiteFacturas'] = 10;
                                }
                                else{
                                    $_SESSION['limiteFacturas']= $_REQUEST['limit'] + $_SESSION['limiteFacturas'];
                                }
                                
                                $facturas = $dao::listarFacturas($_SESSION['restaurante']['id'], $_SESSION['limiteFacturas']);
                                if(!empty($facturas)){
                                    
                                    for($i=0;$i<sizeof($facturas);$i++){
                                        $id=$facturas[$i]['num_factura'];
                                        $fecha=$facturas[$i]['fecha'];
                                        $empresa=$facturas[$i]['empresa'];
                                        $contacto=$facturas[$i]['contacto'];
                                        if($i%2==0){$color="blanco";}else{$color="gris";}
                                        echo "
                                            <tr>
                                                <td class=\"text-center ps-3 text-uppercase bg-$color num_factura\"><span>$id</span></td>
                                                <td class=\"text-center ps-3 bg-$color fecha\">$fecha</td>
                                                <td class=\"text-center ps-3 text-capitalize bg-$color empresa\">$empresa</td>
                                                <td class=\"text-center ps-3 text-capitalize bg-$color contacto\">$contacto</td>
                                                <td class=\"text-center ps-3 text-capitalize acciones\">
                                                    <a href=\"visualizarFactura.php?num_factura=$id\"><i class=\"icofont-eye\"></i></a>
                                                    <a href=\"imprimirFactura.php?num_factura=$id\"><i class=\"icofont-print\"></i></a>
                                                    <a href=\"#\" onclick=\"enviarFactura($id);\">
                                                        <i class=\"icofont-email\"></i>
                                                    </a>
                                                    <form action=\"./utils/eliminarFactura.php\" method=\"post\" class=\"d-inline\">
                                                        <button type=\"submit\"><i class=\"icofont-bin borrarFactura\"></i></button>
                                                        <input type=\"password\" name=\"num_conf\" id=\"num_conf\" class=\"num_conf esNumero\" maxlength=\"4\" required>
                                                        <input type=\"hidden\" name=\"id\" value=\"$id\">
                                                    </form>
                                                </td>
                                            </tr>
                                        ";
                                    }
                                    
                                }
                                $_SESSION['facturas']=$facturas;
                                ?>
                            </table>     
                                                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="./js/main.js"></script>
<script>
function enviarFactura(id){
        Swal
            .fire({
                title: "Introduce email para enviar factura:",
                input: "email",
                showCancelButton: true,
                confirmButtonText: "Enviar",
                cancelButtonText: "Cancelar",
                inputValidator: email => {
                    // Si el valor es válido, debes regresar undefined. Si no, una cadena
                    if (!email) {
                        return "Por favor escribe un email";
                    } else {
                        return undefined;
                    }
                }
            })
            .then(resultado => {
                if (resultado.value) {
                    let email = resultado.value;
                    window.location.replace("./utils/enviarFactura.php?num_factura="+id+"&email="+email);
                }
        });
    }
</script>
<?php
    include "./error/errores_facturas.php";
?>
</body>
</html>