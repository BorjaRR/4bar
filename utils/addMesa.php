<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Mesas.php";
include ".././clases/Cuentas.php";
$dao = new Metodos();

if(!isset($_SESSION['restaurante'])){
    header("Location:./utils/cierreSesion.php");
 }
 

    $mesa = filter_var($_REQUEST['mesa'], FILTER_SANITIZE_NUMBER_INT);
    $comensales = filter_var($_REQUEST['comensales'], FILTER_SANITIZE_NUMBER_INT);
    $fecha = date("Y-n-d");
    $hora = date("G:i:s");
    $idRest = filter_var($_SESSION['restaurante']['id'], FILTER_SANITIZE_NUMBER_INT);

    if($mesa!=""&&$comensales!=""){
        $registro = new Mesa(null, $mesa, $comensales, $fecha, $hora, 0);
        $respuesta = $registro->crearMesa($mesa, $comensales, $fecha, $hora, $_SESSION['restaurante']['id']);
        if($respuesta){
            //una vez que se crea la mesa, automáticamente se crea la cuenta. 
            $id = $dao::localizarMesa($mesa, $comensales, $fecha, $hora, $_SESSION['restaurante']['id']);
            $cuenta = new Cuenta(null, $comensales);
            $respuestaCuentas = $cuenta->crearCuenta($comensales, $id, $idRest);
            if($respuestaCuentas){
                array_push($_SESSION['cuentasNF'], $respuestaCuentas);
                //mensaje de error: Mesa creada
                header("Location:.././main.php?error=0");
            }else{
                //mensaje de error: la mesa esta ocupada. Desocúpala.
                header("Location:.././main.php?error=3");
            }
        }else{
            //mensaje de error: la mesa esta ocupada. Desocúpala.
            header("Location:.././main.php?error=2");
        }
    }else{
        //mensaje de error: error al crear mesa
        header("Location:.././main.php?error=1");
    }

?>