<?php


function is_input_empty($nombre){
    if(empty($nombre)){
        return true;
    } else {
        return false;
    }
}

function is_materia_registered(PDO $pdo, $nombre){
    if(get_materia_by_nom($pdo, $nombre)){
        return true;
    } else {
        return false;
    }
}