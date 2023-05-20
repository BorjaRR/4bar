<?php
session_start();
include_once "./complementos/cabecera_main.php";
?>
<body>

<?php
include_once("./clases/DAO.php");
include_once("./clases/Restaurantes.php");

//si entro de nuevas, se genera un session de restaurante, si no entro de nuevas pero existe, entro igualmente, y si entro sin existir $_SESSION me expulsa
$dao = new Metodos();
if(isset($_REQUEST['em'])&&isset($_REQUEST['ps'])){

    $email = $dao::decoder($_REQUEST['em']);
    $pass = $dao::decoder($_REQUEST['ps']);
    $_SESSION['restaurante'] =  $dao::recuperarRestaurante($email, $pass);
    $restaurante = new Restaurante($_SESSION['restaurante']);

    //si al entrar a la app se cerró mal el dia anterior, esto borra todas las mesas no finalizadas. NO DEBERIA LLEGAR A USARSE pero puede ocurrir. USO: Control de errores.
    $dao::arreglarMesasNoFinalizadas(date("Y-n-d"), $restaurante->getId()); 

}else if(isset($_SESSION['restaurante'])){
    $restaurante = new Restaurante($_SESSION['restaurante']);
}else{
    header("Location:./utils/cierreSesion.php");
}

//si se cerrara la app, se borraria todo el array de Session, pero al entrar si en bbdd hay mesas con fecha de hoy sin finalizar, las incluye y sus cuentas
if(!isset($_SESSION['mesas'])){
    $_SESSION['mesas']=array();
    $mesas=$dao::listarMesas($_SESSION['restaurante']['id']);
    foreach($mesas as $mesa){
        array_push($_SESSION['mesas'], $mesa);
    }
}
if(!isset($_SESSION['cuentasNF'])){
    $_SESSION['cuentasNF']=array();
    $cuentas=$dao::listarMesas($_SESSION['restaurante']['id']);
    foreach($cuentas as $cuenta){
        array_push($_SESSION['cuentasNF'], $cuenta);
    }
}
if(!isset($_SESSION['cuentas'])){
    $_SESSION['cuentas']=array();
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
                            <p class="tx-white text-uppercase">INICIO</p>
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
                        <div class="col-12 text-start">
                            <form action="./utils/addMesa.php" method="post" class="formulario d-flex">
                                <button type="submit" class="addMesa">
                                    <p class="m-0 py-2">
                                        <i class="icofont-plus-circle"></i>
                                        Añadir mesa
                                    </p>
                                </button>
                                <input type="text" name="mesa" id="mesa" placeholder="Número de mesa" class="mx-3 esNumero" min="1" required>
                                <input type="text" name="comensales" id="comensales" placeholder="Número de comensales"
                                 min="1" class="esNumero" required>
                            </form>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-start align-items-start mesas">
                        <?php
                        $mesas = $dao::listarMesas($restaurante->getId());
                        if(!empty($mesas)){
                            for($i=0;$i<sizeof($mesas);$i++){
                                $id=$mesas[$i]['id'];
                                $num_mesa=$mesas[$i]['num_mesa'];
                                $comensales=$mesas[$i]['comensales'];
                                $hora=$mesas[$i]['hora'];
                            
                            echo "
                                <div id=\"mesa\" class=\"col-3 p-5\">
                                    <h5 class=\"pax fw-bold\">$num_mesa (".$comensales."px)</h5>
                                    <img src=\"./img/mesa.png\" 
                                    alt=\"Mesa\" 
                                    class=\"img-fluid mesa\">
                                    <div class=\"iconos mt-4 py-1 d-none\">
                                        <!--
                                        <a href=\"#\" class=\"icono\">
                                            <i class=\"icofont-plus-circle\"></i>
                                        </a>
                                        -->
                                        <a href=\"visualizarCuenta.php?num_mesa=$num_mesa\" class=\"icono\">
                                            <i class=\"icofont-eye\"></i>
                                        </a>
                                        <a href=\"#\" class=\"icono\" onclick=\"finalizar_num_seg($id, $num_mesa);\">
                                            <i class=\"icofont-check-circled\"></i>
                                        </a>
                                        <a href=\"#\" class=\"icono\" onclick=\"eliminar_num_seg($id, $num_mesa);\">
                                            <i class=\"icofont-close-circled\" ></i>
                                        </a>
                                    </div>
                                </div>
                            ";
                            }
                            $_SESSION['mesas']=$mesas;
                        }
                        ?>
                    </div>
                    <!-- <?php
                        echo"<br>------------MESAS-----------------</br>";
                        print_r($_SESSION['mesas']);
                        // unset($_SESSION['mesas']);
                        echo"<br>--------------NO FINALIZADAS---------------</br>";
                        print_r($_SESSION['cuentasNF']);
                        // unset($_SESSION['cuentasNF']);
                        echo"<br>----------------FINALIZADAS-------------</br>";
                        print_r($_SESSION['cuentas']);
                        // unset($_SESSION['cuentas']);
                        echo"<br>----------------PRUEBAS-------------</br>";
                    ?> -->
                </div>
            </div>
        </div>
    </div>


<script src="./js/main.js"></script>
<script>
    function eliminar_num_seg(id, num_mesa){
        Swal
            .fire({
                title: "Introduce código de seguridad",
                input: "password",
                showCancelButton: true,
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar",
                inputValidator: codigo => {
                    // Si el valor es válido, debes regresar undefined. Si no, una cadena
                    if (!codigo) {
                        return "Por favor escribe tu codigo";
                    }else {
                        return undefined;
                    }
                }
            })
            .then(resultado => {
                if (resultado.value) {
                    let codigo = resultado.value;
                    window.location.replace("./utils/eliminarMesa.php?id="+id+"&num_mesa="+num_mesa+"&num_conf="+codigo);
                }
        });
    }
    function finalizar_num_seg(id, num_mesa){
        Swal
            .fire({
                title: "Introduce código de seguridad",
                input: "password",
                showCancelButton: true,
                confirmButtonText: "Finalizar",
                cancelButtonText: "Cancelar",
                inputValidator: codigo => {
                    // Si el valor es válido, debes regresar undefined. Si no, una cadena
                    if (!codigo) {
                        return "Por favor escribe tu codigo";
                    }else {
                        return undefined;
                    }
                }
            })
            .then(resultado => {
                if (resultado.value) {
                    let codigo = resultado.value;
                    window.location.replace("./utils/finalizarMesa.php?id="+id+"&num_mesa="+num_mesa+"&num_conf="+codigo);
                }
        });
    }
</script>
<?php
    include "./error/errores_main.php";
?>
</body>
</html>