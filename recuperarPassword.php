
<?php
    include_once 'src/session.php';
    include_once 'src/conexiondb.php';

    if (isset($_POST['btnResetearPassword'])) {
        $nuevoPassword    = $_POST['nuevoPassword'];
        $confirmaPassword = $_POST['confirmePassword'];
        $email            = $_POST['email'];
        if ($nuevoPassword != $confirmaPassword) {
            $resultado = "<p class='error', style='color:red; text-align:center;'>Los Passwords no coinciden</p>";
        }else{
            try {
                $consultaSQL  =  "SELECT email FROM usuario WHERE email=:email";
                $sentencia    =  $conexion->prepare($consultaSQL);
                $sentencia   ->  execute(array(':email'=>$email));
                if ($sentencia->rowCount()==1) {
                    $passwordEnc   =  password_hash($nuevoPassword, PASSWORD_DEFAULT);
                    $SQLActualizar =  "UPDATE usuario SET password  = :password WHERE email = :email";
                    $sentencia     =  $conexion -> prepare($SQLActualizar);
                    $sentencia     -> execute(array(':password' => $passwordEnc, ':email' => $email));
                    $resultado     =  header("location: inicioSesion.php");
                }else{
                    $resultado = "<p class='error', style='color:red; text-align:center;'> El email proporcionado no existe en la base de datos. Porfavor Ingrese un email registrado </p>";
                }
            } catch (PDOException $e) {
                $resultado = "<p class='error' style='color:red; text-align:center;'>A ocurrido un error" . $e->getMessage() . "</p>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Recuperar Contraseña</title>
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
        if (isset($resultado)) {
            echo $resultado;
        }
    ?>

    <section>
        <section class="form-section">
                <div class="container">
                    <form method="post" class="form">
                        <label for="email">Email</label>
                        <input type="text" name="email" placeholder="Ingrese su Email" required>
                        <label for="nuevoPassword">Nuevo password</label>
                        <input type="password" name="nuevoPassword" placeholder="Ingrese su nuevo password" required>
                        <label for="confirmePassword">Confirme Nuevo password</label>
                        <input type="password" name="confirmePassword" placeholder="Confirme su nuevo password" required>
                        <button type="submit" name="btnResetearPassword" class="button">Resetear Password</button>
                    </form>
                </div>
        </section>
    </section>
</body>
</html>