
<?php
    include_once 'src/session.php';
    include_once 'src/conexiondb.php';

    if(isset($_POST['btnRegistro'])){
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordenc = password_hash($password, PASSWORD_DEFAULT);
            try {
                $insertSQL = "INSERT INTO Usuario(nombre,password,email,fecha) VALUES (:nombre,:password,:email, now())";
                $sentencia = $conexion->prepare($insertSQL);
                $sentencia->execute(array(':nombre'=>$nombre, ':password'=>$passwordenc,':email'=>$email));

                if ($sentencia->rowCount()==1) {
                    $resultado=header("location: inicioSesion.php");
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
    <link rel="stylesheet" href="styles.css">
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
    <div class="form-section">
        <div class="container">
            <form method="post" class="form">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" placeholder="Ingrese el nombre del Usuario" required>
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Ingrese su correo" required>
                <label for="password">Contraseña</label>
                <input type="password" name="password" placeholder="Ingrese el password" required>
                <label for="confirmarpassword">Confirma</label>
                <input type="password" name="confirmarpassword" placeholder="Ingrese el password de nuevo" required>
                <button type="submit" name="btnRegistro" class="button">Registrar</button>
            </form>
        </div>
    </div>
    <footer class="static">
        <p>&copy; ESPE-SW</p>
    </footer>
</body>
</html>