<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare("SELECT id, firstname, lastname, password, role 
                           FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(["email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"]   = $user["id"];
        $_SESSION["user_name"] = $user["firstname"] . " " . $user["lastname"];
        $_SESSION["user_role"] = $user["role"];
        header("Location: dashboard.php"); 
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>