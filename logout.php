<?php
require_once 'includes/config.php';
if (isset($_SESSION['user_id'])) {
    logActivity($pdo, $_SESSION['user_id'], "Logged out safely");
}
session_unset();
session_destroy();
header("Location: index.php");
exit;
?>