
<?php
    include_once 'src/session.php';
    include_once 'src/conexiondb.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/custom-styles.css">
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
                        <?php
                            if(!isset($_SESSION['nombre'])){
                                echo "<li><a href='inicioSesion.php'>Iniciar Sesión</a></li>";
                                echo "<li><a href='registro.php'>Registrar</a></li>";
                            }else{
                                echo "<li><a href='#'><i class='fa-solid fa-user'></i>" . $_SESSION['nombre'] . "</a></li>";
                                echo "<li><a href='tablero.php'><i class='fa-solid fa-table-columns'></i>Tablero</a></li>";
                                echo "<li><a href='listaTareas.php'><i class='fa-solid fa-clipboard-check'></i>Lista de Tareas</a></li>";
                                echo "<li><a href='cerrarSesion.php'><i class='fa-solid fa-arrow-right-from-bracket'></i>Cerrar Sesion</a></li>";
                            }
                        ?>
                    </ul>
                </nav>
            </p>
        </div>
    </header>
    <section>
        <div class="container">
            <div class="left-side">
                <h1>Diseño Sitio <br> Responsive</h1>
            </div>
            <div class="right-side">
                <img src="svg/developer_activity.svg" alt="Imagen SVG">
            </div>
        </div>
    </section>
    <footer class="static">
        <p>&copy; ESPE-SW</p>
    </footer>
</body>
</html>