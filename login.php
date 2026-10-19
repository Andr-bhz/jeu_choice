<?php
session_start();
header('Content-Type: application/json');
$admin_user = "admin";
$admin_pass = "motdepasse123"; 

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if ($username === $admin_user && $password === $admin_pass) {
    
    echo json_encode([
        "success" => true,
        "message" => "Connexion réussie."
    ]);
} else {

    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Nom d'utilisateur ou mot de passe incorrect."
    ]);
}
?>