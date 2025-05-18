<?php

function is_input_empty(int $matricula, int $id_estado, int $activo): bool {
    return empty($matricula) || empty($id_estado) 
    || empty($activo);
}
