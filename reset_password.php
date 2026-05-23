<?php
require_once 'includes/config.php';

$message = "";
$messageType = "";
$token_valid = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user) {
        $token_valid = true;
    } else {
        $message = "Invalid or expired recovery token.";
        $messageType = "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_password'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($password) || empty($confirm_password)) {
        $message = "All password fields are required.";
        $messageType = "error";
        $token_valid = true;
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        $messageType = "error";
        $token_valid = true;
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE id = ?");
            if ($update->execute([$hashedPassword, $user['id']])) {
                logActivity($pdo, $user['id'], "Password updated via recovery reset token sequence");
                $message = "Password reset successful! You can now log in.";
                $messageType = "success";
                $token_valid = false;
            }
        } else {
            $message = "An error occurred. Please try again.";
            $messageType = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodNest - Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-3xl shadow-xl max-w-md w-full border border-gray-100">
        <div class="text-center mb-6">
            <span class="text-2xl font-bold text-green-600">🥗 FoodNest</span>
            <h3 class="text-xl font-bold text-gray-800 mt-2">Create New Password</h3>
        </div>

        <?php if(!empty($message)): ?>
            <div class="p-3 mb-4 rounded-xl text-sm <?php echo $messageType == 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if($token_valid): ?>
            <form action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" method="POST" class="space-y-4">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">New Password</label>
                    <input type="password" name="password" required placeholder="Minimally 8 characters" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Confirm New Password</label>
                    <input type="password" name="confirm_password" required placeholder="Repeat new password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700">
                </div>
                <button type="submit" name="reset_password" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-green-600/20 text-sm">Update Password</button>
            </form>
        <?php else: ?>
            <div class="text-center pt-2">
                <a href="login.php" class="text-sm font-bold text-green-600 hover:underline">Proceed to Sign In</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>