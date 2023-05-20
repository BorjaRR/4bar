<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Platos.php";
$dao = new Metodos();

if(!isset($_SESSION['restaurante'])){
    header("Location:./utils/cierreSesion.php");
 }
 

    $nombre= filter_var($_REQUEST['nombre'],FILTER_SANITIZE_STRING);
    $categorias = ['entrante', 'principal', 'postre', 'bebida'];
    $categoria =  filter_var($_REQUEST['categoria'],FILTER_SANITIZE_STRING);
    //si la categoria recibida no esta entre las habidas, manda a la lista
        if(!in_array($categoria, $categorias)){header("Location:.././historialPlatos.php?reg=0");}
    $precio = filter_var($_REQUEST['precio'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if($nombre!=""&&$categoria!=""&&$precio!=""){
       
        $plato = new Plato(null, $nombre, $categoria, $precio);
        $respuesta = $plato->crearPlato($nombre, $categoria, $precio, $_SESSION['restaurante']['id']);

        if($respuesta){

            header("Location:.././historialPlatos.php?reg=1");

        }

    }else{
        header("Location:.././historialPlatos.php?reg=0");
    }

?>