<?php

declare(strict_types=1);

namespace App\Services;


use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(
        private Database $db
    ) {
    }

    /**
     * Check if the email is already taken
     *
     * @param array $data
     * @throws ValidationException
     */
    public function isEmailTaken(array $data): void
    {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $count = $this->db->query($query, $data)->count();

        if ($count > 0) {
            throw new ValidationException(
                [array_key_first($data) => ["this " . array_key_first($data) . " is already taken"]]
            );
        }
    }

    public function register(array $formData)
    {
        $query = "INSERT INTO users (email, password, age, country, social_media_url) VALUES (:email, :password, :age, :country, :social_media_url)";

        try {
            $this->db->query($query, [
                'email' => $formData['email'],
                'password' => password_hash($formData['password'], PASSWORD_BCRYPT),
                'age' => $formData['age'],
                'country' => $formData['country'],
                'social_media_url' => $formData['socialMediaURL']
            ]);

            session_regenerate_id(true);
            $_SESSION['user'] = $this->db->lastInsertId();
        } catch (\PDOException $e) {
            throw new ValidationException(["FormErrors" => ["Error: " . $e->getMessage()]]);
        }
    }

    public function login(array $formData): void
    {
        $query = "SELECT id, email, password FROM users WHERE email = :email";
        $user = $this->db->query($query, ['email' => $formData['email']])->fetch();

        if (!$user || !password_verify($formData['password'], $user['password'])) {
            throw new ValidationException(["FormErrors" => ["Invalid email or password"]]);
        }
        session_regenerate_id(true);
        $_SESSION['user'] = $user['id'];
    }

    public function logout(): void
    {
        session_destroy();

        $params = session_get_cookie_params();
        setcookie(
            'PHPSESSID',
            '',
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly'],
        );
    }

}
