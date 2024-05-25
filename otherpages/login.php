<?php
include("conexion.php");
$conexion = connection();

session_start();

$nomUser =  $_POST["username"]; 
$password = $_POST["password"];
$date = date("Y-m-d");

if (isset($_POST["login"])) {
    // Handle Login

    $sql = "SELECT * FROM `admin_users` WHERE `username` = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $nomUser);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($password == $row["password"]) {
                header("Location: ./adminpage.php");
                exit();
            } else {
                echo "<div class='error-message'>Contraseña invalida</div>";
            }
        } else {
            echo "<div class='error-message'>Usuario no entrontado</div>";

        }
    } else {
        echo "Error: " . mysqli_error($conexion); // Error handling for query execution
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);

} else {
    // No button was clicked
    $message = "No action specified!";
}

include "login.html";
?>

<style>
.error-message {
    color: #ffffff; /* Color del texto */
    background-color: #ff4d4d; /* Color de fondo */
    padding: 10px; /* Espacio interno */
    font-family: Arial, sans-serif; /* Fuente */
    font-size: 26px; /* Tamaño de fuente */
    text-align: center; /* Alineación de texto */
}
</style>