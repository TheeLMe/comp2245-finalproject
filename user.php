<?php

$host = 'localhost';
$dbname = 'dolphin_crm';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border='1' cellpadding='8' cellspacing='0'>
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
              </tr>
            </thead>
            <tbody>";

    foreach ($users as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['role']) . "</td>
                <td>" . htmlspecialchars($row['created_at']) . "</td>
              </tr>";
    }

    echo "</tbody></table>";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
