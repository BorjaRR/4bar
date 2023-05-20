<?php

    class Metodos{
        
        public static function validarInicioSesion($email, $pass){
        //@method valida el inicio de sesion de usuario
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();

            $res=$cnx->prepare("SELECT * FROM restaurantes WHERE email='$email'");
            $res->execute();
            $resultado = array();
            
            foreach($res as $row){
                
                $resultado = $row;

            }

            if($resultado['email']==$email && $resultado['pass']==$pass){
                if($resultado['validado']==0){
                    //si es la primera vez que entra, ses cambia el valor de validado, ya que ha funcionado
                    //correctamente el inicio de sesión. 
                    $id = $resultado['id'];
                    $res=$cnx->prepare("UPDATE restaurantes SET validado = 1 WHERE id=$id");
                    $res->execute();
                }
                $dao = new Metodos();
                $email = $dao::encoder($resultado['email']);
                $pass = $dao::encoder($resultado['pass']);
                header ("Location:../main.php?em=$email&ps=$pass");
                
            }else if($resultado['email']!=$email || $resultado['pass']!=$pass){
                header ("Location:../index.php?inicioError=1");
            }

        }
        
        public static function recuperarPass($email){
        //@method manda mail al correo para acceder a cambio de contraseña  
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();

            $res=$cnx->prepare("SELECT * FROM restaurantes WHERE email='$email'");
            $res->execute();
            $resultado = array();
            
            foreach($res as $row){
                
                $resultado = $row;

            }

            if($email==$resultado['email']){
                $destinatario = $resultado['email'];
                $id = base64_encode($resultado['id']);
                $asunto = "Recuperación de contraseña";
                $cuerpo ='
                    <html> 
                        <head>
                            <meta charset="UTF-8">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Recupera tu contraseña</title>
                            <style>
                                body{
                                    display: grid;
                                    justify-content: center;
                                    font-family:Verdana, Geneva, Tahoma, sans-serif;
                                }
                                .contenedor{
                                    max-width: 90%;
                                    background-color: #fea700;
                                    text-align: center;
                                    margin-top: 4rem;
                                }
                                h3,a,p{
                                    font-weight: bold;
                                }
                                a{
                                    text-decoration: underline #fff;
                                    color: #fff;
                                    font-size: 1.5rem;
                                    padding:1rem 1.4rem;
                                }
                                a:hover{
                                    color: #fea700;
                                    background-color: #fff;
                                    text-decoration: underline #fea700;
                                    border-radius: 2rem;
                                }
                            </style>
                        </head>
                        <body> 
                            <div class="contenedor">
                                <h1>¿Has olvidado la contraseña? !No te preocupes!</h1> 
                                <h3 style="margin-bottom:50px"> 
                                    Haz click en el siguiente botón para cambiar la contraseña.
                                </h3> 
                                <a href="localhost/4bar/nuevaPassword.php?id='.$id.'">CAMBIAR PASS</a>
                                <p style="margin-top:50px">Un saludo de tus amigos de 4bar.</p>
                            </div>
                            </body>  
                    </html> 
                    ';
                    $headers = "MIME-Version: 1.0\r\n"; 
                    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                    $headers .= "From: Equipo de 4bar <arestheferret@gmail.com>\r\n"; 
                    if(mail($destinatario,$asunto, $cuerpo, $headers)){
                        header("Location:../recuperacionPass.php?enviado=1");
                    }else{
                        header("Location:../recuperacionPass.php?enviado=0");
                    }
            }
            else{
                header("Location:../recuperacionPass.php?enviado=0");
            }

        }

        public static function nuevaPass($id, $pass){
        //@method ejecuta el cambio de contraseña    
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();

            $res=$cnx->prepare("SELECT * FROM restaurantes WHERE id=$id");
            $res->execute();
            $resultado = array();
            
            foreach($res as $row){
                
                $resultado = $row;

            }
                
            $res=$cnx->prepare("UPDATE restaurantes SET pass='$pass' WHERE id=$id");
            $query = $res->execute();
            if($query){
                header("Location:../index.php?error_log=0");
            }else{
                $dao = new Metodos();
                $id=$dao::encoder($resultado['id']);
                header("Location:../nuevaPassword.php?id=$id&error_log=2");
            }
        }

        public static function arreglarMesasNoFinalizadas($fecha, $idRest){
        //@method si se cierra la app sin cerrar dia, este metodo al dia siguiente recibira el día actual como parametro, y todas las mesas no finalizadas con dia diferente seran eliminadas. NO DEBE USARSE pero por si acaso ocurriera, debe existir.
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();

            $res=$cnx->prepare("DELETE FROM mesas WHERE fecha != '$fecha' AND finalizado=0 AND id_restaurante=$idRest");
            $resultado=$res->execute();

            return $resultado;
        }

        public static function validarCierreDia($idRest){
        //@method al cerrar el dia, si existe alguna mesa abierta emitira un mensaje de error para que se cierren todas.
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();

            $fecha = date('Y-n-d');

            $res=$cnx->prepare("SELECT * FROM mesas where fecha = '$fecha' and finalizado=0 AND id_restaurante=$idRest");
            $res->execute();
            $resultado = array();
            
            foreach($res as $row){
                
                $resultado = $row;

            }
            
            return $resultado;
        }

        // RESTAURANTES ***********************************************************************************************//

        public static function recuperarRestaurante($email, $pass){
        //@method una vez validado el inicio de sesion, recupera datos del restaurante y los almacena como objeto.    
            error_reporting(0);
            include_once ".././conexion/conexion.php";
            include_once "./conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            
            $res = $cnx->prepare("SELECT * FROM restaurantes WHERE email='$email' AND pass='$pass'");
            $res->execute();

            foreach($res as $row){
                
                $resultado = $row;

            }

            return $resultado;
        }
        
        // MESAS ***********************************************************************************************//

        public static function listarMesas($idRest){
        //@method Lista las mesas actuales NO FINALIZADAS
            include_once "./conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $fecha = "'".date("Y-n-d")."'";
            $res=$cnx->prepare("SELECT * FROM mesas WHERE fecha=$fecha AND id_restaurante=$idRest AND finalizado=0");
            $res->execute();

            $resultado = array();
            
            foreach($res as $row){
            
                $resultado[] = $row;
            
            }

            return $resultado;

        }

        public static function localizarMesa($num_mesa, $comensales, $fecha, $hora, $idRest){
        //@method encuentra una mesa concreta para darle a su objeto un id
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();

            $res = $cnx->prepare("SELECT id FROM mesas WHERE num_mesa=$num_mesa AND comensales=$comensales AND fecha = '$fecha' AND hora='$hora' AND id_restaurante=$idRest");
            $res->execute();

            $resultado = $res->fetch();
            return $resultado['id'];
        }

        // CUENTAS ***********************************************************************************************//

        public static function listarCuentasNoFinalizadas($idRest){
        //@method lista todas las cuentas no finalizadas que no pueden generar factura aún
            include_once "./conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $fecha = "'".date("Y-n-d")."'";
            $res=$cnx->prepare("SELECT * FROM cuentas, mesas WHERE mesas.fecha=$fecha AND id_restaurante=$idRest AND finalizado=0 AND mesas.id=cuentas.id_mesa");
            $res->execute();

            $resultado = array();
            
            foreach($res as $row){
            
                $resultado[] = $row;
            
            }

            return $resultado;
        }

        public static function listarCuentasFinalizadas($idRest){
        //@method lista todas las cuentas finalizadas para generar factura
            include_once "./conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $res=$cnx->prepare("SELECT * FROM cuentas, mesas WHERE id_restaurante=$idRest AND finalizado=1 AND mesas.id=cuentas.id_mesa");
            $res->execute();

            $resultado = array();
            
            foreach($res as $row){
            
                $resultado[] = $row;
            
            }

            return $resultado;
        }
        
        
        public static function localizarCuenta($num_mesa, $idRest){
        //@method localiza una cuenta de una mesa SIN TERMINAR    
            error_reporting(0);
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $res=$cnx->prepare("SELECT cuentas.id, cuentas.platos, cuentas.precio, cuentas.comensales, cuentas.id_mesa 
                                FROM `cuentas`, `mesas`, `restaurantes` 
                                WHERE mesas.num_mesa = $num_mesa AND cuentas.id_mesa=mesas.id AND mesas.id_restaurante=restaurantes.id AND restaurantes.id=$idRest
                                AND mesas.finalizado=0");
            $res->execute();

            $resultado = $res->fetch();
            return $resultado;
        } 
        
        public static function localizarCuentaFinalizada($idMesa, $idRest){
        //@method localiza una cuenta de una mesa TERMINADA    
            error_reporting(0);
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $res=$cnx->prepare("SELECT cuentas.id, cuentas.platos, cuentas.precio, cuentas.comensales, cuentas.id_mesa 
                                FROM `cuentas`, `mesas`, `restaurantes` 
                                WHERE cuentas.id_mesa=$idMesa AND cuentas.id_mesa=mesas.id AND mesas.id_restaurante=restaurantes.id AND restaurantes.id=$idRest
                                AND mesas.finalizado=1");
            $res->execute();

            $resultado = $res->fetch();
            return $resultado;
        }

        // RESERVAS ***********************************************************************************************//

        public static function listarReservas($fecha ,$idRest){
        //@method localiza todas las reservas de una fecha concreta y de un restaurante   
            include_once "./conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $res=$cnx->prepare("SELECT * FROM reservas WHERE fecha=$fecha AND id_restaurante=$idRest ORDER BY hora ASC");
            $res->execute();

            $resultado = array();
            
            foreach($res as $row){
            
                $resultado[] = $row;
            
            }

            return $resultado;
        }

        public static function contarReservas($idRest){
        //@method cuenta el número de comensales para el dia de de hoy reservados. 
            include_once "./conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $fecha = "'".date("Y-n-d")."'";
            $res=$cnx->prepare("SELECT count(comensales) as total, sum(comensales) AS comensales FROM reservas WHERE fecha=$fecha AND id_restaurante=$idRest");
            $res->execute();

            $resultado = array();

            foreach($res as $row){
                $resultado = $row;
            }
            return $resultado;
            
        }
        
        // FACTURAS ***********************************************************************************************//

        public static function listarFacturas($idRest, $limit){
        //@method lista todas las facturas almacenadas en orden de id hasta 20
            include_once "./conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $res=$cnx->prepare("SELECT facturas.id, facturas.num_factura, facturas.fecha, facturas.empresa, facturas.nif,
            facturas.contacto, facturas.direccion, facturas.ciudad, facturas.provincia, facturas.cp, facturas.telefono, facturas.observaciones,
            facturas.precio, facturas.id_cuenta FROM facturas, cuentas, mesas, restaurantes WHERE facturas.id_cuenta=cuentas.id 
            AND cuentas.id_mesa=mesas.id AND mesas.id_restaurante=restaurantes.id AND restaurantes.id=$idRest ORDER BY facturas.id DESC LIMIT $limit");
            $res->execute();

            $resultado = array();
            
            foreach($res as $row){
            
                $resultado[] = $row;
            
            }

            return $resultado;
            
        }

        public static function localizarFactura($num_factura, $idRest){
        //@method encuentra una factura a traves de su ID
            error_reporting(0);
            include_once ".././conexion/conexion.php";
            include_once "./conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $res = $cnx->prepare("SELECT facturas.id, facturas.fecha, facturas.num_factura, facturas.empresa, facturas.contacto, facturas.direccion, facturas.ciudad, 
            facturas.provincia, facturas.cp, facturas.telefono, facturas.observaciones, facturas.precio, cuentas.platos FROM facturas, cuentas, mesas 
            WHERE facturas.num_factura=$num_factura AND facturas.id_cuenta=cuentas.id AND cuentas.id_mesa=mesas.id AND mesas.id_restaurante=$idRest");

            $res->execute();
            
            $resultado = array();

            foreach($res as $row){

                $resultado =$row;

            }    

            return $resultado;

        }

        public static function enviarFactura($num_factura, $cuerpo, $email){
        //@method manda mail al correo indicado para enviar la factura generada por correo  

            if($email!=""||$email!=null){
                $destinatario = $email;
                $asunto = "Factura nº ".$num_factura;
            
                $headers = "MIME-Version: 1.0\r\n"; 
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= "From: Equipo de 4bar <arestheferret@gmail.com>\r\n"; 
                if(mail($destinatario,$asunto, $cuerpo, $headers)){
                    header("Location:../historialFacturas.php?enviado=1");
                }else{
                    header("Location:../historialFacturas.php?enviado=0");
                }
            }
            else{
                header("Location:../historialFacturas.php?enviado=0");
            }

        }

        // PLATOS ***********************************************************************************************//

        public static function listarPlatos($idRest){
        //@method lista los platos de base de datos ordenados por categorías  
            include_once "./conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $res=$cnx->prepare("SELECT * FROM `platos` WHERE id_restaurante=$idRest ORDER BY FIELD (categoria, 'entrantes','principales','postres','bebidas')");
            $res->execute();

            $resultado = array();

            foreach($res as $row){
                $resultado[] = $row;
            }
            return $resultado;
        }

        public static function localizarPlato($id, $idRest){
        //@method localiza un plato del restaurante para crear un objeto con el    
            include_once ".././conexion/conexion.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            $res=$cnx->prepare("SELECT id, nombre, categoria, precio FROM `platos` WHERE id=$id AND id_restaurante=$idRest");
            $res->execute();

            $resultado = $res->fetch();
            return $resultado;
        }

        // CIERRE DE DIA ***********************************************************************************************//

        public static function datosCierre($idRest){
        //@method lista el nº de mesas atendidas, el nº de facturas creadas, los clientes totales y el dinero ganado en el dia de hoy    
            include_once ".././conexion/conexion.php";
            
            $fecha = "'".date("Y-n-d")."'";
            
            $conexion = new conexion();
            $cnx = $conexion->connectDB();


            $res=$cnx->prepare("SELECT COUNT(mesas.id) AS mesas, sum(mesas.comensales) AS pax, sum(cuentas.precio) AS beneficios 
                                FROM mesas, cuentas 
                                WHERE mesas.fecha = $fecha 
                                AND cuentas.id_mesa=mesas.id 
                                AND mesas.finalizado=1
                                AND mesas.id_restaurante=$idRest");
            $res->execute();

            $resultado = array();

            foreach($res as $row){
                $resultado = $row;
            }
            return $resultado;
        }

        public static function platosCierre($idRest){
        //@method lista de platos para el cierre de dia    
            include_once ".././conexion/conexion.php";
            $fecha = "'".date("Y-n-d")."'";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();


            $res=$cnx->prepare("SELECT cuentas.platos 
                                FROM cuentas, mesas 
                                WHERE cuentas.id_mesa=mesas.id 
                                AND mesas.fecha=$fecha 
                                AND mesas.id_restaurante=$idRest");

            $res->execute();
            
            $resultado = array();

            foreach($res as $row){
                $resultado[] = $row[0];
            }

            return $resultado;
        }
        
        public static function generarListadoDiscriminativo($listado, $idRest){
        //@method lista de platos para el cierre de dia con los platos deserializados, y los almacena en una tabla temporal
        //que sera eliminada una vez liste los platos cribados
            include_once ".././conexion/conexion.php";
            include_once ".././clases/Platos.php";
            $conexion = new conexion();
            $cnx = $conexion->connectDB();
            foreach($listado as $li){
                $nombre=$li->getNombre();
                $categoria= $li->getCategoria();
                $precio = $li->getPrecio();
                $cantidad = $li->getCantidad();

                $res=$cnx->prepare("INSERT INTO cierres (`id`, `plato`, `categoria`, `precio`, `cantidad`, `id_restaurante`) 
                                    VALUES (null, '$nombre' , '$categoria', $precio, $cantidad, $idRest)"); 
                
                $res->execute();
            }

            $res=$cnx->prepare("SELECT plato, categoria, precio, sum(cantidad) AS cantidad FROM cierres WHERE id_restaurante=$idRest GROUP BY plato");
            $res->execute();

            $resultado=array();

            foreach($res as $row){
                $resultado[] = $row;
            }
            //una vez creado el array discriminativo, borra la tabla y envía el array de vuelta
            $res=$cnx->prepare("DELETE FROM cierres WHERE id_restaurante=$idRest");
            $res->execute();

            return $resultado;
        }

        public static function encoder($string){
            $encoded = base64_encode($string);
            return $encoded;
        }
        
        public static function decoder($string){
            $decoded = base64_decode($string);
            return $decoded;
        }

    }

?>