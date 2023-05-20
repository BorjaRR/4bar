<?php

class Plato{

    private $id;
    private $nombre;
    private $categoria;
    private $precio;
    private $cantidad;

    public function __construct($id = null, $nombre, $categoria, $precio){
            
        $this->id=$id;
        $this->nombre=$nombre;
        $this->categoria=$categoria;
        $this->precio=$precio;

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
    public function getCategoria(){
        return $this->categoria;
    }
    public function setCategoria($categoria){
        $this->categoria=$categoria;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function setPrecio($precio){
        $this->precio=$precio;
    }
    public function getCantidad(){
        return $this->cantidad;
    }
    public function setCantidad($cantidad){
        $this->cantidad=$cantidad;
    }
    
    
    public function crearPlato($nombre, $categoria, $precio, $idRest){
    //@method crea platos  
        include_once ".././conexion/conexion.php";
        $conexion = new conexion();
        $cnx = $conexion->connectDB();
        try{
            $res=$cnx->prepare("INSERT INTO `platos`(`id`, `nombre`, `categoria`, `precio`, `id_restaurante`) VALUES (null, '$nombre', '$categoria', $precio, $idRest)");
            $res->execute();
        }catch(Exception $e){
            echo "Error al insertar en tabla: ".$e->getMessage();
        }
        return true;
        
    }

    public function eliminarPlato($id, $idRest){
    //@method elimina platos segun su ID 
        include_once ".././conexion/conexion.php";
        $conexion = new conexion();
        $cnx = $conexion->connectDB();
        try{
            $res=$cnx->prepare("DELETE FROM platos WHERE id=$id AND id_restaurante=$idRest");
            $res->execute();
        }catch(Exception $e){
            echo "Error al insertar en tabla: ".$e->getMessage();
        }
        return true;
    }
    
}
?>