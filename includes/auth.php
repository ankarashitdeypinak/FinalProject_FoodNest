<?php

require 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (isset($_POST['register'])) {
        $name = trim($_POST['name']);
        
        
        if (empty($name) || empty($email) || empty($password)) {
            $message = "All fields are required!";
        } else {
            
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $message = "Email already registered.";
            } else {
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
            
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                if ($stmt->execute([$name, $email, $hashedPassword])) {
                    $userId = $pdo->lastInsertId();
                    
                    $pdo->prepare("INSERT INTO profiles (user_id) VALUES (?)")->execute([$userId]);

                    $token = bin2hex(random_bytes(20));
                    $verifyLink = "http://localhost/foodnest/verify.php?token=$token";
                    $msg = "Click here to verify: <a href='$verifyLink'>Verify Email</a>";
                    
                    sendEmail($email, "Verify FoodNest Account", $msg);
                    
                    $message = "Registration successful! Please check email to verify.";
                }
            }
        }
    } 
    
    elseif (isset($_POST['login'])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
    
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                logActivity($pdo, $user['id'], "Logged in");
                header("Location: profile.php");
                exit;
            
        } else {
            $message = "Invalid credentials.";
        }
    }
}
?>