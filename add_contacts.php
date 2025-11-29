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
