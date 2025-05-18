<?php
session_start();

function mostrar_mensaje() {
    if (isset($_SESSION['mensaje'])) {
        $tipo = $_SESSION['tipo'] ?? 'success';
        echo "<div class='alert alert-$tipo alert-dismissible fade show' role='alert'>
                {$_SESSION['mensaje']}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
    }
}
