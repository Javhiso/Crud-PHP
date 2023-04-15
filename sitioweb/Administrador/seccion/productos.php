<?php include('../template/cabecera.php'); ?>
<?php


$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$txrPrecio = 0; // Valor inicial específico
$txtproducto = "";


include("../config/bd.php");

/*echo $txtID . "<br/>";
echo $txtNombre . "<br/>";
echo $txtImagen . "<br/>";
echo $accion . "<br/>";*/





switch ($accion) {
    case "Agregar":
        //INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'Libro de PHP', 'imagen.jpg');

        $sentenciaSQL = $conexion->prepare("INSERT INTO productos ( nombre, imagen,precio,descripcion) VALUES ( :nombre, :imagen,:precio,:descripcion);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':precio', $txtPrecio);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }



        $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        //echo "Presionado botón Agregar";

        break;

    case "Modificar":
        // echo "Presionado botón Modificar";
        $sentenciaSQL = $conexion->prepare("UPDATE  productos SET nombre =:nombre,precio=:precio , descripcion=:descripcion  WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':precio', $txtPrecio);
        $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();

        if ($txtImagen != "") {

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);


            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM productos WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($producto["imagen"]) && ($productos["imagen"]) != "imagen.jpg") {
                if (file_exists("../../img/" . $productos["imagen"])) {
                    unlink("../../img/" . $productos["imagen"]);
                }
            }

            $sentenciaSQL = $conexion->prepare("UPDATE productos SET imagen =:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':id', $txtID);

            $sentenciaSQL->execute();
            header("Location:productos.php");
        }
        break;

    case "Cancelar":
        header("Location:productos.php");

        //echo "Presionado botón Cancelar";
        break;
    case "Seleccionar":
        //echo "Presionado botón Seleccionar";
        $sentenciaSQL = $conexion->prepare("SELECT*FROM productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $productos = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $productos['nombre'];
        $txtImagen = $productos['imagen'];
        $txtPrecio = $productos['precio'];
        $txtDescripcion = $productos['descripcion'];
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $productos = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($productos["imagen"]) && ($productos["imagen"]) != "imagen.jpg") {
            if (file_exists("../../img/" . $productos["imagen"])) {
                unlink("../../img/" . $productos["imagen"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM productos WHERE id=:id ");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        // echo "Presionado botón Borrar";
        break;
}
$sentenciaSQL = $conexion->prepare("SELECT*FROM productos");
$sentenciaSQL->execute();
$listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);



?>


<div class="col-md-6">

    <div class="card">
        <div class="card-header">
            Carga de Productos
        </div>

        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">

                </div>
                <div class="form-group">
                    <label for="txtID">Nombre:</label>
                    <input type="text" required class="form-control" name="txtNombre" value="<?php echo $txtNombre; ?>" id="txtNombre" placeholder="Nombre del Producto">

                </div>
                <div class="form-group">
                    <label for="txtID">Precio:</label>
                    <input type="text" required class="form-control" name="txtPrecio" value="<?php echo $txrPrecio; ?>" id="txtPrecio" placeholder="Precio">

                </div>
                <div class="form-group">
                    <label for="txtID">Descripción:</label>
                    <input type="text" required class="form-control" name="txtDescripcion" value="<?php echo $txtDescripcion; ?>" id="txtDescripcion" placeholder="Descripción">

                </div>
                <div class="form-group">
                    <label for="txtID">Imagen:</label>
                    <br />
                    <?php
                    if ($txtImagen != "") { ?>
                        <img class="img-thumbail rounded" src=" ../../img/<?php echo $txtImagen ?>" width="50" alt="">
                    <?php } ?>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="ID">
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : "" ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion !== "Seleccionar") ? "disabled" : "" ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion !== "Seleccionar") ? "disabled" : "" ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>


            </form>

        </div>

    </div>
</div>
<div class="col-md-8">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaProductos as $productos) { ?>
                <tr>
                    <td><?php echo $productos['id'] ?></td>
                    <td><?php echo $productos['nombre'] ?></td>
                    <td><?php echo $productos['Precio'] ?></td>
                    <td><?php echo $productos['descripcion'] ?></td>
                    <td>
                        <img class="img-thumbail rounded" src=" ../../img/<?php echo $productos['imagen'] ?>" width="50" alt="">
                    <td>

                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $productos['id'] ?>" />
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />

                        </form>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>



<?php include('../template/pie.php'); ?>