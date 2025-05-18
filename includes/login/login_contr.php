<?php

function is_input_empty($matricula, $psswd, $id_rol) {
    if(empty($matricula) || empty($psswd) || empty($id_rol)) {
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
