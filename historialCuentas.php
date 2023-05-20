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
                            <p class="tx-white text-uppercase">Listado de cuentas</p>
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
                        <div class="col-6 my-3">
                            <h4>Cuentas NO FINALIZADAS</h4>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-start align-items-start platos">
                        <div class="col-12">
                            <table class="tablaCuentasNF w-100">
                                <tr class="titulos">
                                    <th class="text-center ps-4 text-uppercase">Número de mesa</th>
                                    <th class="text-center ps-3 text-uppercase">Comensales</th>
                                    <th class="text-center ps-3 text-uppercase">Fecha</th>
                                    <th class="text-center ps-3 text-uppercase">Hora de llegada</th>
                                </tr>
                                
                                <?php
                                $cuentasNF = $dao::listarCuentasNoFinalizadas($_SESSION['restaurante']['id']);

                                if(!empty($cuentasNF)){
                                    
                                    for($i=0;$i<sizeof($cuentasNF);$i++){
                                        $num_mesa=$cuentasNF[$i]['num_mesa'];
                                        $comensales=$cuentasNF[$i]['comensales'];
                                        $fecha=$cuentasNF[$i]['fecha'];
                                        $hora=$cuentasNF[$i]['hora'];
                                        if($i%2==0){$color="blanco";}else{$color="gris";}
                                        echo "
                                            <tr>
                                                <td class=\"text-center ps-3 text-uppercase bg-$color num_mesa\">$num_mesa</td>
                                                <td class=\"text-center ps-3 bg-$color comensales\">$comensales</td>
                                                <td class=\"text-center ps-3 text-capitalize bg-$color fecha\">$fecha</td>
                                                <td class=\"text-center ps-3 bg-$color hora\">$hora</td>
                                            </tr>
                                        ";
                                    }
                                    
                                }
                                if(!isset($_SESSION['cuentasNF'])){
                                    $_SESSION['cuentasNF']=$cuentasNF;
                                }
                                
                                ?>
                            </table>                            
                        </div>
                        
                    </div>

                    <div class="row d-flex justify-content-start align-items-start">
                        <div class="col-6 my-3 mt-5">
                            <h4>Cuentas FINALIZADAS</h4>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-start align-items-start platos">
                        <div class="col-12">
                            <table class="tablaCuentas w-100">
                                <tr class="titulos">
                                    <th class="text-center ps-4 text-uppercase">Número de Mesa</th>
                                    <th class="text-center ps-3 text-uppercase">Comensales</th>
                                    <th class="text-center ps-3 text-uppercase">Fecha</th>
                                    <th class="text-center ps-3 text-uppercase">Hora de llegada</th>
                                    <th class="text-center ps-3 text-uppercase"></th>
                                </tr>
                                
                                <?php
                                $platos = $dao::listarPlatos($_SESSION['restaurante']['id']);
                                $cuentas = $dao::listarCuentasFinalizadas($_SESSION['restaurante']['id']);
                                if(!empty($cuentas)){
                                    
                                    for($i=0;$i<sizeof($cuentas);$i++){
                                        $id_cuenta=$cuentas[$i]['id'];
                                        $id_mesa=$cuentas[$i]['id_mesa'];
                                        $num_mesa=$cuentas[$i]['num_mesa'];
                                        $comensales=$cuentas[$i]['comensales'];
                                        $fecha=$cuentas[$i]['fecha'];
                                        $precio=$cuentas[$i]['precio'];
                                        $hora=$cuentas[$i]['hora'];
                                        if($i%2==0){$color="blanco";}else{$color="gris";}
                                        echo "
                                            <tr>
                                                <td class=\"text-center ps-3 text-uppercase bg-$color num_mesa\">$num_mesa</td>
                                                <td class=\"text-center ps-3 bg-$color comensales\">$comensales</td>
                                                <td class=\"text-center ps-3 text-capitalize bg-$color fecha\">$fecha</td>
                                                <td class=\"text-center ps-3 bg-$color hora\">$hora</td>
                                                <td class=\"text-center ps-3 factura\"><a href=\"generarFactura.php?id_cuenta=$id_cuenta&id_mesa=$id_mesa\"><i class=\"icofont-attachment\"></i></a></td>
                                            </tr>
                                        ";
                                    }
                                }
                                if(!isset($_SESSION['cuentas'])){
                                    $_SESSION['cuentas']=$cuentas;
                                }
                                ?>
                            </table>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="./js/main.js"></script>

</body>
</html>