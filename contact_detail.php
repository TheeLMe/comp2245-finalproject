<?php
session_start();
require_once "config.php";

// Get contact ID
$id = $_GET["id"] ?? null;

// Fetch contact
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$id]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// If contact doesn't exist, stop
if (!$contact) {
    die("Contact not found.");
}

// Fetch assigned user
$assignedUserName = "Unassigned";
if ($contact["assigned_to"]) {
    $stmtUser = $pdo->prepare("SELECT firstname, lastname FROM users WHERE id = ?");
    $stmtUser->execute([$contact["assigned_to"]]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $assignedUserName = $user["firstname"] . " " . $user["lastname"];
    }
}

// Fetch notes
$stmtNotes = $pdo->prepare("
    SELECT notes.comment, notes.created_at, users.firstname, users.lastname
    FROM notes 
    JOIN users ON users.id = notes.created_by
    WHERE notes.contact_id = ?
    ORDER BY notes.created_at DESC
");
$stmtNotes->execute([$id]);
$notes = $stmtNotes->fetchAll(PDO::FETCH_ASSOC);

// -------------------- ACTIONS --------------------

// Assign to Me
if (isset($_POST["assign"])) {
    $stmt = $pdo->prepare("
        UPDATE contacts SET assigned_to=?, updated_at=NOW() WHERE id=?
    ");
    $stmt->execute([$_SESSION["user_id"], $id]);
    header("Location: view_contact.php?id=$id");
    exit;
}

// Update Contact Type
if (isset($_POST["type"])) {
    $stmt = $pdo->prepare("
        UPDATE contacts SET type=?, updated_at=NOW() WHERE id=?
    ");
    $stmt->execute([$_POST["type"], $id]);
    header("Location: view_contact.php?id=$id");
    exit;
}

// Add Note
if (!empty($_POST["note"])) {
    $stmt = $pdo->prepare("
        INSERT INTO notes (contact_id, comment, created_by, created_at)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->execute([$id, $_POST["note"], $_SESSION["user_id"]]);
    header("Location: view_contact.php?id=$id");
    exit;
}

// Include HTML Template
include "templates/view_contact_template.html";
