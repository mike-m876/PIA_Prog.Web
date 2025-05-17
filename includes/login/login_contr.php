<?php

function is_input_empty($matricula, $password, $id_rol) {
    if(empty($matricula) || empty($password) || empty($id_rol)) {
        return true;
    } else {
        return false;
    }
}
 
function is_matricula_wrong(bool|array $user) {
    if (!$user) {
        return true;
    } else {
        return false;
    }
} 

function is_psswd_wrong(string $psswd, string $hashed_password) {
    if (password_verify($psswd, $hashed_password)) {
        return false;
    } else {
        return true;
    }
} 

function is_rol_wrong( $user, $id_rol){
    if ($user['id_rol'] != $id_rol) {
        return true;
    } else {
        return false;
    }
}