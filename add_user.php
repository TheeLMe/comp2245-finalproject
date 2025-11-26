<?php
session_start();
require_once 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Successful registration! You can now log in.";
        $_SESSION['msg_class'] = "success";
        header("Location: register.html"); // redirect back to show message
        exit;
    } else {
        if ($conn->errno === 1062) {
            $_SESSION['message'] = "Email already exists!";
        } else {
            $_SESSION['message'] = "Error: " . $conn->error;
        }
        $_SESSION['msg_class'] = "error";
        header("Location: register.html");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
