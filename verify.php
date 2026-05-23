<?php
require_once 'includes/config.php';

$title = "Verifying Verification Link...";
$message = "Please wait processing details.";
$status = "processing";

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    $stmt = $pdo->prepare("SELECT id, name FROM users WHERE verification_token = ? AND is_verified = 0");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $update = $pdo->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE id = ?");
        $update->execute([$user['id']]);
        logActivity($pdo, $user['id'], "Verified Account Email Activation");
        
        $title = "Email Verified Successfully!";
        $message = "Thank you, <strong>" . htmlspecialchars($user['name']) . "</strong>! Your registration is complete.";
        $status = "success";
    } else {
        $title = "Invalid Validation Route";
        $message = "This confirmation route is expired, broken, or has already been used.";
        $status = "error";
    }
} else {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>FoodNest - Verify Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-3xl shadow-xl max-w-md w-full text-center space-y-6 border border-gray-100">
        <div class="text-5xl">
            <?php echo $status === 'success' ? '✅' : '❌'; ?>
        </div>
        <h2 class="text-2xl font-bold text-gray-800"><?php echo $title; ?></h2>
        <p class="text-sm text-gray-500"><?php echo $message; ?></p>
        <div class="pt-4">
            <a href="login.php" class="inline-block bg-green-600 text-white font-bold px-6 py-3 rounded-xl shadow-md hover:bg-green-700 text-sm transition">Proceed to Login</a>
        </div>
    </div>
</body>
</html>