<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se está enviando el ID del producto
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para borrar el producto (borrado lógico)
    $sql = "UPDATE productos SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Asegúrate de que el tipo de parámetro y el valor se pasan correctamente
    $stmt->bind_param("i", $id); // "i" indica que el parámetro es un entero

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Producto borrado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar el statement
    $stmt->close();
} else {
    echo "ID de producto no especificado o vacío.";
}

// Cerrar la conexión
$conn->close();
?>