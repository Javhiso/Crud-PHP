<?php
include('template/cabecera.php');
?>


<div class="col-md-12">
    <div class="jumbotron text-center">
        <h1 class="display-3">Bienvenido <?php echo $nombreUsuario; ?></h1>
        <p class="lead">Sistema de carga de productos</p>
        <hr class="my-2">

        <p class="lead">
            <a class="btn btn-primary btn-lg" href="seccion/productos.php" role="button">Administrar Productos</a>
        </p>
    </div>
</div>

<?php
include('template/pie.php');
?>