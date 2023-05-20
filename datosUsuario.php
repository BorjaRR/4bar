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
$cpRest = $restaurante->getCp()==0 ? "" : $restaurante->getCp();
?>
    <div class="container-fluid index">
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
                    <div class="row d-flex justify-content-center align-items-start platos">
                        <div class="col-6 my-5">
                            <form action="./utils/cambiarDatos.php" method="post" class="formulario_informacion">
                                <span class="d-block text-start mb-3">
                                    ¡Importante! El NIF no podra actualizarse por motivos de seguridad.
                                    para más información o solicitar un cambio ponte en contacto con el equipo
                                    de 4bar.
                                </span>
                                <label for="nombre">Nombre del restaurante*</label>
                                <input type="text" name="nombre" id="nombre" class="d-block" value="<?php echo $restaurante->getNombre(); ?>" required>
                                
                                <label for="nif">NIF*</label>
                                <input type="text" name="nif" id="nif" class="d-block" value="<?php echo $restaurante->getNif(); ?>" minlength="9" maxlength="9"  required readonly="readonly">

                                <label for="telefono">Telefono*</label>
                                <input type="text" name="telefono" id="telefono" class="d-block esNumero" value="<?php echo $restaurante->getTelefono(); ?>" required>

                                <label for="email">Email*</label>
                                <input type="email" name="email" id="email" class="d-block" value="<?php echo $restaurante->getEmail(); ?>" oninvalid="alert('Mail no válido.')" required>

                                <label for="pass">Contraseña*</label>
                                <p style="cursor:pointer;" class="ojo d-inline">
                                    <i class="icofont-eye-blocked" value="no"></i>
                                </p>
                                <input type="password" name="pass" id="pass" class="d-block" placeholder="Indica nueva contraseña" minlength="8" maxlength="12" value="<?php echo $restaurante->getPass(); ?>" required>
                                <a class="generarPass d-block">Generar contraseña segura</a>
                                

                                <label for="pass2">Repite tu contraseña*</label>
                                <input type="password" name="pass2" id="pass2" class="d-block" placeholder="Repite la contraseña" minlength="8" maxlength="12" value="<?php echo $restaurante->getPass(); ?>" required>
                                
                                
                                <label for="direccion">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="d-block" value="<?php echo $restaurante->getDireccion(); ?>">

                                <label for="cp">Código Postal</label>
                                <input type="text" name="cp" id="cp" class="d-block esNumero" value="<?php echo $cpRest ?>" minlength="5" maxlength="5">

                                <label for="contacto">Persona de contacto</label>
                                <input type="text" name="contacto" id="contacto" class="d-block" value="<?php echo $restaurante->getContacto(); ?>">

                                <label for="css">Código de seguridad (4 cifras)*</label>
                                <input type="password" name="css" id="css" class="d-block esNumero" value="<?php echo $restaurante->getNumConf(); ?>" required placeholder="Este código servirá mas tarde para confirmar solicitudes mas adelante." minlength="4" maxlength="4"> 

                                <input type="hidden" name="id" value="<?php echo $restaurante->getId(); ?>">
                                
                                <button id="cambiarDatos" type="submit" class="mt-4">Validar cambios</button>
                            </form>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="./js/main.js"></script>
<script src="./js/script.js"></script>
</body>
</html>