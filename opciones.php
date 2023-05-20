<?php
session_start();
include_once "./complementos/cabecera_main.php";
?>
<body>

<?php
include_once("./clases/DAO.php");
include_once("./clases/Restaurantes.php");

$dao = new Metodos();
$rest = $dao::recuperarRestaurante($_SESSION['restaurante']['email'], $_SESSION['restaurante']['pass']);
if($rest){
    $restaurante = new Restaurante($rest);
}else{
    header("Location:./utils/cierreSesion.php");
}

?>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-start">

            <div class="col-2 text-center tx-white menu p-0 sticky-top">
                <?php
                    include_once "./menu/menu.php";
                ?>
            </div>

            <div class="col-10 text-center tx-white bg-restaurante p-0">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center align-items-center pt-3 infoRest">
                        <div class="col-8 text-start">
                            <p class="tx-white text-uppercase">Información del restaurante</p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-5 informacion p-4">
                            <?php
                            
                            echo "<p class=\"text-uppercase\">Restaurante \"".$restaurante->getNombre()."\"</p>";
                            echo "<p class=\"text-uppercase\">NIF: ".$restaurante->getNif()." </p>";
                            if($restaurante->getDireccion()!=""){
                                echo "<p class=\"\">".$restaurante->getDireccion()." - ".$restaurante->getCp()."</p>";
                            }
                            echo "<p class=\"\">Email: ".$restaurante->getEmail()." </p>";
                            echo "<p class=\"text-capitalize\">Teléfono de contacto: ".$restaurante->getTelefono()." </p>";
                            if($restaurante->getContacto()!=""){
                                echo "<p class=\"text-capitalize\">Persona de contacto: ".$restaurante->getContacto()." </p>";
                            }
                            ?>
                            <span>¿Quieres <a href="datosUsuario.php">cambiar tus datos</a>? Recuerda que no podrás cambiar todos, solamente algunos.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>


<script src="./js/main.js"></script>
</body>
</html>