<?php

if (empty($_POST["name"])) {
    die("Nombre requerido");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL  )) {
    die("Email válido requerido");
}

if (strlen($_POST["password"]) < 12) {
    die("Contraseña demasiado corta");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT); 

print_r($_POST);
var_dump($password_hash);

$mysqli = require __DIR__ ."/db_registro.php";

$sql = "INSERT INTO user (name, )"

?>