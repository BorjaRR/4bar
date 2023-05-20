<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Reservas.php";
$dao = new Metodos();

if(!isset($_SESSION['restaurante'])){
    header("Location:./utils/cierreSesion.php");
}

    $id=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
    $num_conf=filter_var($_REQUEST['num_conf'], FILTER_SANITIZE_NUMBER_INT);
    $idRest=filter_var($_SESSION['restaurante']['id'], FILTER_SANITIZE_NUMBER_INT);

if($num_conf=="" || $num_conf==null){
    header("Location:.././reservas.php?del=0");
}

if($num_conf==$_SESSION['restaurante']['num_conf']){
    if(($id!=0&&$id!="")||($idRest!=0&&$idRest!="")){
        
        $reserva = new Reserva($id, null, null, null, null);
        $respuesta = $reserva->eliminarReserva($id, $idRest);
        
        if($respuesta){
            //mesaje de borrado con exito
            header("Location:.././reservas.php?del=del");
        }else{
            header("Location:.././reservas.php?del=2");
        }
    }else{
        header("Location:.././reservas.php?del=1");
    }
}else{
    header("Location:.././reservas.php?del=0");
}
?>