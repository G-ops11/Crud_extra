<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Aquí puedes continuar con tu lógica para ver los detalles del producto
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM productos WHERE id = $id AND deleted_at IS NULL";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        echo "Nombre: " . $producto['nombre'] . "<br>";
        echo "Descripción: " . $producto['descripcion'] . "<br>";
        echo "Precio: " . $producto['precio'] . "<br>";
        echo "Cantidad: " . $producto['cantidad'] . "<br>";
    } else {
        echo "No se encontró el producto.";
    }
} else {
    echo "ID de producto no especificado.";
}

// Cerrar la conexión
$conn->close();
?>