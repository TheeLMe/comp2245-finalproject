<?php
require_once 'config.php'; // $pdo defined here

try{
    $stmt = $pdo->query("SELECT firstname, lastname FROM users");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<label for="assigned_to">Assigned To</label>';
    echo '<br>';
    echo '<select id="assigned_to" name="assigned_to" required> ';
    echo '<option value="" disabled selected>Select Contact</option>';
        foreach($contacts as $contact) {
            $full_name = htmlspecialchars($contact['firstname'] . ' ' . $contact['lastname']);
            echo '<option value="' . $full_name . '">' . $full_name . '</option>';
    }
    echo '</select>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $contacts = [];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $email      = trim($_POST['email']);
    $telephone  = trim($_POST['telephone']);
    $company    = trim($_POST['comp']);
    $type       = trim($_POST['type']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    $firstname = htmlspecialchars($firstname);
    $lastname  = htmlspecialchars($lastname);
    $company    = htmlspecialchars($company);
    $telephone = preg_replace('/\D/', '', $telephone);
    try {
        $stmt = $pdo->prepare("
            INSERT INTO contacts (firstname, lastname, email, telephone, company, type)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([$firstname, $lastname, $email, $telephone, $company, $type]);

        header("Location: contact.html");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
