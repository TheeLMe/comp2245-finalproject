<?php
session_start();
require_once "config.php";

header("Content-Type: application/json");

$filter = $_GET["filter"] ?? "all";
$userId = $_SESSION["user_id"] ?? null;

$sql = "SELECT id, title, firstname, lastname, email, company, type FROM contacts";
$params = [];

if ($filter === "sales") {
    $sql .= " WHERE type = 'sales'";
} elseif ($filter === "support") {
    $sql .= " WHERE type = 'support'";
} elseif ($filter === "mine" && $userId) {
    $sql .= " WHERE assigned_to = :uid";
    $params["uid"] = $userId;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($contacts);
?>
