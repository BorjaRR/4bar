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
//esto obtiene todos los datos del cierre menos el listado de platos
$datosCierre = $dao::datosCierre($_SESSION['restaurante']['id']);
//obtenemos todos los platos, los deserializamos como procedemos abajo, y los almacenamos en un array externo.
$arrayPlatos = $dao::platosCierre($_SESSION['restaurante']['id']);
//recorremos el array, y uno a uno metemos los elementos decodificados base64 en otro array.
$arrayPlatosDecode=array();
    foreach($arrayPlatos as $row){
        $row = $dao::decoder($row);
        array_push($arrayPlatosDecode, $row);
    }
//recorremos el array anterior, y uno a uno metemos los elementos volviendo a decodificar de json a objeto en otro array.
$arrayPlatosDecodeJson=array();
    foreach($arrayPlatosDecode as $row){
        $row = json_decode($row);
        array_push($arrayPlatosDecodeJson, $row);
    }
//generamos un último array, y en el introducimos los patos deserializados para obtener un array de objetos.
$platos=array();

foreach($arrayPlatosDecodeJson as $row){
    foreach($row as $elemento){
        $file= unserialize($elemento);
        array_push($platos, $file);
    }
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
                    <div class="row d-flex justify-content-start align-items-center pt-3 titulo">
                        <div class="col-8 text-start">
                            <p class="tx-white text-uppercase">CIERRE DEL DIA</p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-start pt-5 cierreDia">
                        <div class="col-10">
                            <table  class="bg-light w-100 " id="cierreDia">
                                <thead>
                                    <tr>
                                        <td colspan="10" class="bg-success px-4 py-2 text-start">
                                            <p class="mb-0 fw-bold">Fecha: <?php echo date("d/n/Y"); ?></p>
                                            <p class="mb-0 fw-bold">Resultado general de cierre:</p>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="10" class="text-start tx-black px-4 py-2">
                                            <p class="mb-0">Mesas atendidas: <?php echo $datosCierre['mesas'] ?></p>
                                            <p class="mb-0">Comensales totales atendidos: <?php echo $datosCierre['pax'] ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="10"  class="text-start tx-black px-4 py-2">
                                            <p class="mb-0">Listado de platos vendidos</p>
                                        </td>
                                    </tr>
                                    <tr class="tx-black border-black bg-warning">
                                        <th colspan="2" class="border-black">Plato</th>
                                        <th colspan="2" class="border-black">Categoría</th>
                                        <th colspan="2" class="border-black">P. Unitario</th>
                                        <th colspan="2" class="border-black">Cantidad</th>
                                        <th colspan="2" class="border-black">Total</th>
                                    </tr>
                                    <?php
                                    $platos = $dao::generarListadoDiscriminativo($platos, $_SESSION['restaurante']['id']);    
                                    $beneficios=0;
                                    foreach($platos as $li){
                                        $total = $li['precio'] * $li['cantidad'];
                                        echo "<tr class=\"tx-black border-black\">
                                                <th colspan=\"2\" class=\"border-black text-capitalize\">".$li['plato']."</th>
                                                <th colspan=\"2\" class=\"border-black text-capitalize\">".$li['categoria']."</th>
                                                <th colspan=\"2\" class=\"border-black\">".$li['precio']."</th>
                                                <th colspan=\"2\" class=\"border-black\">".$li['cantidad']."</th>
                                                <th colspan=\"2\" class=\"border-black\">".$total."</th>
                                            </tr>";
                                        $beneficios = $beneficios + $total;
                                    }

                                    ?>
                                    <tr class="text-end tx-black">
                                        <td colspan="10" class=" px-4 py-2">
                                            <p class="mb-0">Beneficios totales del día: <?php echo $beneficios?>€</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="./js/main.js"></script>
<!-- tableExport -->
<script src="./js/tableExport/FileSaver.min.js"></script>
<script src="./js/tableExport/Blob.min.js"></script>
<script src="./js/tableExport/xls.core.min.js"></script>
<script src="./js/tableExport/dist/js/tableexport.js"></script>
<script>

$("#cierreDia").tableExport({
        formats: ["xlsx"], //("xlsx","txt", "csv", "xls")
        fileName: "cierre_<?php echo date('d-n-Y');?>",
        exportButtons: true,
        position:'bottom',       
        bootstrap: false,
        headers: true,
        footers: false,
        sheetname:"id"
    });


</script>
<?php
    include_once "./error/errores_cierre.php";
?>
</body>
</html>