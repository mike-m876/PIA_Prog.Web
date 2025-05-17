<?php 

declare(strict_types= 1);

function check_registro_error() 
{
    if(isset($_SESSION["errors_registro"])){
        $errors = $_SESSION["errors_registro"];

        ob_start();
        echo "<br>";
        foreach ($errors as $error): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?= $error ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endforeach;
        unset($_SESSION["errors_registro"]);
        return ob_end_clean();
    }
}
