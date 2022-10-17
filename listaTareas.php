
<?php
    include_once 'src/session.php';
    include_once 'src/conexiondb.php';

    if (isset($_POST['btnCrearTarea'])) {
        $nombre      = $_POST['nombreTarea'];
        $descripcion = $_POST['descTarea'];
        $id_usr      = $_SESSION['id'];
        try {
            $insertSQL  = "INSERT INTO tarea(Nombre,Descripcion,idUsuario,Fecha) VALUES (:nombre,:descripcion,:id_usr,now())";
            $sentencia  = $conexion->prepare($insertSQL);
            $sentencia -> execute(array(':nombre' => $nombre, ':descripcion' => $descripcion, ':id_usr' => $id_usr));

            if ($sentencia->rowCount() == 1) {
                $resultado = header("location: listaTareas.php");
            }
        } catch (PDOException $e) {
            $resultado = "<p class='error' style='color:red; text-align:center;'>A ocurrido un error" . $e->getMessage() . "</p>";
        }
    }

    if (isset($_POST['btnEliminar'])) {
        $id_tar = $_POST['btnEliminar'];
        try {
            $deleteSQL =  "DELETE FROM tarea WHERE id=?";
            $sentencia =  $conexion->prepare($deleteSQL);
            $sentencia->execute([$id_tar]);
        } catch (PDOException $e) {
            echo "<p class='error' style='color:red; text-align:center;'>A ocurrido un error" . $e->getMessage() . "</p>";
        }
    }

    if (isset($_POST['btnGuardar'])) {
        $id_tar = $_POST['btnGuardar'];
        $nombre_tar = $_POST['editNombre'];
        $desc_tar = $_POST['editDesc'];
        try {
            $updateSQL =  "UPDATE tarea SET Nombre = :nombre_tar, Descripcion = :desc_tar, Fecha = now() WHERE id = :id_tar";
            $sentencia =  $conexion->prepare($updateSQL);
            $sentencia->execute(array(':nombre_tar' => $nombre_tar, ':desc_tar' => $desc_tar, ':id_tar' => $id_tar));
        } catch (PDOException $e) {
            echo "<p class='error' style='color:red; text-align:center;'>A ocurrido un error" . $e->getMessage() . "</p>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/custom-styles.css?v=<?php echo time(); ?>">
    <title>Lista Tareas</title>
</head>

<body>
    <header>
        <div class="container">
            <p class="logo">
                <a href="index.php">Sitio Web PHP</a>
            <nav>
                <ul>
                    <?php
                    if (!isset($_SESSION['nombre'])) {
                        header("location: cerrarSesion.php");
                    } else {
                        echo "<li><a href='#'><i class='fa-solid fa-user'></i>" . $_SESSION['nombre'] . "</a></li>";
                        echo "<li><a href='tablero.php'><i class='fa-solid fa-table-columns'></i>Tablero</a></li>";
                        echo "<li><a href='cerrarSesion.php'><i class='fa-solid fa-arrow-right-from-bracket'></i>Cerrar Sesion</a></li>";
                    }
                    ?>
                </ul>
            </nav>
            </p>
        </div>
    </header>
    <h1 class="tareas-title"><?php echo "Tareas de " . $_SESSION['nombre']; ?></h1>
    <hr>
    <div class="agregar">
        <form method="post" class="tarea-form">
            <label for="">Nombre Tarea</label>
            <input type="text" name="nombreTarea">
            <label for="">Descripcion</label>
            <input type="text" name="descTarea">
            <button class="nuevaTar" name="btnCrearTarea">Añadir Tarea <i class="fa-solid fa-plus"></i></button>
        </form>
    </div>
    <div class="lista-tareas">
        <?php
            try {
                $id_usr = $_SESSION['id'];
                $consultaSQL = "SELECT * FROM tarea WHERE idUsuario = :id_usr";
                $sentencia   = $conexion->prepare($consultaSQL);
                $sentencia->execute(array(':id_usr' => $id_usr));

                while ($fila = $sentencia->fetch()) {
                    $id_tar = $fila['id'];
                    $nombre_tar = $fila['Nombre'];
                    $descripcion_tar = $fila['Descripcion'];
                    $fecha_tar = $fila['Fecha'];
                    $id_usr_tar = $fila['idUsuario'];

                    echo  "<div class='tarea'>
                                <h3 class='tarea-titulo'>" . $nombre_tar . "</h3>
                                <p class='tarea-desc'>" . $descripcion_tar . "</p>
                                <p class='tarea-fec'>" . $fecha_tar . "</p>
                                <button type='submit' id='btn-editar' class='boton' name='btnEditar' value='" . $id_tar . "' onclick='mostrarEditar(" . $id_tar . ")'><i class='fa-solid fa-pen-to-square'></i></button>
                                <form action='' method='POST' class='botones'>
                                    <button type='submit' class='boton' id='btn-editar' name='btnEliminar' value='" . $id_tar . "'><i class='fa-solid fa-delete-left'></i></button>
                                </form>
                            </div>
                            <div id='menu-editar-" . $id_tar . "' style='visibility: hidden;' class='menu-editar'>
                                <strong>Editar " . $nombre_tar . "</strong>
                                <form method='post'>
                                    <input type='text' name='editNombre' value='" . $nombre_tar . "'>
                                    <input type='text' name='editDesc' class='edit-desc' value='" . $descripcion_tar . "'>
                                    <button type='submit' name='btnGuardar' value='" . $id_tar . "'>Guardar<i class='fa-solid fa-floppy-disk'></i></button>
                                </form>
                            </div>";
                            
                }
            } catch (PDOException $e) {
                $resultado = "<p class='error' style='color:red; text-align:center;'>A ocurrido un error" . $e->getMessage() . "</p>";
            }
        ?>
    </div>
    <script src="./src/index.js"></script>
</body>

</html>