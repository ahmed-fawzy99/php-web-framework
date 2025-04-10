<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index(): void
    {
        echo $this->templateEngine->render('index.php');
    }


}