<?php
// Start the session to access session variables
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the admin login page after logout
header('Location: admin_login.php');
exit;
?>
