<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit(); 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="https://i.imgur.com/ruT4OZW.png">
    <link rel="stylesheet" href="css/menu.css">
    <title>Menú - AEOLUS</title>
</head>
<body>
    <div class="fondo">
        <nav class="sidebar">
            <div class="contenedor_logo">
                <img src="https://i.imgur.com/apvQa7t.png" alt="AEOLUS" class="logo">
            </div>
            <ul class="menu">
                <li class="opcion">
                    <div class="icono">
                      <i class='bx bx-package'></i>
                    </div>
                    <a href="formularios/registro_pedido.php">
                       Registro
                    </a>
                </li>
                <li class="opcion">
                   <div class="icono">
                   <i class='bx bx-search-alt-2'></i>
                   </div>
                    <a href="formularios/consulta_pedido.php">
                       Consulta
                    </a>
                </li>
            </ul>

                <div class="contenedor_titulo_cs">
                    <i class='bx bx-log-out-circle'></i>
                <a href="logout.php" class="cerrar_sesion">
                    <h2 class="titulo_cs">
                    Cerrar Sesi&oacuten
                    </h2>
                </a>
                </div>
        </nav>
    </div>
</body>
</html>