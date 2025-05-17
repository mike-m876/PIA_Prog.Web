<?php

function is_input_empty($matricula, $password, $id_rol) {
    if(empty($matricula) || empty($password) || empty($id_rol)) {
        return true;
    } else {
        return false;
    }
}
 
function is_matricula_wrong(bool|array $result) {
    if (!$result) {
        return true;
    } else {
        return false;
    }
} 

function is_psswd_wrong(string $password, string $hashed_password) {
    if (password_verify($password, $hashed_password)) {
        return false;
    } else {
        return true;
    }
} 