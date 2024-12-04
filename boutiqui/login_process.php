<?php
session_start();

// Verifica si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'boutique');

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Escapar los datos para evitar inyecciones SQL
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Buscar usuario en la base de datos
    $sql = "SELECT id, password, role FROM usuarios WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña ingresada contra la almacenada
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            header("Location: index11.php"); // Redirecciona al panel principal
            exit;
        } else {
            echo "Contraseña incorrecta. <a href='login.php'>Intentar de nuevo</a>";
        }
    } else {
        echo "Usuario no encontrado. <a href='login.php'>Intentar de nuevo</a>";
    }

    $conn->close();
} else {
    echo "No se enviaron datos del formulario. <a href='login.php'>Intentar de nuevo</a>";
}
?>
