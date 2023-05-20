<?php

include_once ".././conexion/conexion.php";

    class Factura{

        private $id;
        private $fecha;
        private $num_cuenta;
        private $empresa;
        private $contacto;
        private $direccion;
        private $ciudad;
        private $provincia;
        private $cp;
        private $telefono;
        private $observaciones;
        private $precio;
        private const IVA = 0.10;

        public function __construct($id=null, $fecha, $num_cuenta, $empresa, $contacto, $direccion, $ciudad, $provincia, $cp, $telefono, $observaciones, $precio){
            
            $this->id=$id;
            $this->fecha=$fecha;
            $this->num_cuenta=$num_cuenta;
            $this->empresa=$empresa;
            $this->contacto=$contacto;
            $this->direccion=$direccion;
            $this->ciudad=$ciudad;
            $this->provincia=$provincia;
            $this->cp=$cp;
            $this->telefono=$telefono;
            $this->observaciones=$observaciones;
            $this->precio=$precio;


        }

        public function getId(){
            return $this->id;
        }
        public function setId($id){
            $this->id=$id;
        }
        public function getFecha(){
            return $this->fecha;
        }
        public function setFecha($fecha){
            $this->fecha=$fecha;
        }
        public function getNumCuenta(){
            return $this->num_cuenta;
        }
        public function setNumCuenta($num_cuenta){
            $this->num_cuenta=$num_cuenta;
        }
        public function getEmpresa(){
            return $this->empresa;
        }
        public function setEmpresa($empresa){
            $this->empresa=$empresa;
        }
        public function getContacto(){
            return $this->contacto;
        }
        public function setContacto($contacto){
            $this->contacto=$contacto;
        }
        public function getDireccion(){
            return $this->direccion;
        }
        public function setDireccion($direccion){
            $this->direccion=$direccion;
        }
        public function getCiudad(){
            return $this->ciudad;
        }
        public function setCiudad($ciudad){
            $this->ciudad=$ciudad;
        }
        public function getProvincia(){
            return $this->provincia;
        }
        public function setProvincia($provincia){
            $this->provincia=$provincia;
        }
        public function getCp(){
            return $this->cp;
        }
        public function setCp($cp){
            $this->cp=$cp;
        }
        public function getTelefono(){
            return $this->telefono;
        }
        public function setTelefono($telefono){
            $this->telefono=$telefono;
        }
        public function getObservaciones(){
            return $this->observaciones;
        }
        public function setObservaciones($observaciones){
            $this->observaciones=$observaciones;
        }
        public function getPrecio(){
            return $this->precio;
        }
        public function setPrecio($precio){
            $this->precio=$precio;
        }

        public function crearFactura($id_cuenta, $id_mesa, $empresa, $nif, $contacto, $direccion, $ciudad, $provincia, $cp, $telefono, $observaciones, $idRest){
        //@method Crea facturas con los datos que se le pasan obteniendo un contador unico de factura por restaurante. Si la factura ya existe
        // modifica la factura existente.
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            try{
                $res = $cnx->prepare("SELECT * FROM cuentas, mesas WHERE cuentas.id=$id_cuenta AND mesas.id=cuentas.id_mesa AND
                cuentas.id_mesa = $id_mesa AND finalizado = 1");
                $res->execute();
                $resultado = $res->fetch();
                $res2 = $cnx->prepare("SELECT MAX(num_factura) as max FROM facturas, cuentas, mesas, restaurantes where facturas.id_cuenta=cuentas.id 
                AND cuentas.id_mesa=mesas.id AND mesas.id_restaurante=$idRest");
                $res2->execute();
                $num_factura=$res2->fetch();
                $int = intval($num_factura['max']);
                $int++;

                if($resultado!=0){
                    $fecha = date("Y-n-d");
                    $precio = $resultado['precio'];
                    $res = $cnx->prepare("SELECT * FROM facturas, cuentas, mesas, restaurantes WHERE id_cuenta=$id_cuenta AND facturas.id_cuenta=cuentas.id 
                    AND cuentas.id_mesa=mesas.id AND mesas.id_restaurante=restaurantes.id");
                    $res->execute();
                    $resultado=$res->fetch();
                    if($resultado==0){
                        $res = $cnx->prepare("INSERT INTO `facturas`(`id`,`num_factura`, `fecha`, `empresa`, `nif`, `contacto`,
                        `direccion`, `ciudad`, `provincia`, `cp`, `telefono`, `observaciones`, `precio`, `id_cuenta`) 
                        VALUES (null, $int , '$fecha','$empresa','$nif','$contacto','$direccion','$ciudad','$provincia',
                        $cp, '$telefono', '$observaciones', $precio, $id_cuenta)");
                        $res->execute();
                    }else{
                        $res = $cnx->prepare("UPDATE `facturas` SET `fecha`='$fecha',`empresa`='$empresa',`nif`='$nif',`contacto`='$contacto',
                        `direccion`='$direccion',`ciudad`='$ciudad',`provincia`='$provincia',`cp`=$cp,`telefono`='$telefono',`observaciones`='$observaciones',
                        `precio`='$precio' WHERE id_cuenta = $id_cuenta");
                        $res->execute();
                    }

                    
                }else{
                  return false; 
                }
            }catch(Exception $e){
                echo "Se ha producido un error:".$e->getMessage();
            }
            return true;
        }

        public function eliminarFactura($id){
        //@method Elimina las facturas pasandole por parametro el id de factura y el id del restaurante
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            try{
                $res = $cnx->prepare("DELETE FROM facturas WHERE id=$id");
                
                $resultado = $res->execute();
                if(!$resultado){
                    return false;
                }

            }catch(Exception $e){
                echo "Se ha producido un error:".$e->getMessage();
            }
            return true;
        }
        
        public function imprimirFactura($id){

        }
        public function enviarFactura($id){

        }


    }

//TABLA BASE DE DATOS
// CREATE TABLE mesas(
// 	   id INT PRIMARY KEY AUTO_INCREMENT,
// 	   comensales VARCHAR(50) NOT NULL,
//     fecha VARCHAR(9) UNIQUE NOT NULL,
//     hora VARCHAR(9) NOT NULL,  
// );
?>

