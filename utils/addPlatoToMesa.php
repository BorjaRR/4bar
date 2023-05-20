<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Cuentas.php";
include ".././clases/Platos.php";
$dao = new Metodos();
 
if(!isset($_SESSION['restaurante'])){
    header("Location:./utils/cierreSesion.php");
 }
    
    $idPlato= filter_var($_REQUEST['id'],FILTER_SANITIZE_NUMBER_INT);
    $num_mesa= filter_var($_REQUEST['num_mesa'],FILTER_SANITIZE_NUMBER_INT);
    $cantidad= filter_var($_REQUEST['cantidad'],FILTER_SANITIZE_NUMBER_INT);
    $idRest =  filter_var($_SESSION['restaurante']['id'],FILTER_SANITIZE_NUMBER_INT);

    if($idPlato!=""&&$num_mesa!=""&&$cantidad!=""){
        // recuperamos el plato y lo objetivizamos
        $getPlato = $dao::localizarPlato($idPlato, $idRest);
        $plato = new Plato($getPlato['id'], $getPlato['nombre'], $getPlato['categoria'], $getPlato['precio']);
        $plato->setCantidad($cantidad);
        $platoSerializado = serialize($plato);
        //igual con la cuenta, localizamos la cuenta para incluirselo
        $getCuenta = $dao::localizarCuenta($num_mesa, $idRest);
        
        if(!$getCuenta){
            header("Location:.././historialPlatos.php?add=0");
        }else{
            $cuenta= new Cuenta($getCuenta['id'], $getCuenta['comensales']);
        }
        
        foreach($_SESSION['cuentasNF'] as $key => $valor){
           
            if($valor['num_mesa']==$num_mesa && $valor['id']==$getCuenta['id_mesa']){

                if(empty( $_SESSION['cuentasNF'][$key]['platos'])){
                    $_SESSION['cuentasNF'][$key]['platos']=array();
                }

                //esto añade el plato serializado a el session
                array_push( $_SESSION['cuentasNF'][$key]['platos'], $platoSerializado);
                
                $precio = $plato->getPrecio();
                $total = $precio*$cantidad;

                $resultado = $cuenta->sumarPlatos($getCuenta['id_mesa'], null, $total);
                
                if($resultado){
                    header("Location:.././historialPlatos.php?add=2");
                }else{
                    //Error message-> Algo salio mal al agregar plato
                    header("Location:.././main.php?add=1");
                }
            }
        }
    }else{
        //Error message-> indique nº ede mesa y cantidad
        header("Location:.././historialPlatos.php?add=0");
    }

?>