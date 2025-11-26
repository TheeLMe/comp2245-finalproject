<?php
$host = 'localhost';
$dbname = 'dolphin_crm';
$username = 'AdminUser';
$pass = 'password123';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        echo "<option value= '" . htmlspecialchars($user['id']) . "'>" . htmlspecialchars($user['firstname']) . " " . htmlspecialchars($user['lastname']) . "</option>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}