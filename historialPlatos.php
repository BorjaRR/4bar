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
                            <p class="tx-white text-uppercase">Listado de platos</p>
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
                        <div class="col-12 text-start">
                            <form action="./utils/addPlato.php" method="get" class="formulario d-flex">
                                <button type="submit" id="generarPlato">
                                    <p class="m-0 py-2">
                                        <i class="icofont-plus-circle"></i>
                                        Añadir plato
                                    </p>
                                </button>
                                <input type="text" name="nombre" id="nombre" placeholder="Nombre del plato" 
                                class="mx-3" min="1" required>
                                <select name="categoria" id="categoría" class="me-3">
                                    <option value="entrantes">Entrante</option>
                                    <option value="principales">Principal</option>
                                    <option value="postres">Postre</option>
                                    <option value="bebidas">Bebida</option>
                                </select>
                                 <input type="text" name="precio" id="precio" placeholder="Precio del plato" class=""
                                 min="1" required>
                            </form>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center my-4">
                        <div class="col-10 categorias">
                            <span class="item mx-5 fw-bold selected" data-target="all">All</span>
                            <span class="item mx-5 fw-bold" data-target="entrantes">Entrantes</span>
                            <span class="item mx-5 fw-bold" data-target="principales">Principales</span>
                            <span class="item mx-5 fw-bold" data-target="postres">Postres</span>
                            <span class="item mx-5 fw-bold" data-target="bebidas">Bebidas</span>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-start align-items-start platos pb-5">
                        <div class="col-12">
                            <table class="tablaPlatos w-100">
                                <tr class="titulos">
                                    <th class="text-start ps-4 text-uppercase">Id</th>
                                    <th class="text-start ps-3 text-uppercase">Nombre</th>
                                    <th class="text-start ps-3 text-uppercase">Categoría</th>
                                    <th class="text-start ps-3 text-uppercase">Precio</th>
                                    <th class="text-start ps-3 text-uppercase"></th>
                                </tr>
                                
                                <?php
                                $platos = $dao::listarPlatos($_SESSION['restaurante']['id']);
                                if(!empty($platos)){
                                    $en=1;
                                    $pr=1;
                                    $po=1;
                                    $be=1;
                                    for($i=0;$i<sizeof($platos);$i++){
                                        $nombre=$platos[$i]['nombre'];
                                        $categoria=$platos[$i]['categoria'];
                                        switch($categoria){
                                            case "entrantes":
                                                $id=substr($categoria, 0, 2)."-".$en;
                                                $en++;
                                                break;
                                            case "principales":
                                                $id=substr($categoria, 0, 2)."-".$pr;
                                                $pr++;
                                                break;
                                            case "postres":
                                                $id=substr($categoria, 0, 2)."-".$po;
                                                $po++;
                                                break;
                                            case "bebidas":
                                                $id=substr($categoria, 0, 2)."-".$be;
                                                $be++;
                                                break;
                                        }
                                        $precio=$platos[$i]['precio'];
                                        if($i%2==0){$color="blanco";}else{$color="gris";}
                                        $idPlato = $platos[$i]['id'];
                                        echo "
                                            <tr class=\"tr $categoria\" data-op=\"$categoria\">
                                                <td class=\"text-start ps-3 text-uppercase bg-$color id\">$id</td>
                                                <td class=\"text-start ps-3 bg-$color nombre\">$nombre</td>
                                                <td class=\"text-start ps-3 text-capitalize bg-$color categoria\">$categoria</td>
                                                <td class=\"text-start ps-3 bg-$color precio\">$precio €</td>
                                                <td class=\"text-start ps-3 eliminar\">
                                                    
                                                    <button  onclick=\"sumar_plato($idPlato);\"><i class=\"icofont-plus-circle\"></i></button>
                                                    <form action=\"./utils/eliminarPlato.php\" method=\"post\">
                                                        <button type=\"submit\"><i class=\"icofont-bin borrarPlato\"></i></button>
                                                        <input type=\"password\" name=\"num_conf\" id=\"num_conf\" class=\"num_conf esNumero\" maxlength=\"4\" required>
                                                        <input type=\"hidden\" name=\"id\" value=\"$idPlato\">
                                                    </form>
                                                </td>
                                            </tr>
                                        ";
                                    }
                                    
                                }
                                $_SESSION['platos']=$platos;
                                ?>
                            </table>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="./js/main.js"></script>
<script>
    function sumar_plato(id){
        Swal.fire({
        title: 'Introduce número de mesa y cantidad:',
        html: `<input type="text" id="num_mesa" class="swal2-input" placeholder="Nº de mesa" style="width:15rem;">
        <input type="text" id="cantidad" class="swal2-input" placeholder="Cantidad" style="width:15rem;">`,
        confirmButtonText: 'Añadir',
        focusConfirm: false,
        preConfirm: () => {
            const num_mesa = Swal.getPopup().querySelector('#num_mesa').value
            const cantidad = Swal.getPopup().querySelector('#cantidad').value
            if (!num_mesa || !cantidad) {
            Swal.showValidationMessage(`Nº de mesa o cantidad no válidos`)
            }
            return { num_mesa: num_mesa, cantidad: cantidad }
        }
        }).then((result) => {
            num_mesa = $('#num_mesa').val();
            cantidad = $('#cantidad').val();
            window.location.replace("./utils/addPlatoToMesa.php?id="+id+"&num_mesa="+num_mesa+"&cantidad="+cantidad);
        })
    }
</script>
<?php
    include "./error/errores_platos.php";
?>
</body>
</html>