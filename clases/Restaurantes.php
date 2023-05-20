<?php

    class Restaurante{

        private $id;
        private $nombre;
        private $NIF;
        private $telefono;
        private $email;
        private $pass;
        private $direccion;
        private $cp;
        private $contacto;
        private $validado;
        private $num_conf;


        public function __construct($arr){
        
            $this->id=$arr['id'];
            $this->nombre=$arr['nombre'];
            $this->NIF=$arr['NIF'];
            $this->telefono=$arr['telefono'];
            $this->email=$arr['email'];
            $this->pass=$arr['pass'];
            $this->direccion=$arr['direccion'];
            $this->cp=$arr['cp'];
            $this->contacto=$arr['contacto'];
            $this->validado=$arr['validado'];
            $this->num_conf=$arr['num_conf'];

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

        public function getNif(){
            return $this->NIF;
        }
        public function setNif($NIF){
            $this->NIF=$NIF;
        }

        public function getTelefono(){
            return $this->telefono;
        }
        public function setTelefono($telefono){
            $this->telefono=$telefono;
        }

        public function getEmail(){
            return $this->email;
        }
        public function setEmail($email){
            $this->email=$email;
        }
        
        public function getPass(){
            return $this->pass;
        }
        public function setPass($pass){
            $this->pass=$pass;
        }

        public function getDireccion(){
            return $this->direccion;
        }
        public function setDireccion($direccion){
            $this->direccion=$direccion;
        }

        public function getCp(){
            return $this->cp;
        }
        public function setCp($cp){
            $this->cp=$cp;
        }
        
        public function getContacto(){
            return $this->contacto;
        }
        public function setContacto($contacto){
            $this->contacto=$contacto;
        }

        public function getValidado(){
            return $this->validado;
        }
        public function setValidado($validado){
            $this->validado=$validado;
        }

        public function getNumConf(){
            return $this->num_conf;
        }
        public function setNumConf($num_conf){
            $this->num_conf=$num_conf;
        }

        public function registrarRestaurante( $nombre, $nif, $telefono, $email, $pass, $direccion, $cp, $contacto, $num_conf){
            
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            
            $res=$cnx->prepare("INSERT INTO 
            restaurantes(id`, `nombre`, `NIF`, `telefono`, `email`, `pass`, `direccion`, `cp`, `contacto`, `validado`, `num_conf`) 
            VALUES (null , '$nombre', '$nif', '$telefono', '$email', '$pass', '$direccion', '$cp', '$contacto', default, '$num_conf')");

            

            $resultado = $res->execute();
            
            if($resultado){
                header("Location: ../index.php?login=1");
            }else{
                header("Location: ../registroRestaurante.php?login=0");
            }

        }
        
        public function modificarRestaurante($id, $nombre, $nif, $telefono, $email, $pass, $direccion, $cp, $contacto, $num_conf){
            
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();

            if($cp==null){$cp=0;}

            $res=$cnx->prepare("UPDATE `restaurantes` SET nombre='$nombre', NIF='$nif',telefono=$telefono, email='$email', pass='$pass', direccion='$direccion', cp=$cp,contacto='$contacto', validado=1, num_conf=$num_conf WHERE id=$id");

            $resultado = $res->execute();
            
            if($resultado){
                return true;
            }else{
                return false;
            }

        }


    }

?>

