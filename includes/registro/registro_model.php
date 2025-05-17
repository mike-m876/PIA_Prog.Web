<?php 

//EVITAR ERRORES
declare(strict_types= 1);

//REFERENCIAS A TABLAS
function get_curp(object $pdo, string $curp) 
{
    $query = "SELECT curp FROM usuarios WHERE curp = :curp";
    $stmt = $pdo -> prepare ($query);
    $stmt ->bindParam(":curp", $curp);
    $stmt -> execute();

    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_roles(PDO $pdo): array {
    $stmt = $pdo->query("SELECT id_rol, nombre FROM roles;");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function is_valid_rol(object $pdo, int $id_rol){
    $query = "SELECT COUNT(*) FROM roles WHERE id_rol = :id_rol;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_rol', $id_rol);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

//INSERCIÓN/EDICIÓN/BORRADO DE DATOS--------------------------------------------
function set_user(object $pdo, string $curp, string $nombres, 
        string $apellido_pat, string $apellido_mat, string $telefono, 
        string $email, string $password, int $id_rol) {

    $query = "INSERT INTO usuarios 
    (curp, nombres, apellido_pat, apellido_mat, 
    telefono, email, psswd_hash, id_rol) 
    VALUES 
    (:curp, :nombres, :apellido_pat, :apellido_mat, :telefono, :email,
    :psswd_hash, :id_rol);";

    $options = [
        'cost' => 12
    ];

    $hashed_pwd = password_hash($password, PASSWORD_BCRYPT,
    $options);

    $stmt = $pdo -> prepare ($query);
    $stmt ->bindParam(':curp', $curp);
    $stmt ->bindParam(':nombres', $nombres);
    $stmt ->bindParam(':apellido_pat', $apellido_pat);
    $stmt ->bindParam(':apellido_mat', $apellido_mat);
    $stmt ->bindParam(':telefono', $telefono);
    $stmt ->bindParam(':email', $email);
    $stmt ->bindParam(':id_rol', $id_rol);
    $stmt ->bindParam(":psswd_hash", $hashed_pwd);
    $stmt -> execute();

}