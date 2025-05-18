<?php

declare(strict_types=1);

function check_login_errors() {
    if(isset($_SESSION["errors_login"])){
        $errors = $_SESSION["errors_login"];
        unset($_SESSION["errors_login"]); ?>
        
        <?php foreach($errors as $error): ?>
            <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endforeach; ?>
        
    <?php }
}