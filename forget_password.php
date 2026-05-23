<?php 
require_once 'includes/config.php';

$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['forgot_password'])) {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $message = "Please enter your email address.";
        $messageType = "error";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $token = bin2hex(random_bytes(20));
            
            $stmt = $pdo->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
            $stmt->execute([$token, $email]);
            
            $resetLink = "http://localhost/FoodNest/reset_password.php?token=$token";
            $msg = "<h2>Password Reset Request</h2><p>Click the link below to reset your password:</p><a href='$resetLink'>Reset Password</a>";
            
            sendEmail($email, "Reset Your FoodNest Password", $msg);
        }
        $message = "If that email exists, a reset link has been dispatched successfully.";
        $messageType = "success";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodNest - Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-3xl shadow-xl max-w-md w-full border border-gray-100">
        <div class="text-center mb-6">
            <span class="text-2xl font-bold text-green-600">🥗 FoodNest</span>
            <h3 class="text-xl font-bold text-gray-800 mt-2">Recover Password</h3>
            <p class="text-xs text-gray-400 mt-1">We'll email you a link to reset your password.</p>
        </div>

        <?php if(!empty($message)): ?>
            <div class="p-3 mb-4 rounded-xl text-sm <?php echo $messageType == 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="forgot_password.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Email Address</label>
                <input type="email" name="email" required placeholder="Enter your registered email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700">
            </div>
            <button type="submit" name="forgot_password" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-green-600/20 text-sm">Send Reset Link</button>
        </form>
        <p class="text-center text-xs text-gray-500 mt-6"><a href="login.php" class="text-green-600 font-bold hover:underline">Back to Login</a></p>
    </div>
</body>
</html>