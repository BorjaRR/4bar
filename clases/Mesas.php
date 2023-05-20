<?php


    class Mesa{

        private $id;
        private $num_mesa;
        private $comensales;
        private $fecha;
        private $hora;
        private $finalizada;

        public function __construct($id ,$num_mesa, $comensales, $fecha, $hora, $finalizada){
            
            $this->id=$id;
            $this->num_mesa=$num_mesa;
            $this->comensales=$comensales;
            $this->fecha=$fecha;
            $this->hora=$hora;
            $this->finalizada=$finalizada;

        }

        public function getId(){
            return $this->id;
        }
        public function setId($id){
            $this->id=$id;
        }
        public function getNumMesa(){
            return $this->num_mesa;
        }
        public function setNumMesa($num_mesa){
            $this->num_mesa=$num_mesa;
        }
        public function getComensales(){
            return $this->comensales;
        }
        public function setComensales($comensales){
            $this->comensales=$comensales;
        }
        public function getFecha(){
            return $this->fecha;
        }
        public function setFecha($fecha){
            $this->fecha=$fecha;
        }
        public function getHora(){
            return $this->hora;
        }
        public function setHora($hora){
            $this->hora=$hora;
        }
        public function getFinalizada(){
            return $this->finalizada;
        }
        public function setFinalizada($finalizada){
            $this->finalizada=$finalizada;
        }

        public function crearMesa($num_mesa, $comensales, $fecha, $hora, $id_rest){
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            try{
                $res = $cnx->prepare("SELECT * FROM mesas WHERE num_mesa=$num_mesa  AND finalizado = 0 AND id_restaurante=$id_rest");
                $res->execute();
                $resultado = $res->fetch();
                if($resultado==0){
                    $res = $cnx->prepare("INSERT INTO mesas (`id`, `num_mesa`, `comensales`, `fecha`, `hora`, `finalizado`, `id_restaurante`) 
                    VALUES (null, $num_mesa, $comensales,'$fecha','$hora', 0, $id_rest )");
                    $valor = $res->execute();
                }else{
                  return false; 
                }
            }catch(Exception $e){
                echo "Se ha producido un error:".$e->getMessage();
            }
            return true;
        }

        public function eliminarMesa($id, $num_mesa, $idRest){
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            try{
                $res = $cnx->prepare("DELETE FROM mesas WHERE id=$id AND num_mesa=$num_mesa AND id_restaurante=$idRest");
                $valor = $res->execute();
            }catch(Exception $e){
                echo "Se ha producido un error:".$e->getMessage();
            }
            return true;
        }

        public function finalizarMesa($id, $num_mesa, $idRest){
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            try{
                $res = $cnx->prepare("UPDATE mesas SET finalizado=1 WHERE id=$id AND num_mesa=$num_mesa AND id_restaurante=$idRest");
                $res->execute();
            }catch(Exception $e){
                echo "Se ha producido un error:".$e->getMessage();
            }
            return true;
        }

    }

?>

