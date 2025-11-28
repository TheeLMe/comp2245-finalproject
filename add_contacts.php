<?php
require_once 'config.php'; // $pdo defined here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstname'];
    $last_name  = $_POST['lastname'];
    $email      = $_POST['email'];
    $telephone  = $_POST['telephone'];
    $company    = $_POST['comp'];
    $type       = $_POST['type'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO contacts (firstname, lastname, email, telephone, company, type)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([$first_name, $last_name, $email, $telephone, $company, $type]);

        header("Location: contacts.html");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
