<?php
namespace Controllers;

use Models\User;
use Helpers\Validator;
use Helpers\JWTHelper;

class AuthController {

    private $db;
    private User $user;

    public function __construct($db) {
        $this->db = $db;
        $this->user = new User($db);
    }

    /**
     * Register endpoint - /api/register
     *
     * @param $data
     * @return string[]
     */
    public function register($data): array
    {
        // Check for empty inputs
        if (Validator::isEmpty([$data['name'], $data['email'], $data['password']])) {

            http_response_code(400);
            return ['message' => 'Incomplete data'];
        }

        // Check email format
        if (!Validator::validateEmail($data['email'])) {

            http_response_code(400);
            return ['message' => 'Invalid email format'];
        }

        // Set user properties
        $this->user->name = Validator::sanitize($data['name']);
        $this->user->email = Validator::sanitize($data['email']);
        $this->user->password = password_hash($data['password'], PASSWORD_BCRYPT);

        // Check if email already exists
        if ($this->user->emailExists()) {

            http_response_code(409);
            return ['message' => 'Email already exists'];
        }

        // Create user
        if ($this->user->create()) {
            http_response_code(201);
            return ['message' => 'User registered successfully'];
        }
        else {
            http_response_code(500);
            return ['message' => 'Unable to register user'];
        }
    }

    /**
     * Login endpoint - /api/login
     *
     * @param $data
     * @return array|string[]
     */
    public function login($data): array
    {
        // Check for empty inputs
        if (Validator::isEmpty([$data['email'], $data['password']])) {

            http_response_code(400);
            return ['message' => 'Incomplete data'];
        }
        // Check email format
        if (!Validator::validateEmail($data['email'])) {

            http_response_code(400);
            return ['message' => 'Invalid email format'];
        }

        // Get user data by email
        $this->user->email = Validator::sanitize($data['email']);
        $userData = $this->user->getUserByEmail();

        if ($userData && password_verify($data['password'], $userData['password'])) {

            // Generate JWT token
            $token = JWTHelper::generateToken($userData['id'], $userData['email']);
            http_response_code(200);

            return ['message' => 'Login successful', 'token' => $token];
        }
        else {
            http_response_code(401);
            return ['message' => 'Invalid credentials'];
        }
    }
}
?>
