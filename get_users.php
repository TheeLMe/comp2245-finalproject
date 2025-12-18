<?php
 
require_once 'config.php'; // $pdo defined here

try{
    $stmt = $pdo->query("SELECT id, firstname, lastname FROM users");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<label for="assigned_to">Assigned To</label>';
    echo '<br>';
    echo '<select id="assigned_to" name="assigned_to" required> ';
        echo '<option value="" disabled selected>Select Contact</option>';
        foreach($contacts as $contact) {
            $full_name = htmlspecialchars($contact['firstname'] . ' ' . $contact['lastname']);
            echo '<option value="' . $contact['id'] . '">' . $full_name . '</option>';
    }
    echo '</select>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $contacts = [];
}
?>