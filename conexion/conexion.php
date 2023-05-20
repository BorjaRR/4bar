<?php

    class conexion{

        public function connectDB(){
           
                $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
                $user = "root";
                $pass = "";
                $db ='mysql:host=localhost;dbname=4bar';

                $conexion = new PDO($db, $user, $pass, $opc);
                return $conexion;

        }

    }


?>