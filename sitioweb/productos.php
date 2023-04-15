<?php include("template/cabecera.php"); ?>

<?php include("administrador/config/bd.php");

$sentenciaSQL = $conexion->prepare("SELECT*FROM productos");
$sentenciaSQL->execute();
$listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<?php foreach ($listaProductos as $productos) { ?>
    <div class="col-md-3">


        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="./img/<?php echo $productos['imagen']; ?>" width="30" alt="imagenes-productos" />
            <div class="card-body">
                <h5 class="card-title">Descripción</h5>
                <p class="card-text"><?php echo $productos['descripcion']; ?></p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Nombre Producto: <?php echo $productos['nombre']; ?></li>
                <li class="list-group-item">Precio: $<?php echo  $productos['Precio']; ?></li>

            </ul>
            <!--<div class="card-body">
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>-->
        </div>

        <br />
    </div>
<?php } ?>






<?php include("template/pie.php"); ?>