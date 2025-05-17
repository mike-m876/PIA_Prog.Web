<?php

declare(strict_types=1);

function check_login_errors() {
    if(isset($_SESSION["errors_login"])){
        $errors = $_SESSION["errors_login"];

        ob_start();
        echo "<br>";
        foreach($errors as $error): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php $error ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endforeach;
    }
}