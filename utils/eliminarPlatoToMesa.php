<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Cuentas.php";
include ".././clases/Platos.php";
$dao = new Metodos();
    
if(!isset($_SESSION['restaurante'])){
    header("Location:./utils/cierreSesion.php");
}
 
    $cantidad=$_REQUEST['cantidad'];
    $nombre=$_REQUEST['nombre'];
    $idRest = $_SESSION['restaurante']['id'];
    $num_mesa=$_REQUEST['num_mesa'];
    $total = $_REQUEST['total'];

    if($cantidad!=""&&$nombre!=""){

        //crea un array vacio
        $platos = array();

        //paso todo el session al array
        foreach($_SESSION['cuentasNF'] as $key => $valor){
            if($valor['num_mesa']==$num_mesa){
                for($j=0;$j<sizeof($_SESSION['cuentasNF'][$key]['platos']);$j++){
                    array_push($platos, unserialize($_SESSION['cuentasNF'][$key]['platos'][$j]));
                }
            }
        }

        //elimino el plato correspondiente
        for($i=0;$i<sizeof($platos);$i++){
            if($platos[$i]->getCantidad()==$cantidad&&$platos[$i]->getNombre()==$nombre){
                unset($platos[$i]);
                break;
            }
        }
        //le resto el precio en base de datos a la cuenta, para que el precio este correcto siempre
        $getCuenta = $dao::localizarCuenta($num_mesa, $idRest);
        if(!$getCuenta){
            header("Location:.././visualizarCuenta.php?num_mesa=$num_mesa");
        }else{
            $cuenta= new Cuenta($getCuenta['id'], $getCuenta['comensales']);
        }
        $resultadoCuenta = $cuenta->eliminarPlatos($getCuenta['id'], $total);
        
        if(!$resultadoCuenta){
            header("Location:.././visualizarCuenta.php?num_mesa=$num_mesa");
        }
        //inicializo el array session y lo lleno con lo qe hay en $platos
        foreach($_SESSION['cuentasNF'] as $key => $valor){
            if($valor['num_mesa']==$num_mesa){
                $_SESSION['cuentasNF'][$key]['platos']=array();
                foreach($platos as $plato){
                    $plato = serialize($plato);
                    array_push($_SESSION['cuentasNF'][$key]['platos'], $plato);
                }
                
                header("Location:.././visualizarCuenta.php?errorDel=0&num_mesa=$num_mesa");
            }
        }

    }else{
        header("Location:.././visualizarCuenta.php?errorDel=1&num_mesa=$num_mesa");
    }

?>