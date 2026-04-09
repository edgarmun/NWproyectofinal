<?php

namespace Controllers\usuario;

use Controllers\PublicController;

class logout extends PublicController {

    public function run(): void {

        session_unset();
        session_destroy();

        header("Location: index.php?page=usuario.login");
        exit;
    }
}