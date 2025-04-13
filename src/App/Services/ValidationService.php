<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Exceptions\ValidationException;
use Framework\Rules\{RequiredRule,};
use Framework\Rules\{DateRule, EmailRule, InRule, MatchesRule, MaxRule, MinRule, NumericRule, UrlRule};
use Framework\Validator;

class ValidationService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();

        $this->validator->addRule('required', new RequiredRule());
        $this->validator->addRule('email', new EmailRule());
        $this->validator->addRule('url', new UrlRule());
        $this->validator->addRule('numeric', new NumericRule());
        $this->validator->addRule('matches', new MatchesRule());
        $this->validator->addRule('in', new InRule());
        $this->validator->addRule('min', new MinRule());
        $this->validator->addRule('max', new MaxRule());
        $this->validator->addRule('date', new DateRule());
    }

    public function validateRegister(array $formData): void
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['required', 'numeric', 'min:18'],
            'country' => ['required', 'in:USA,Canada,Mexico'],
            'socialMediaURL' => ['required', 'url'],
            'password' => ['required', 'min:8'],
            'confirmPassword' => ['required', 'matches:password'],
            'tos' => ['required']
        ]);
    }

    public function validateLogin(array $formData): void
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    }


    public function validateTransaction(array $formData): void
    {
        $this->validator->validate($formData, [
            'description' => ['required', 'max:255'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date:Y-m-d'],
        ]);
    }

    public function validateFile(array $file, array $allowedTypes, int $size = 2 * 1024 * 1024): void
    {
        // Validate the file upload
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException([
                'receipt' => ['Failed to upload file']
            ]);
        }

        // Validate the file size
        if ($file['size'] > $size) {
            throw new ValidationException([
                'receipt' => ['File upload is too large']
            ]);
        }


        // Validate the file type
        $clientMimeType = $file['type'];

        if (!in_array($clientMimeType, $allowedTypes)) {
            throw new ValidationException([
                'receipt' => ['Invalid file type']
            ]);
        }
    }
}
