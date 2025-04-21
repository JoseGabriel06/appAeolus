<?php
require_once '../conexion.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit(); 
}

// Consulta a la base de datos
try {
    $stmt = $pdo->prepare("
        SELECT
            p.idproducto,
            p.modelo,
            c.nombre AS categoria,
            p.nombre,
            p.calidad,
            pp.venta AS precio,
            COALESCE(e.cantidad, 0) AS existencia
        FROM adm_producto p
        JOIN inv_categorias c ON p.idcategoria = c.idcategoria
        JOIN adm_precio_producto pp ON p.idproducto = pp.idproducto
        LEFT JOIN existencia e ON p.idproducto = e.idproducto
        WHERE p.estado = 1
    ");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css"> 
    <link rel="stylesheet" href="../css/consulta_pedido.css">
    <title>Consulta de Pedidos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Consulta de Productos</h1>

    <table id="tabla_productos" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Modelo</th>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Calidad</th>
                <th>Precio</th>
                <th>Existencia</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo $producto['idproducto']; ?></td>
                    <td><?php echo $producto['modelo']; ?></td>
                    <td><?php echo $producto['categoria']; ?></td>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td><?php echo $producto['calidad']; ?></td>
                    <td><?php echo $producto['precio']; ?></td>
                    <td><?php echo $producto['existencia']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>ID Producto</th>
                <th>Modelo</th>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Calidad</th>
                <th>Precio</th>
                <th>Existencia</th>
            </tr>
        </tfoot>
    </table>

    <div id="imagenModal" class="modal-imagen">
        <div class="modal-contenido-imagen">
            <span class="cerrar-modal-imagen">&times;</span>
            <img id="imagenProducto" src="" class="imagen-producto">
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    <script src="../js/tabla.js"></script>
</body>
</html>