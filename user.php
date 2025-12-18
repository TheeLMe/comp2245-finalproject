<?php
session_start();
$host = 'localhost';
$dbname = 'dolphin_crm';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = $conn -> query("SELECT * FROM users WHERE id = $_SESSION['user_id']");
    $currentUser = $statement -> fetch(PDO::FETCH_ASSOC);
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
    if ($currentUser['role'] == 'Admin') {
      foreach ($users as $row) {
          echo "<tr>
                  <td>" . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "</td>
                  <td>" . htmlspecialchars($row['email']) . "</td>
                  <td>" . htmlspecialchars($row['role']) . "</td>
                  <td>" . htmlspecialchars($row['created_at']) . "</td>
                </tr>";
      }

    echo "</tbody></table>";
    } else {
      echo "<tr>
                  <td>" . htmlspecialchars($currentUser['firstname'] . ' ' . $currentUser['lastname']) . "</td>
                  <td>" . htmlspecialchars($currentUser['email']) . "</td>
                  <td>" . htmlspecialchars($currentUser['role']) . "</td>
                  <td>" . htmlspecialchars($currentUser['created_at']) . "</td>
                </tr>";
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
