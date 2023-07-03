<?php

include 'app/core/db.php';

class Model
{
    public function view(string $view, array $data = [])
    {
        require_once('app/views/' . $view . '.php');
    }

    public function redirect(string $view)
    {
        header('Location: /www/exos/t2i/' . $view);
        exit();
    }
}