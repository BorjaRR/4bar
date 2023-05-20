<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Facturas.php";
$dao = new Metodos();

if(!isset($_SESSION['restaurante'])){
   header("Location:./utils/cierreSesion.php");
}
    
    $id_cuenta=filter_var($_REQUEST['id_cuenta'], FILTER_SANITIZE_NUMBER_INT);
    $id_mesa=filter_var($_REQUEST['id_mesa'], FILTER_SANITIZE_NUMBER_INT);
    $empresa=filter_var($_REQUEST['empresa'], FILTER_SANITIZE_STRING);
    $nif=filter_var($_REQUEST['nif'], FILTER_SANITIZE_STRING);
    $contacto=filter_var($_REQUEST['contacto'], FILTER_SANITIZE_STRING);
    $direccion=filter_var($_REQUEST['direccion'], FILTER_SANITIZE_STRING);
    $ciudad=filter_var($_REQUEST['ciudad'], FILTER_SANITIZE_STRING);
    $provincia=filter_var($_REQUEST['provincia'], FILTER_SANITIZE_STRING);
    $cp=filter_var($_REQUEST['cp'], FILTER_SANITIZE_NUMBER_INT);
    $telefono=filter_var($_REQUEST['telefono'], FILTER_SANITIZE_NUMBER_INT);
    $observaciones=filter_var($_REQUEST['observaciones'], FILTER_SANITIZE_STRING);
    $idRest = filter_var($_SESSION['restaurante']['id'], FILTER_SANITIZE_NUMBER_INT);

    if($id_cuenta!=""&&$id_mesa!=""){
       
        $factura = new Factura(null, null, $id_cuenta, $empresa, $contacto, $direccion, $ciudad, $provincia, $cp, 
        $telefono, $observaciones, null);
        $respuesta = $factura->crearFactura($id_cuenta, $id_mesa, $empresa, $nif, $contacto, $direccion, $ciudad, $provincia, $cp, $telefono, $observaciones, $idRest);

        if($respuesta){
            header("Location:.././historialFacturas.php?genFactura=1");

        }else{
            header("Location:.././generarFactura.php?errorFactura=1&id_cuenta=$id_cuenta&id_mesa=$id_mesa");
        }

    }else{
        header("Location:.././generarFactura.php?errorFactura=0&id_cuenta=$id_cuenta&id_mesa=$id_mesa");
    }

?>