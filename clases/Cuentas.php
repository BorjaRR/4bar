<?php



class Cuenta{

    private $id;
    private $platos;
    private $precio;
    private $comensales;

    public function __construct($comensales, $id = null){
            
        $this->id=$id;
        $this->platos=array();
        $this->precio=0;
        $this->comensales=$comensales;

    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function getPlatos(){
        return $this->platos;
    }
    public function setPlatos($platos){
        $this->platos=$platos;
    }
    public function getPrecio(){
        return $this->Precio;
    }
    public function setPrecio($precio){
        $this->precio=$precio;
    }
    public function getComensales(){
        return $this->comensales;
    }
    public function setComensales($comensales){
        $this->comensales=$comensales;
    }

    public function crearCuenta($comensales, $idMesa, $idRest){
    //@method crea la cuenta
        include_once ".././conexion/conexion.php";
        $conexion = new conexion();
        $cnx = $conexion->connectDB();
        try{
            $res = $cnx->prepare("INSERT INTO `cuentas`(`id`, `platos`, `precio`, `comensales`, `id_mesa`) VALUES (null, null, 0, $comensales, $idMesa)");
            $valor = $res->execute();
            if($valor){
                $res = $cnx->prepare("SELECT * FROM cuentas, mesas WHERE cuentas.comensales=$comensales AND cuentas.comensales=mesas.comensales AND cuentas.id_mesa=$idMesa 
                                        AND cuentas.id_mesa=mesas.id AND mesas.id_restaurante=$idRest");
                $res->execute();
                $valor = $res->fetch();
                return $valor;
            }

        }catch(Exception $e){
            echo "Se ha producido un error:".$e->getMessage();
        }
        return true;
    }

    public function eliminarCuenta($idCuenta, $idMesa){
    //@method elimina la cuenta
        include_once ".././conexion/conexion.php";
        $conexion = new conexion();
        $cnx = $conexion->connectDB();
        try{
            $res = $cnx->prepare("DELETE FROM cuentas WHERE id=$idCuenta AND id_mesa=$idMesa");
            $res->execute();

        }catch(Exception $e){
            echo "Se ha producido un error:".$e->getMessage();
        }
        return true;
        
    }

    public function sumarPlatos($idCuenta, $platos, $total){
    //@method añade platos a la cuenta según el ID de cuenta ó al finalizar la cuenta, inserta un array de platos en bbdd 
        include_once ".././conexion/conexion.php";
        $conexion = new conexion();
        $cnx = $conexion->connectDB();
        try{
            $res=$cnx->prepare("SELECT precio FROM cuentas WHERE id=$idCuenta");
            $res->execute();
            $resultado = $res->fetch();
            if($resultado[0]!=null||$resultado[0]!=""){
                $precioFinal=$resultado[0]+$total;
                            
                $res=$cnx->prepare("UPDATE cuentas SET platos='$platos', precio=$precioFinal WHERE id=$idCuenta");
                $resultado = $res->execute();
                if($resultado){
                    return true;
                }
            }else{
                $res=$cnx->prepare("UPDATE cuentas SET platos='$platos', precio=$total WHERE id=$idCuenta");
                $resultado = $res->execute();
                if($resultado){
                    return true;
                }
            }

        }catch(Exception $e){
            echo "Error al insertar en tabla: ".$e->getMessage();
        }
        return true;
    }
    
    public function eliminarPlatos($idCuenta, $total){
    //@method elimina platos a la cuenta según el ID de cuenta en base de datos 
        include_once ".././conexion/conexion.php";
        $conexion = new conexion();
        $cnx = $conexion->connectDB();
        try{
            $res=$cnx->prepare("SELECT precio FROM cuentas WHERE id=$idCuenta");
            $res->execute();
            $resultado = $res->fetch();
            if($resultado[0]!=null||$resultado[0]!=""){
                $precioFinal=$resultado[0]-$total;
                            
                $res=$cnx->prepare("UPDATE cuentas SET precio=$precioFinal WHERE id=$idCuenta");
                $resultado = $res->execute();
            }else{
                return false;
            }

        }catch(Exception $e){
            echo "Error al insertar en tabla: ".$e->getMessage();
        }
        return true;
    }
}


?>