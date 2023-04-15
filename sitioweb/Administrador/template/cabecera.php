<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../index.php");
} else {
    if ($_SESSION['usuario'] == "ok") {
        $nombreUsuario = $_SESSION["nombreUsuario"];
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Gestion de productos</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/sitioweb" ?>




    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Administrador del sitio web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="<?php echo $url; ?>/administrador/inicio.php">Inicio</a>
                    <a class="nav-link" href="<?php echo $url; ?>/administrador/seccion/productos.php">Productos</a>
                    <a class="nav-link" href="<?php echo $url; ?>/administrador/seccion/cerrar.php">Cerrar Administrador</a>
                    <a class="nav-link" href="<?php echo $url; ?>">Ver Sitio Web</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <br />

        <div class="row">