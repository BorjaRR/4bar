<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Mesas.php";
include_once ".././clases/Cuentas.php";
$dao = new Metodos();

if(!isset($_SESSION['restaurante'])){
    header("Location:./utils/cierreSesion.php");
 }
 
    $id=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
    $num_mesa=filter_var($_REQUEST['num_mesa'], FILTER_SANITIZE_NUMBER_INT);
    $num_conf=filter_var($_REQUEST['num_conf'], FILTER_SANITIZE_NUMBER_INT);
    $idRest=filter_var($_SESSION['restaurante']['id'], FILTER_SANITIZE_NUMBER_INT);

if($num_conf==$_SESSION['restaurante']['num_conf']){
    if(($id!=0&&$id!="")||($idRest!=0&&$idRest!="")){
        
        $registro = new Mesa($id, $num_mesa, null, null, null, 0);
        $respuesta = $registro->eliminarMesa($id, $num_mesa, $idRest);
        
        if($respuesta){
            for($i=0;$i<sizeof($_SESSION['mesas']);$i++){
                if($_SESSION['mesas'][$i]['id']==$id){
                    unset($_SESSION['mesas'][$i]);
                }
            }
            foreach($_SESSION['cuentasNF'] as $key => $valor){
                if($valor['id']==$id){
                    unset($_SESSION['cuentasNF'][$key]);
                }
            }
            //mesaje de borrado con exito
            header("Location:.././main.php?mesa=del");
        }else{
            header("Location:.././main.php?mesa=1");
        }
    }else{
        header("Location:.././main.php?mesa=0");
    }
}else{
    header("Location:.././main.php?mesa=0");
}
?>