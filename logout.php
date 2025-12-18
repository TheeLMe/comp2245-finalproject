<?php
require_once "config.php"; // ensures session_start() is handled safely

// Clear all session variables
$_SESSION = [];

// If sessions use cookies, clear the cookie too
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally destroy the session
session_destroy();

// Redirect back to login or index page
header("Location: index.html");
exit;
