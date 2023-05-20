<?php
session_start();
include_once ".././clases/DAO.php";
include ".././clases/Mesas.php";
include ".././clases/Cuentas.php";

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
            $respuesta = $registro->finalizarMesa($id, $num_mesa, $idRest);
            if($respuesta){
                
                foreach($_SESSION['cuentasNF'] as $key => $valor){
                    if($valor['id_mesa']==$id){
                        
                        $_SESSION['cuentasNF'][$key]['finalizado']=1;
                        //aqui ya debe de añadir los platos a la bbdd, primero encuentro la cuenta que quiero
                        $cuentaFinalizada = $dao::localizarCuentaFinalizada($id, $idRest);
                        //cojo su id y codifico a formato json y base64 el array de platos serializados
                        $idCuenta = $cuentaFinalizada['id'];
                        $arrayPlatos = $dao::encoder(json_encode($_SESSION['cuentasNF'][$key]['platos']));
                        //creo un objeto cuenta para actuar sobre el
                        $cuenta = new Cuenta($idCuenta, $cuentaFinalizada['comensales']);
                        //ejecuto el metodo sumar platos que en este caso me mete el array de platos a bbdd
                        $resultado = $cuenta->sumarPlatos($idCuenta, $arrayPlatos, 0);
                        
                        if($resultado){
                            array_push($_SESSION['cuentas'], $_SESSION['cuentasNF'][$key]);
                            unset($_SESSION['cuentasNF'][$key]);
                            header("Location:.././main.php?mesa=fin");
                        }
                    }
                }
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