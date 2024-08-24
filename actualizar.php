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

    // Preparar la consulta para obtener los datos del producto
    $sql = "SELECT * FROM productos WHERE id = ? AND deleted_at IS NULL";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vincular el parámetro y ejecutar la consulta
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Producto no encontrado o ya ha sido borrado.");
    }

    $producto = $result->fetch_assoc();

    // Si el formulario ha sido enviado, actualizar el producto
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];

        // Preparar la consulta para actualizar el producto
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }

        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $id);

        if ($stmt->execute()) {
            echo "Producto actualizado exitosamente.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();
    }
} else {
    echo "ID de producto no especificado.";
}

// Cerrar la conexión
$conn->close();
?>

<!-- Formulario para actualizar el producto -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: 0 auto; padding: 20px; }
        form { display: flex; flex-direction: column; }
        label { margin-bottom: 5px; }
        input, textarea { margin-bottom: 10px; padding: 8px; }
        button { padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Actualizar Producto</h2>
        <form method="post" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" step="0.01" required>

            <button type="submit">Actualizar Producto</button>
        </form>
    </div>
</body>
</html>