<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'boutique');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Arreglo de usuarios y contraseñas a insertar
$usuarios = [
    'nikte' => 'PUDINESDEFRESA',
    'josueito' => 'PANESDEPUDIN'
];

foreach ($usuarios as $username => $password) {
    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO usuarios (username, password, role) VALUES ('$username', '$hashed_password', 'admin')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario $username creado correctamente.<br>";
    } else {
        echo "Error al crear el usuario $username: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
