<?php
require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}

$contactId  = $_POST["contact_id"] ?? null;
$targetType = $_POST["target_type"] ?? null;

if (!$contactId || !ctype_digit($contactId)) {
    http_response_code(400);
    die("Invalid contact ID.");
}

if (!$targetType) {
    http_response_code(400);
    die("Invalid target type.");
}

// Update contact type
$stmt = $pdo->prepare("UPDATE contacts SET type = :type, updated_at = NOW() WHERE id = :id");
$stmt->execute([
    "type" => $targetType,
    "id"   => $contactId
]);

// Redirect back to contact details
header("Location: contact.php?id=" . urlencode($contactId));
exit;
