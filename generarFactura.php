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
    <div class="container-fluid index">
        <div class="row d-flex justify-content-center align-items-start">

            <div class="col-2 text-center tx-white menu p-0 sticky-top">
                <?php
                    include_once "./menu/menu.php";
                ?>
            </div>

            <div class="col-10 text-center tx-white pizarra p-0">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center align-items-center pt-3 titulo">
                        <div class="col-8 text-start">
                            <p class="tx-white text-uppercase">NUEVA FACTURA</p>
                        </div>
                        <div class="col-4">
                            <p class="fecha m-0">
                                <?php echo date("d-n-y"); ?>
                            </p>
                            <p class="comensales m-0">
                                <?php
                                $res = $dao::contarReservas($restaurante->getId());

                                ?>
                                Nº de reservas: <?php echo $res[0]; ?> (<?php echo $res[1]; ?>pax)
                            </p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-start align-items-start">
                        <div class="col-6 my-3">
                            <h4>Formulario de registro de nueva factura</h4>
                        </div>
                        <hr class="regFactura">
                    </div>
                    <div class="row d-flex justify-content-start align-items-start platos">
                        <div class="col-12 text-start">
                            <form action="./utils/addFactura.php" method="post" class="nuevaFactura d-flex px-5 ">
                                <div class="columna-izquierda w-50">
                                    <label for="empresa">Nombre de empresa*</label>
                                    <input type="text" name="empresa" id="empresa" required>

                                    <label for="nif">NIF*</label>
                                    <input type="text" name="nif" id="nif" minlength="9" maxlength="9"  required>

                                    <label for="direccion">Dirección fiscal*</label>
                                    <input type="text" name="direccion" id="direccion" required>

                                    <label for="cp">Código postal*</label>
                                    <input type="text" name="cp" id="cp" class="esNumero" required>

                                    <label for="ciudad">Ciudad*</label>
                                    <input type="text" name="ciudad" id="ciudad" required>

                                    <label for="provincia">Provincia*</label>
                                    <input type="text" name="provincia" id="provincia" required>   
                                </div>
                                <div class="columna-derecha w-50">
                                    <label for="telefono">Teléfono*</label>
                                    <input type="text" name="telefono" id="telefono" class="esNumero" minlength="9" maxlength="9" required>
                                    
                                    <label for="contacto">Persona de contacto*</label>
                                    <input type="text" name="contacto" id="contacto" required>

                                    <label for="id_cuenta">Identificador de cuenta*</label>
                                    <input type="text" name="id_cuenta" id="id_cuenta" placeholder="<?php echo $_REQUEST['id_cuenta']?>" disabled>
                                    <input type="hidden" name="id_mesa" value="<?php echo $_REQUEST['id_mesa']?>">
                                    <input type="hidden" name="id_cuenta" value="<?php echo $_REQUEST['id_cuenta']?>">

                                    <label for="observaciones">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones" cols="20" rows="5" maxlength="400" placeholder="Máximo 400 caracteres"></textarea>
                                    <button id="generarFactura" type="submit" class="pt-2"><i class="icofont-plus-circle"></i> Generar factura</button>
                                </div>
                            </form>  
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


<script src="./js/main.js"></script>
<?php
    include "./error/errores_facturas.php";
?>
</body>
</html>