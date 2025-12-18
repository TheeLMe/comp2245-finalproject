<?php
require_once "config.php"; // handles DB + safe session_start()

header('Content-Type: application/json'); // always return JSON

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $email = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";

        if ($email === "" || $password === "") {
            $response["message"] = "Please enter both email and password.";
        } else {
            $stmt = $pdo->prepare("SELECT id, firstname, lastname, password, role 
                                   FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(["email" => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password"])) {
                $_SESSION["user_id"]   = $user["id"];
                $_SESSION["user_name"] = $user["firstname"] . " " . $user["lastname"];
                $_SESSION["user_role"] = $user["role"];

                $response["success"] = true;
                $response["message"] = "Login successful.";
            } else {
                $response["message"] = "Invalid email or password.";
            }
        }
    } catch (Exception $e) {
        $response["message"] = "An unexpected error occurred. Please try again later.";
        // Optionally log $e->getMessage() to a file for debugging
    }
}

echo json_encode($response);
