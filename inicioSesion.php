
<?php
    include_once 'src/session.php';
    include_once 'src/conexiondb.php';

    if(isset($_POST['btnInicio'])){
        $usuario = $_POST['nombreUsuario'];
        $password = $_POST['password'];

        try {
            $consultaSQL = "SELECT * FROM Usuario WHERE nombre = :nombre";
            $sentencia   = $conexion->prepare($consultaSQL);
            $sentencia -> execute(array(':nombre' => $usuario));

            while ($fila = $sentencia -> fetch()) {
                $id = $fila['id'];
                $passwordenc = $fila['password'];
                $nombre = $fila['nombre'];

                if(password_verify($password,$passwordenc)){
                    $_SESSION['id']=$id;
                    $_SESSION['nombre']=$nombre;
                    header("location: tablero.php");
                }else{
                    $resultado = "<p class='error' style='color:red; text-align:center;'>Usuario o password no validos</p>";
                }
            }
        } catch (PDOException $e) {
            $resultado = "<p class='error' style='color:red; text-align:center;'>A ocurrido un error" . $e->getMessage() . "</p>";
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
    <link rel="stylesheet" href="./css/styles.css">
    <title>Document</title>
</head>
<body>
<header>
        <div class="container">
            <p class="logo">
                <a href="index.php">Sitio Web PHP</a>
                <nav>
                    <ul>
                        <li><a href="inicioSesion.php">Iniciar Sesión</a></li>
                        <li><a href="registro.php">Registro</a></li>
                    </ul>
                </nav>
            </p>
        </div>
    </header>

    <?php
        if(isset($resultado)){
            echo $resultado;
        }
    ?>
    
    <div class="form-section">
        <div class="container">
            <form method="POST" class="form">
                <label for="nombreUsuario">Usuario</label>
                <input type="text" name="nombreUsuario" placeholder="Ingrese el nombre de usuario" required>
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Ingrese el password" required>
                <a href="recuperarPassword.php">¿Olvidó su contraseña?</a>
                <button type="submit" name="btnInicio" class="button">Iniciar Sesión</button>
            </form>
        </div>
    </div>
    <footer class="static">
        <p>&copy; ESPE-SW</p>
    </footer>
</body>
</html>