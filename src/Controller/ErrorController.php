<?php

class ErrorController {

    public function error404(): void
    {
        require_once '../templates/errors/404.php';
    }
}
