<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstname = $_POST['firstname'];
    $lastname  = $_POST['lastname'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $role      = $_POST['role'];

    // hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {

        $sql = "
            INSERT INTO users (firstname, lastname, email, password, role, created_at)
            VALUES (:firstname, :lastname, :email, :password, :role, NOW())
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname'  => $lastname,
            ':email'     => $email,
            ':password'  => $hashedPassword,
            ':role'      => $role
        ]);

        $_SESSION['message'] = "User created successfully!";
        $_SESSION['msg_class'] = "success";

        header("Location: Users.html");
        exit;

    } catch (PDOException $e) {

        if ($e->errorInfo[1] == 1062) {
            $_SESSION['message'] = "Email already exists!";
        } else {
            $_SESSION['message'] = "Database error: " . $e->getMessage();
        }

        $_SESSION['msg_class'] = "error";
        header("Location: Users.html");
        exit;
    }
}
?>
