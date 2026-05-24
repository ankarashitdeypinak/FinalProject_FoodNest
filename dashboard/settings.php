<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$baseUrl = "http://localhost/foodnest";
$userId = $_SESSION['user_id'];
$successMessage = "";
$errorMessage = "";


if (isset($pdo)) {
    $stmt = $pdo->prepare("SELECT name, email, phone FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);

        if (!empty($name) && !empty($email)) {
            $updateStmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?");
            if ($updateStmt->execute([$name, $email, $phone, $userId])) {
                $successMessage = "Profile updated successfully!";
    
                $user['name'] = $name;
                $user['email'] = $email;
                $user['phone'] = $phone;
            } else {
                $errorMessage = "Something went wrong. Please try again.";
            }
        } else {
            $errorMessage = "Name and Email fields are required.";
        }
    }

    if (isset($_POST['change_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if (!empty($currentPassword) && !empty($newPassword) && !empty($confirmPassword)) {
            
            $passStmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $passStmt->execute([$userId]);
            $userPass = $passStmt->fetch(PDO::FETCH_ASSOC);

            if ($userPass && password_verify($currentPassword, $userPass['password'])) {
                if ($newPassword === $confirmPassword) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $upPassStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $upPassStmt->execute([$hashedPassword, $userId]);
                    $successMessage = "Password changed successfully!";
                } else {
                    $errorMessage = "New passwords do not match.";
                }
            } else {
                $errorMessage = "Incorrect current password.";
            }
        } else {
            $errorMessage = "All password fields are required.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - FoodNest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-[#FAFAFA] text-gray-800 font-sans overflow-x-hidden transition-colors duration-200 dark:bg-gray-950 dark:text-gray-100">

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="max-w-4xl mx-auto px-6 py-10">
    
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Account Settings</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manage your profile details, security preferences, and account settings.</p>
    </div>

    <?php if (!empty($successMessage)): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm flex items-center gap-2 dark:bg-green-950/30 dark:border-green-900 dark:text-green-400">
            <span>✅</span> <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm flex items-center gap-2 dark:bg-red-950/30 dark:border-red-900 dark:text-red-400">
            <span>⚠️</span> <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <div class="grid gap-8">
        
        <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm dark:bg-gray-900 dark:border-gray-800">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span>👤</span> Profile Information
            </h3>
            <form action="" method="POST" class="space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Full Name</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-green-500 transition dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Phone Number</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-green-500 transition dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:border-green-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-green-500 transition dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:border-green-500">
                </div>
                <div class="pt-2">
                    <button type="submit" name="update_profile" class="bg-[#2E7D32] hover:bg-[#25672A] text-white px-6 py-3 rounded-xl font-semibold text-sm shadow-md transition dark:bg-green-600 dark:hover:bg-green-700">
                        Save Profile Changes
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm dark:bg-gray-900 dark:border-gray-800">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span>🔒</span> Change Password
            </h3>
            <form action="" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Current Password</label>
                    <input type="password" name="current_password" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-green-500 transition dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:border-green-500">
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">New Password</label>
                        <input type="password" name="new_password" required
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-green-500 transition dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Confirm New Password</label>
                        <input type="password" name="confirm_password" required
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-green-500 transition dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:focus:border-green-500">
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" name="change_password" class="bg-gray-900 hover:bg-black text-white px-6 py-3 rounded-xl font-semibold text-sm shadow-md transition dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-100">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm dark:bg-gray-900 dark:border-gray-800">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span>⚙️</span> Account Preferences
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl dark:bg-gray-800/50">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Email Notifications</h4>
                        <p class="text-xs text-gray-400">Receive order status and promotional updates.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                    </label>
                </div>
                
                <hr class="border-gray-100 dark:border-gray-800">
                
                <div class="flex items-center justify-between p-2">
                    <div>
                        <h4 class="text-sm font-semibold text-red-600 dark:text-red-400">Danger Zone</h4>
                        <p class="text-xs text-gray-400">Permanently delete your account and history.</p>
                    </div>
                    <button onclick="alert('Delete request triggered securely.')" class="border border-red-200 hover:bg-red-50 text-red-600 px-4 py-2 rounded-xl text-xs font-bold transition dark:border-red-950 dark:hover:bg-red-950/30 dark:text-red-400">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>