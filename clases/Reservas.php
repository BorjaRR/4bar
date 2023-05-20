<?php

// include_once ".././conexion/conexion.php";

class Reserva{

    private $id;
    private $nombre;
    private $comensales;
    private $fecha;
    private $hora;
    private $telefono;

    public function __construct($id = null, $nombre = null, $comensales = null, $fecha = null, $hora = null, $telefono=null){
            
        $this->id=$id;
        $this->nombre=$nombre;
        $this->comensales=$comensales;
        $this->fecha=$fecha;
        $this->hora=$hora;
        $this->telefono=$telefono;

    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre=$nombre;
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
    public function getTelefono(){
        return $this->telefono;
    }
    public function setTelefono($telefono){
        $this->telefono=$telefono;
    }
    

    public function generarReserva($nombre, $comensales, $fecha, $hora, $telefono, $idRest){
    //@method genera una reserva con todos los datos solicitados 
        include_once ".././conexion/conexion.php";
        $conexion = new conexion();
        $cnx = $conexion->connectDB();
        try{
            $res = $cnx->prepare("INSERT INTO reservas(`id`, `nombre`, `comensales`, `fecha`, `hora`, `telefono`, `id_restaurante`) VALUES (null, '$nombre', $comensales, '$fecha', '$hora', $telefono,  $idRest)");
            $valor = $res->execute();
            return $valor;
        }catch(Exception $e){
            echo "Se ha producido un error:".$e->getMessage();
        }
    }
    public function eliminarReserva($id, $idRest){
    //@method elimina una reserva a partir de su id y el id del restaurante 
        include_once ".././conexion/conexion.php";
        $conexion = new conexion();
        $cnx = $conexion->connectDB();
        try{
            $res = $cnx->prepare("DELETE FROM reservas WHERE id=$id and id_restaurante=$idRest");
            $valor = $res->execute();
            return $valor;
        }catch(Exception $e){
            echo "Se ha producido un error:".$e->getMessage();
        }
    }


}


?>