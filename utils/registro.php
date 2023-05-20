<?php
if($_REQUEST['pp']!=1 || !isset($_REQUEST['pp'])){
    header("Location: ../registroRestaurante.php?login=check");
}else{
    if($_REQUEST['pass']!=$_REQUEST['pass2']){
        header("Location: ../registroRestaurante.php?login=0");
    }
    else{
        $nombre = filter_var($_REQUEST['nombre'], FILTER_SANITIZE_STRING);
        $nif =  filter_var($_REQUEST['nif'], FILTER_SANITIZE_STRING);
        $telefono =  filter_var($_REQUEST['telefono'], FILTER_SANITIZE_NUMBER_INT);
        $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);
        $pass = filter_var($_REQUEST['pass'],FILTER_SANITIZE_SPECIAL_CHARS);
        if(isset($_REQUEST['adress'])){$adress = filter_var($_REQUEST['adress'], FILTER_SANITIZE_STRING);}else{$adress=null;}
        if(isset($_REQUEST['cp'])){$cp = filter_var($_REQUEST['cp'], FILTER_SANITIZE_NUMBER_INT);}else{$cp=null;}
        if(isset($_REQUEST['contacto'])){$contacto = filter_var($_REQUEST['contacto'], FILTER_SANITIZE_STRING);}else{$contacto=null;}
        $css =  filter_var($_REQUEST['css'], FILTER_SANITIZE_NUMBER_INT);
        if(strlen($css)!=4){
            header("Location: ../registroRestaurante.php?login=0");
        }
        
        include_once ".././clases/Restaurantes.php";
        $arr=array(
            "id" => null, 
            "nombre" => $nombre, 
            "NIF" => $nif, 
            "telefono" => $telefono, 
            "email" => $email, 
            "pass" => $pass,
            "direccion" => $adress, 
            "cp" => $cp, 
            "contacto" => $contacto, 
            "validado" => 0, 
            "num_conf" => $css);
        $restaurante = new Restaurante($arr);
        $restaurante->registrarRestaurante($nombre, $nif, $telefono, $email, $pass, $adress, $cp, $contacto, $css);  
        
    }
}
?>