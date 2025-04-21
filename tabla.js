$(document).ready(function() {
    var tablaProductos = $('#tabla_productos').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        select: true // Habilitar la selección de filas
    });

    // Evento para detectar la selección de una fila
    tablaProductos.on('select', function (e, dt, type, indexes) {
        if (type === 'row') {
            var data = tablaProductos.rows(indexes).data().toArray();
            var modelo = data[0][1]; // El modelo está en la segunda columna (índice 1)
            mostrarImagenModal(modelo);
        }
    });
});

function mostrarImagenModal(modelo) {
    $.ajax({
        url: 'obtener_imagen.php', // Archivo PHP para obtener la imagen
        method: 'POST',
        data: { modelo: modelo },
        dataType: 'text', // Esperamos la URL de la imagen como texto
        success: function(data) {
            $('#imagenProducto').attr('src', 'data:image/jpeg;base64,' + data); // Mostrar la imagen en el modal
            $('#imagenModal').css('display', 'block'); // Mostrar el modal
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener la imagen:", error);
            alertify.error("Error al cargar la imagen.");
        }
    });

    // Cerrar el modal al hacer clic en la 'x'
    $('.cerrarModal').on('click', function() {
        $('#imagenModal').css('display', 'none');
    });

    // Cerrar el modal al hacer clic fuera del contenido
    $(window).on('click', function(event) {
        if (event.target == $('#imagenModal')[0]) {
            $('#imagenModal').css('display', 'none');
        }
    });
}