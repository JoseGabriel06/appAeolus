<?php
require_once '../conexion.php';

if (isset($_POST['modelo'])) {
    $modelo = $_POST['modelo'];

    try {
        $stmt = $pdo->prepare("SELECT foto FROM foto_producto WHERE modelo = :modelo");
        $stmt->bindParam(':modelo', $modelo);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && $resultado['foto']) {
            // Devolver la imagen codificada en Base64
            echo base64_encode($resultado['foto']);
        } else {
            // Devolver un mensaje o una imagen por defecto si no se encuentra
            echo ''; // O podrías devolver la URL de una imagen por defecto
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo "Error al consultar la base de datos: " . $e->getMessage();
    }
} else {
    http_response_code(400);
    echo "Modelo no proporcionado.";
}
?>