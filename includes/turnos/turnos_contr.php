<?php

function is_input_empty($nombre){
    if(empty($nombre)){
        return true;
    } else {
        return false;
    }
}

function is_turno_registered(PDO $pdo, $nombre){
    if(get_turno_by_nom($pdo, $nombre)){
        return true;
    } else {
        return false;
    }
}