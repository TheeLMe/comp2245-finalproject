<?php
require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}

// Validate input
$contactId = $_POST["contact_id"] ?? null;
$comment   = trim($_POST["comment"] ?? "");

if (!$contactId || !ctype_digit($contactId) || $comment === "") {
    http_response_code(400);
    die("Invalid input.");
}

// Insert note
$stmt = $pdo->prepare("INSERT INTO notes (contact_id, comment, created_by, created_at) 
                       VALUES (:contact_id, :comment, :created_by, NOW())");
$stmt->execute([
    "contact_id" => $contactId,
    "comment"    => $comment,
    "created_by" => $_SESSION["user_id"]
]);

// Redirect back to contact details
header("Location: contact.php?id=" . urlencode($contactId));
exit;
