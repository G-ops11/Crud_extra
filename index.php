<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Productos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Crear Producto</h2>
        <form method="post" action="crear.php">
            Nombre: <input type="text" name="nombre" required><br>
            Descripción: <textarea name="descripcion"></textarea><br>
            Precio: <input type="number" step="0.01" name="precio" required><br>
            Cantidad: <input type="number" name="cantidad" required><br>
            <input type="submit" name="crear" value="Crear Producto">
        </form>

        <div class="table-container">
            <h2>Lista de Productos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Conexión a la base de datos
                    $conn = new mysqli("localhost", "root", "", "proyecto");

                    // Verificar la conexión
                    if ($conn->connect_error) {
                        die("La conexión ha fallado: " . $conn->connect_error);
                    }

                    // Consulta para leer los productos
                    $sql = "SELECT * FROM productos WHERE deleted_at IS NULL";
                    $result = $conn->query($sql);

                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Salida de datos para cada fila
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["nombre"] . "</td>";
                            echo "<td>" . $row["descripcion"] . "</td>";
                            echo "<td>" . $row["precio"] . "</td>";
                            echo "<td>" . $row["cantidad"] . "</td>";
                            echo "<td class='table-actions'>
                                    <a href='actualizar.php?id=" . $row["id"] . "'><i class='fas fa-edit'></i></a>
                                    <a href='borrado.php?id=" . $row["id"] . "'><i class='fas fa-trash'></i></a>
                                    <a href='ver.php?id=" . $row["id"] . "'><i class='fas fa-eye'></i></a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay productos disponibles</td></tr>";
                    }

                    // Cerrar la conexión
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>