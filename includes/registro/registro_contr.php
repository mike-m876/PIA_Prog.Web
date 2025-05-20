<?php

declare(strict_types= 1);

function is_input_empty(string $curp, string $nombres, 
string $apellido_pat, string $apellido_mat, string $telefono, 
string $email, string $password, int $id_rol) 
{
    if(empty($id_rol) || empty($nombres) || empty($apellido_pat) 
    || empty($apellido_mat) || empty($telefono) || empty($curp) 
    || empty($email) || empty($password)) {
        return true;
    } else  {
        return false;
    }
}

function is_email_invalid(string $email) 
{
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else  {
        return false;
    }
}

function is_curp_registered (object $pdo, string $curp)
{
    if(get_curp($pdo, $curp)) {
        return true;
    } else {
        return false;
    }
}
function is_curp_valid($curp){
    if (!preg_match('/^[A-Z]{4}\d{6}[HM][A-Z]{2}[A-Z]{3}[A-Z\d]{2}$/', strtoupper($curp))) {
        return true;
    }
    else{
        return false;
    }
}


function create_user(
    object $pdo, string $curp, string $nombres, 
    string $apellido_pat, string $apellido_mat, string $telefono, 
    string $email, string $password, int $id_rol) {
    
    set_user(
        $pdo, $curp, $nombres, $apellido_pat, $apellido_mat,
        $telefono, $email, $password, $id_rol);
}