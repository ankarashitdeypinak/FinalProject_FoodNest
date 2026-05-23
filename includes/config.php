<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$db   = 'foodnest_db';
$user = 'root'; 
$pass = '';     

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


function logActivity($dbInstance, $userId, $action) {
    
    if (!$dbInstance) {
        global $pdo;
        $dbInstance = $pdo;
    }
    
    if ($dbInstance) {
        try {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            $stmt = $dbInstance->prepare("INSERT INTO activity_log (user_id, action, ip_address) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $action, $ip]);
        } catch (PDOException $e) {
            

        }
    }
}

function sendEmail($to, $subject, $message) {
    $headers = "From: noreply@foodnest.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    return @mail($to, $subject, $message, $headers);
}
?>