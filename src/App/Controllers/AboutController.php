<?php

namespace App\Controllers;

class AboutController extends Controller
{
    public function index(): void
    {
        echo $this->templateEngine->render('about.php');
    }

}