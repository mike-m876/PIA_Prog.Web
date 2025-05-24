<?php


if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_strict_mode',1);

    session_set_cookie_params([
        'lifetime' => 1800,
        'domain' => 'localhost',
        'path' => '/',
        'secure' => true,
        'httponly' => true
    ]);
    session_start();
}

if(isset($_SESSION["user_id"])) {
    if(!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id_loggedin();
    } else {
        $interval = 60 * 90;
        if(time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id_loggedin();
        }
    }
} else {
    if(!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id();
    } else {
        $interval = 60 * 90;
        if(time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id();
        }
    }
}

function regenerate_session_id_loggedin() {
    session_regenerate_id(true);

    $user_id = $_SESSION["user_id"];

    $new_session_id = session_create_id();
    $session_id = $new_session_id . "_" . $user_id;
    session_id($session_id);

    $_SESSION["last_regeneration"] = time();
}   

function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}   

function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function require_login(): void {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

function require_role(int $required_role): void {
    if (!isset($_SESSION["user_id"]) || !isset($_SESSION["id_rol"])) {
        header("Location: login.php");
        exit();
    }

    if ($_SESSION["id_rol"] !== $required_role) {
        header("Location: login.php");
        exit();
    }
}