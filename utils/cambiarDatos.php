<?php
session_start();
if(!isset($_SESSION['restaurante'])){
    header("Location:cierreSesion.php");
 }

    if($_REQUEST['pass']!=$_REQUEST['pass2']){
        header("Location: ../datosUsuario.php?errorDatos=1");
    }
    else{
        $id=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
        $nombre = filter_var($_REQUEST['nombre'], FILTER_SANITIZE_STRING);
        $nif = filter_var($_REQUEST['nif'], FILTER_SANITIZE_STRING);
        $telefono = filter_var($_REQUEST['telefono'], FILTER_SANITIZE_NUMBER_INT);
        $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);
        $pass = filter_var($_REQUEST['pass'], FILTER_SANITIZE_STRING);
        if(isset($_REQUEST['direccion'])){
            $direccion = filter_var($_REQUEST['direccion'], FILTER_SANITIZE_STRING);
        }else{
            $direccion=null;
        }
        if(isset($_REQUEST['cp'])){
            $cp = filter_var($_REQUEST['cp'], FILTER_SANITIZE_NUMBER_INT);
        }else{
            $cp=null;
        }
        if(isset($_REQUEST['contacto'])){
            $contacto = filter_var($_REQUEST['contacto'], FILTER_SANITIZE_STRING);
        }else{
            $contacto=null;
        }
        $css = filter_var($_REQUEST['css'], FILTER_SANITIZE_NUMBER_INT);
        
        include_once ".././clases/DAO.php";
        include_once ".././clases/Restaurantes.php";
        $arr=array(
            "id" => null, 
            "nombre" => $nombre, 
            "NIF" => $nif, 
            "telefono" => $telefono, 
            "email" => $email, 
            "pass" => $pass,
            "direccion" => $direccion, 
            "cp" => $cp, 
            "contacto" => $contacto, 
            "validado" => 0, 
            "num_conf" => $css);
        $restaurante = new Restaurante($arr);
        $resultado = $restaurante->modificarRestaurante($id, $nombre, $nif, $telefono, $email, $pass, $direccion, $cp, $contacto, $css);  
      
        if($resultado){
            $dao = new Metodos();
            unset($_SESSION['restaurante']);
            $_SESSION['restaurante'] = $dao::recuperarRestaurante($restaurante->getEmail(),$restaurante->getPass());
            header("Location: ../opciones.php?login=1");
        }else{
            header("Location: ../opciones.php?login=0");
        }

        
    }

?>