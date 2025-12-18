<?php
require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}

$contactId = $_POST["contact_id"] ?? null;
$assignedTo = $_POST["assigned_to"] ?? null;

if (!$contactId || !ctype_digit($contactId)) {
    http_response_code(400);
    die("Invalid contact ID.");
}

if (!$assignedTo || !ctype_digit($assignedTo)) {
    http_response_code(400);
    die("Invalid user ID.");
}

// Update assignment
$stmt = $pdo->prepare("UPDATE contacts SET assigned_to = :assigned_to, updated_at = NOW() WHERE id = :id");
$stmt->execute([
    "assigned_to" => $assignedTo,
    "id" => $contactId
]);

// Redirect back to contact details
header("Location: contact.php?id=" . urlencode($contactId));
exit;
