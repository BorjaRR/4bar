<?php
    include_once "./complementos/cabecera_intro.php";
?>
<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-content-center">
            <div class="col-6 tx-white my-5">
                <h1 class="tx-white">Registro de restaurante</h1>
                <p class="bienvenida">
                    Bienvenido a 4BAR, una plataforma interactiva para la gestión de restaurantes que te facilitará el trabajo de tu negocio. Si aún no nos conoces
                    regístrate, y comienza a vivir la gestion de tu local de la manera mas fácil y cómoda posible. 
                    <span class="fw-bold">Recuerda que todos los campos con asterisco (*) son obligatorios.</span> 
                </p>
                <form action="./utils/registro.php" method="get" name="registro">
                <a href="index.php" class="d-block">Volver al inicio</a>
                    <label for="nombre">Nombre del restaurante*</label>
                    <input type="text" name="nombre" id="nombre" class="d-block" required>
                    
                    <label for="nif">NIF*</label>
                    <input type="text" name="nif" id="nif" class="d-block" minlength="9" maxlength="9" required>

                    <label for="telefono">Telefono*</label>
                    <input type="text" name="telefono" id="telefono" class="d-block" required>

                    <label for="email">Email*</label>
                    <input type="email" name="email" id="email" class="d-block" placeholder="ejemplo@server.com" oninvalid="alert('Mail no válido.')" required>

                    <label for="pass">Contraseña*</label>
                    <p style="cursor:pointer;" class="ojo d-inline">
                        <i class="icofont-eye-blocked" value="no"></i>
                    </p>
                    <input type="password" name="pass" id="pass" class="d-block" placeholder="De 8 a 12 caracteres" minlength="8" maxlength="12" required>
                    <a class="generarPass d-block">Generar contraseña segura</a>
                    

                    <label for="pass2">Repite tu contraseña*</label>
                    <input type="password" name="pass2" id="pass2" class="d-block" minlength="8" maxlength="12" required>
                    
                    
                    <label for="adress">Dirección</label>
                    <input type="text" name="adress" id="adress" class="d-block">

                    <label for="cp">Código Postal</label>
                    <input type="text" name="cp" id="cp" class="d-block" minlength="5" maxlength="5">

                    <label for="contacto">Persona de contacto</label>
                    <input type="text" name="contacto" id="contacto" class="d-block">

                    <label for="css">Código de seguridad (4 cifras)*</label>
                    <input type="password" name="css" id="css" class="d-block mb-3" required placeholder="Este código servirá mas tarde para confirmar solicitudes mas adelante." minlength="4" maxlength="4"> 

                    <input type="checkbox" name="pp" id="pp" value="1" class="pp" required><label for="pp" class="ps-3">Consiento el tratamiento de mis datos según la <a href="polPrivacidad.php" target="_blank">Política de privacidad.</a></label>

                    <button id="registrar" type="submit" class="mt-4">Registrarse</button>
                </form>
            </div>
        </div>
    </div>


<script src="./js/script.js"></script>
<?php
    include "./error/errores_index.php";
?>
</body>
</html>