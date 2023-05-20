<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Facturas.php";
$dao = new Metodos();

if(!isset($_SESSION['restaurante'])){
    header("Location:./utils/cierreSesion.php");
 }
 
//hay que localizar el id y crear un objeto con esos elementos, y despues eliminarlo de la bbdd

    $num_factura=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
    $num_conf=filter_var($_REQUEST['num_conf'], FILTER_SANITIZE_NUMBER_INT);
    $idRest = filter_var($_SESSION['restaurante']['id'], FILTER_SANITIZE_NUMBER_INT);

    if($num_conf!=$_SESSION['restaurante']['num_conf']){
        header("Location:.././historialFacturas.php?del=0");
    }else{

        if($num_factura!=""&&$num_conf!=""){
            
            $factura = $dao::localizarFactura($num_factura, $idRest);
            $factura = new Factura($factura['id'],$factura['fecha'],$factura['num_factura'],$factura['empresa'],$factura['contacto'],$factura['direccion'],
            $factura['ciudad'],$factura['provincia'],$factura['cp'],$factura['telefono'],$factura['observaciones'],$factura['precio'],);
            
            $respuesta = $factura->eliminarFactura($factura->getId());
            if($respuesta){

                header("Location:.././historialFacturas.php?del=1");

            }

        }else{
            header("Location:.././historialFacturas.php?del=0");
        }
        
    }
?>