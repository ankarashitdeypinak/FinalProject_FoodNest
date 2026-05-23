<?php 
require_once 'includes/config.php'; 

$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($email) || empty($password)) {
        $message = "All fields are required.";
        $messageType = "error";
    } else {
        try {
            $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $checkEmail->execute([$email]);

            if ($checkEmail->rowCount() > 0) {
                $message = "This email is already registered.";
                $messageType = "error";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hashedPassword]);

                $userId = $pdo->lastInsertId();

                $profileStmt = $pdo->prepare("INSERT INTO profiles (user_id) VALUES (?)");
                $profileStmt->execute([$userId]);

                if (function_exists('logActivity')) {
                    logActivity($pdo, $userId, "User registered successfully.");
                }

                $_SESSION['user_id'] = $userId;

                // 🔥 Instant redirection to dashboard subdirectory folder
                header("Location: dashboard/dashboard.php");
                exit;
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
    <title>FoodNest - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden max-w-4xl w-full grid grid-cols-1 md:grid-cols-2">
        <div class="bg-green-700 p-12 flex flex-col justify-between text-white relative">
            <div>
                <span class="text-2xl font-bold flex items-center gap-1 mb-8">🥗 FoodNest</span>
                <h2 class="text-4xl font-extrabold leading-tight">Create Account </h2>
                <p class="text-green-100 text-sm mt-2">Join us today and start your delicious kitchen journey.</p>
            </div>
            <div class="mt-8 rounded-full overflow-hidden shadow-xl aspect-square border-4 border-green-600/30 max-w-[280px] mx-auto">
                <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=400&q=80" alt="Healthy Plate" class="w-full h-full object-cover">
            </div>
        </div>
        <div class="p-12 flex flex-col justify-center">
            <h3 class="text-2xl font-bold text-gray-800 text-center mb-1">Register</h3>
            <p class="text-xs text-gray-400 text-center mb-6">Create your account to get started</p>

            <?php if(!empty($message)): ?>
                <div class="p-3 mb-4 rounded-xl text-sm <?php echo $messageType == 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" autocomplete="off" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Full Name</label>
                    <input type="text" name="name" id="reg-name" required autocomplete="none" value="" placeholder="Enter your full name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" id="reg-email" required autocomplete="none" value="" placeholder="Enter your email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Password</label>
                    <input type="password" name="password" id="reg-password" required autocomplete="new-password" value="" placeholder="Create a password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="terms" id="terms" required class="rounded border-gray-300 text-green-600 focus:ring-green-500 h-4 w-4">
                    <label for="terms" class="ml-2 text-xs text-gray-500">I agree to the <a href="#" class="text-green-600 underline">Terms & Conditions</a></label>
                </div>
                <button type="submit" name="register" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl transition duration-200 shadow-lg shadow-green-600/20 text-sm">Register</button>
            </form>
            <p class="text-center text-xs text-gray-500 mt-6">Already have an account? <a href="login.php" class="text-green-600 font-bold hover:underline">Login here</a></p>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                document.getElementById('reg-name').value = '';
                document.getElementById('reg-email').value = '';
                document.getElementById('reg-password').value = '';
            }, 50);
        });
    </script>
</body>
</html>