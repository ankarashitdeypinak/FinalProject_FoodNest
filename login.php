<?php 
require_once 'includes/config.php'; 

$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $message = "All fields are required.";
        $messageType = "error";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                
                if (function_exists('logActivity')) {
                    logActivity($pdo, $user['id'], "User logged in successfully.");
                }

                header("Location: dashboard/dashboard.php");
                exit;
            } else {
                $message = "Invalid email or password.";
                $messageType = "error";
            }
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
            $messageType = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodNest - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden max-w-4xl w-full grid grid-cols-1 md:grid-cols-2">
        <div class="bg-green-700 p-12 flex flex-col justify-between text-white relative">
            <div>
                <span class="text-2xl font-bold flex items-center gap-1 mb-8">🥗 FoodNest</span>
                <h2 class="text-4xl font-extrabold leading-tight">Welcome Back! </h2>
                <p class="text-green-100 text-sm mt-2">Please login to your account to continue ordering delicious updates.</p>
            </div>
            <div class="mt-8 rounded-full overflow-hidden shadow-xl aspect-square border-4 border-green-600/30 max-w-[280px] mx-auto">
                <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=400&q=80" alt="Salad Bowl" class="w-full h-full object-cover">
            </div>
        </div>
        <div class="p-12 flex flex-col justify-center">
            <h3 class="text-2xl font-bold text-gray-800 text-center mb-1">Login</h3>
            <p class="text-xs text-gray-400 text-center mb-6">Enter your credentials to access your account</p>
            
            <?php if(!empty($message)): ?>
                <div class="p-3 mb-4 rounded-xl text-sm <?php echo $messageType == 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" autocomplete="off" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" id="login-email" required autocomplete="none" value="" placeholder="Enter your email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700">
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Password</label>
                        <a href="forgot_password.php" class="text-xs text-green-600 hover:underline">Forgot Password?</a>
                    </div>
                    <input type="password" name="password" id="login-password" required autocomplete="new-password" value="" placeholder="Enter your password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="rounded border-gray-300 text-green-600 focus:ring-green-500 h-4 w-4">
                    <label for="remember" class="ml-2 text-xs text-gray-500">Remember me</label>
                </div>
                <button type="submit" name="login" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl transition duration-200 shadow-lg shadow-green-600/20 text-sm">Login</button>
            </form>

            <div class="mt-6">
                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink mx-4 text-gray-400 text-xs uppercase tracking-wider">or log in with</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>
                
                <div class="grid grid-cols-2 gap-3 mt-3">
                    <button type="button" class="flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-200 rounded-xl text-xs font-medium text-gray-600 hover:bg-gray-50 transition duration-150">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v3.92h6.61c-.29 1.53-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.65-5.17 3.65-8.58z"/>
                            <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.11 0-5.74-2.11-6.68-4.96H1.21v3.15C3.18 21.88 7.31 24 12 24z"/>
                            <path fill="#FBBC05" d="M5.32 14.24A7.16 7.16 0 0 1 4.91 12c0-.79.13-1.57.38-2.31V6.54H1.21A11.94 11.94 0 0 0 0 12c0 1.92.45 3.74 1.21 5.46l4.11-3.22z"/>
                            <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.18 2.12 1.21 5.46l4.11 3.22c.94-2.85 3.57-4.93 6.68-4.93z"/>
                        </svg>
                        Google
                    </button>
                    <button type="button" class="flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-200 rounded-xl text-xs font-medium text-gray-600 hover:bg-gray-50 transition duration-150">
                        <svg class="w-4 h-4" fill="#1877F2" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </button>
                </div>
            </div>

            <p class="text-center text-xs text-gray-500 mt-6">Don't have an account? <a href="register.php" class="text-green-600 font-bold hover:underline">Register here</a></p>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                document.getElementById('login-email').value = '';
                document.getElementById('login-password').value = '';
            }, 50);
        });
    </script>
</body>
</html>