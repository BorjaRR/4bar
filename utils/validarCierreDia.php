<?php
session_start();
include_once ".././clases/DAO.php";
$dao= new Metodos();

if(!isset($_SESSION['restaurante'])){
    header("Location:./utils/cierreSesion.php");
 }
 
    $validarCierre = $dao::validarCierreDia($_SESSION['restaurante']['id']);
    if(!empty($validarCierre)){
        header("Location:../main.php?errorCierre=1");
    }else{  
        header("Location:../cierreDia.php");
    }

?>