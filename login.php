<?php
session_start();
require_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $pdo->prepare("SELECT id, firstname, lastname, email, password, role 
                           FROM users WHERE email = :email");
    $stmt->execute(["email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["firstname"] . " " . $user["lastname"];
        $_SESSION["user_role"] = $user["role"];


        header("Location: dashboard.php");
        exit;
    } else {
 
        $_SESSION["login_error"] = "Invalid email or password.";
        header("Location: index.html");
        exit;
    }
}
?>
