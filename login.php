<?php
session_start();
require_once 'conexion.php';

// Redirigir si ya hay sesión activa
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $clave = $_POST['clave'];
    $llave = '$0fTM1M'; // La misma llave utilizada en la encriptación

    if (empty($usuario) || empty($clave)) {
        $mensaje_error = 'Por favor, introduce usuario y contraseña.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM adm_usuario WHERE usuario = :usuario AND clave = AES_ENCRYPT(:clave, :llave)");
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':clave', $clave);
            $stmt->bindParam(':llave', $llave);
            $stmt->execute();
            $usuario_db = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario_db) {
                $_SESSION['usuario'] = $usuario_db['usuario'];
                header('Location: index.php');
                exit();
            } else {
                $mensaje_error = 'Usuario o contraseña incorrectos.';
            }
        } catch (PDOException $e) {
            $mensaje_error = 'Error al consultar la base de datos: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AEOLUS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>   
<link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="fondo">
        <div class="contenedor_login">
            <div class="contenedor_logo">
                <img src="https://i.imgur.com/apvQa7t.png" alt="Logotipo AEOLUS" class="logo">
            </div>
            <div class="login">
                <form action="" method="post">
                    <?php if (isset($mensaje_error)): ?>
                        <p style="color: red; text-align: center;"><?php echo $mensaje_error; ?></p>
                    <?php endif; ?>
                    <div class="contenedor_campo">
                        <input type="text" class="campo" id="usuario" name="usuario" placeholder="Usuario" required>
                     <div class="icono">
                        <i class='bx bxs-user'></i>
                     </div>
                    </div>
                    <div class="contenedor_campo">
                        <input type="password" class="campo" id="clave" name="clave" placeholder="Contraseña" required>
                      <div class="icono">
                        <i class='bx bxs-key'></i>
                      </div>
                    </div>
                    <button type="submit" class="btn_ingresar">INGRESAR</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>