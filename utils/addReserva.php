<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Reservas.php";
$dao = new Metodos();

if(!isset($_SESSION['restaurante'])){
    header("Location:./utils/cierreSesion.php");
 }
 
    $nombre= filter_var($_REQUEST['nombre'],FILTER_SANITIZE_STRING);
    $comensales = filter_var($_REQUEST['comensales'],FILTER_SANITIZE_NUMBER_INT);
        $comensales = intval($comensales);
    $fecha = filter_var($_REQUEST['fecha'],FILTER_SANITIZE_STRING);
    $hora = filter_var($_REQUEST['hora'],FILTER_SANITIZE_STRING);
    $telefono = filter_var($_REQUEST['telefono'],FILTER_SANITIZE_NUMBER_INT);
        $telefono = intval($telefono);

    if($nombre!=""&&$comensales!=""&&$fecha!=""&&$hora!=""&&$telefono!=""){
       
        $reserva = new Reserva(null, $nombre, $comensales, $fecha, $hora, $telefono);
        $respuesta = $reserva->generarReserva($nombre, $comensales, $fecha, $hora, $telefono, $_SESSION['restaurante']['id']);

        if($respuesta){

            header("Location:.././reservas.php?reg=1");

        }

    }else{
        header("Location:.././generarReserva.php?reg=0&fecha=$fecha");
    }

?>