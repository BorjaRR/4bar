<?php
session_start();
include_once "./complementos/cabecera_main.php";
?>
<body>

<?php
include_once("./clases/DAO.php");
include_once("./clases/Restaurantes.php");
include_once("./clases/Reservas.php");

$dao = new Metodos();
$rest = $dao::recuperarRestaurante($_SESSION['restaurante']['email'], $_SESSION['restaurante']['pass']);
if($rest){
    $restaurante = new Restaurante($rest);
}else{
    header("Location:./utils/cierreSesion.php");
}

if(isset($_REQUEST['fecha'])){
    $fecha = explode("-", $_REQUEST['fecha']);
    $dia=$fecha[2];
    $mes=$fecha[1];
    $ano=$fecha[0];
}else{
    $dia=date('d');
    $mes=date('n');
    $ano=date('Y');
}
switch ($mes){
    case 1:
        $mes='Enero';
        break;
    case 2:
        $mes='Febrero';
        break;
    case 3:
        $mes='Marzo';
        break;
    case 4:
        $mes='Abril';
        break;
    case 5:
        $mes='Mayo';
        break;
    case 6:
        $mes='Junio';
        break;
    case 7:
        $mes='Julio';
        break;
    case 8:
        $mes='Agosto';
        break;
    case 9:
        $mes='Septiembre';
        break;
    case 10:
        $mes='Octubre';
        break;
    case 11:
        $mes='Noviembre';
        break;
    case 12:
        $mes='Diciembre';
        break;
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
                            <p class="tx-white text-uppercase">Reservas</p>
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
                    <div class="row d-flex justify-content-start align-items-start mes">
                        <div class="col-8 py-3">
                            <h2>
                                <?php echo $dia." de ".$mes;?>
                                <a href="generarReserva.php?fecha=<?php if(isset($_REQUEST['fecha'])){echo $_REQUEST['fecha'];}else{echo date('Y-n-d');} ?>"><i class="icofont-plus-circle ms-3"></i></a>
                            </h2>
                        </div>
                        <div class="col-4 py-3">
                            <p>
                                <form action="reservas.php" method="post" class="buscarDia">
                                    <label for="fecha">Buscar día</label>
                                    <input type="date" name="fecha" id="fecha" class="fecha" value="<?php echo date('Y-n-d'); ?>">
                                    <button>
                                        <i class="icofont-search-2"></i>
                                    </button>
                                </form>
                            </p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-start align-items-start px-5 pt-4">
                        <?php
                            if(isset($_REQUEST['fecha'])){
                                $fecha = "'".$_REQUEST['fecha']."'";
                            }else{
                                $fecha = "'".date('Y-n-d')."'";
                            }
                            
                            $reservas = $dao::listarReservas($fecha, $_SESSION['restaurante']['id']);
                            for($i=0;$i<sizeof($reservas);$i++){
                                
                                if($i%2==0){$bg="bg-postit-amarillo";}else{$bg="bg-postit-verde";};
                                if($i%2==0){$rotate="rotateS";}else{$rotate="rotateE";};
                                echo "
                                <div class=\"col-2 mx-3 my-4 postit text-start $rotate $bg\">
                                    <img src=\"./img/chincheta.png\" alt=\"chincheta\" class=\"chincheta\">
                                    <p class=\"nombre my-2\">".$reservas[$i]['nombre']."</p>
                                    <p class=\"fecha mb-0\">".$reservas[$i]['fecha']." - ". substr($reservas[$i]['hora'], 0, 5) ."</p>
                                    <p class=\"comensales mb-0\">".$reservas[$i]['comensales']." pax</p>
                                    <p class=\"telefono mb-0\">".$reservas[$i]['telefono']."</p>
                                    <a href=\"#\" onclick=\"eliminar_reserva(".$reservas[$i]['id'].");\">
                                        <i class=\"icofont-bin\"></i>
                                    </a>
                                </div>
                                ";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

<script src="./js/main.js"></script>
<script>
     function eliminar_reserva(id){
        Swal
            .fire({
                title: "Introduce código de seguridad",
                input: "password",
                showCancelButton: true,
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
                inputValidator: codigo => {
                    // Si el valor es válido, debes regresar undefined. Si no, una cadena
                    if (!codigo) {
                        return "Por favor escribe tu codigo";
                    } else {
                        return undefined;
                    }
                }
            })
            .then(resultado => {
                if (resultado.value) {
                    let codigo = resultado.value;
                    window.location.replace("./utils/eliminarReserva.php?id="+id+"&num_conf="+codigo);
                }
        });
    }
</script>
<?php
    include "./error/errores_reservas.php";
?>
</body>
</html>