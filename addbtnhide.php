<?php
session_start();

require_once 'config.php';

try {

    $statement = $pdo -> query("SELECT * FROM users WHERE id =" . $_SESSION['user_id']);
    $currentUser = $statement -> fetch(PDO::FETCH_ASSOC);

    if ($currentUser['role'] == 'Admin') {
        echo '<a href="register.html"><button id="AddUserBtn">+ Add User</button></a>';
    } else {
        echo ''; // No button for non-admin users
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
