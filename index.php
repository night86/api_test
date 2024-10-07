<?php
require 'vendor/autoload.php';

use Config\Database;
use Controllers\AuthController;

// Enable CORS if needed
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Get the request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Remove query string from URI
$uri = strtok($uri, '?');

// Instantiate database and controller
$database = new Database();
$db = $database->getConnection();
$authController = new AuthController($db);

// Route the request
if ($method == 'POST') {

    $data = $_POST;

    switch ($uri) {
        case '/api/register':
            $response = $authController->register($data);
            echo json_encode($response);
            break;
        case '/api/login':
            $response = $authController->login($data);
            echo json_encode($response);
            break;
        default:
            http_response_code(404);
            echo json_encode(['message' => 'Not found']);
            break;
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Not allowed']);
}
?>
