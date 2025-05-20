<?php
include '../dbh.php';
include 'califs_gen_model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id_grupo = isset($_POST['id_grupo']) ? (int)$_POST['id_grupo'] : 0;
    $id_materia = isset($_POST['id_materia']) ? (int)$_POST['id_materia'] : 0;

    $parcial1_arr = $_POST['parcial1'] ?? [];
    $parcial2_arr = $_POST['parcial2'] ?? [];

    foreach ($parcial1_arr as $id_alumno => $p1) {
        $p2 = $parcial2_arr[$id_alumno] ?? 0;
        $p1 = floatval($p1);
        $p2 = floatval($p2);
        $prom_final = ($p1 + $p2) / 2;

        updt_califs($pdo, $id_grupo, $id_materia, (int)$id_alumno, $p1, $p2, $prom_final);
    }

    header("Location: ../../tu_pagina.php?id_grupo=$id_grupo&id_materia=$id_materia");
    exit();
} else {
    header("Location: ../../tu_pagina.php");
    exit();
}
