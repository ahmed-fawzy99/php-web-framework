<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Services\ValidationService;
use Framework\TemplateEngine;

class AuthController extends Controller
{
    public function __construct(
        protected TemplateEngine $templateEngine,
        private ValidationService $validatorService,
        private UserService $userService,
    ) {
        parent::__construct($templateEngine);
    }

    public function registerPage(): void
    {
        echo $this->templateEngine->render('register.php');
    }

    public function loginPage(): void
    {
        echo $this->templateEngine->render('login.php');
    }

    public function register(): void
    {
        $this->validatorService->validateRegister($_POST);

        $this->userService->isEmailTaken([
            'email' => $_POST['email']
        ]);

        $this->userService->register($_POST);

        redirect('/');
    }

    public function login(): void
    {
        $this->validatorService->validateLogin($_POST);

        $this->userService->login($_POST);

        redirect('/');
    }

    public function logout(): void
    {
        $this->userService->logout();
        redirect('/login');
    }


}