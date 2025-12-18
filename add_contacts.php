<?php
require_once 'config.php'; // $pdo defined here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title     = trim($_POST['title']);
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $email      = trim($_POST['email']);
    $telephone  = trim($_POST['telephone']);
    $company    = trim($_POST['comp']);
    $type       = trim($_POST['type']);
    $assignedTo = trim($_POST['assigned_to']);
    $createdBy = $_POST[$_SESSION['user_id']];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    $firstname = htmlspecialchars($firstname);
    $lastname  = htmlspecialchars($lastname);
    $company    = htmlspecialchars($company);
    $telephone = preg_replace('/\D/', '', $telephone);
    try {
        $stmt = $pdo->prepare("
            INSERT INTO contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([$title, $firstname, $lastname, $email, $telephone, $company, $type, $assignedTo, $createdBy]);
        echo "<script>alert('New contact added successfully');
            window.location.href = 'contact.html';
        </script>";
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
