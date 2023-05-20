<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Platos.php";
$dao = new Metodos();

if(!isset($_SESSION['restaurante'])){
    header("Location:./utils/cierreSesion.php");
 }
 
    $id=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
    $nombre="";
    $categoria = "";
    $precio = "";
    $num_conf=filter_var($_REQUEST['num_conf'], FILTER_SANITIZE_NUMBER_INT);

    if($num_conf!=$_SESSION['restaurante']['num_conf']){
        header("Location:.././historialPlatos.php?del=0");
    }else{

        if($id!=""&&$num_conf!=""){
        
            $plato = new Plato(null, $nombre, $categoria, $precio);
            $respuesta = $plato->eliminarPlato($id, $_SESSION['restaurante']['id']);

            if($respuesta){

                header("Location:.././historialPlatos.php?del=1");

            }

        }else{
            header("Location:.././historialPlatos.php?del=0");
        }
        
    }
?>