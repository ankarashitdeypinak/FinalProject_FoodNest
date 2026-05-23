<?php
require_once '../includes/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$feedbackMessage = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $bio = trim($_POST['bio']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    $stmt = $pdo->prepare("UPDATE profiles SET bio = ?, phone = ?, address = ? WHERE user_id = ?");
    if ($stmt->execute([$bio, $phone, $address, $userId])) {
        logActivity($pdo, $userId, "Updated profile fields info metadata metrics");
        $feedbackMessage = "Profile metrics saved cleanly successfully!";
    }
}

$stmt = $pdo->prepare("SELECT users.name, users.email, profiles.phone, profiles.address, profiles.bio FROM users JOIN profiles ON users.id = profiles.user_id WHERE users.id = ?");
$stmt->execute([$userId]);
$userProfile = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>FoodNest - Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <?php include '../includes/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">
        <aside class="space-y-2 bg-white p-6 rounded-2xl border border-gray-100 h-fit">
            <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium">
                <span>📊</span> <span>Dashboard</span>
            </a>
            <a href="profile.php" class="flex items-center space-x-3 px-4 py-3 bg-green-50 text-green-700 rounded-xl font-semibold text-sm">
                <span>👤</span> <span>My Profile</span>
            </a>
            <a href="activity_log.php" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium">
                <span>📜</span> <span>Activity Log</span>
            </a>
            <hr class="border-gray-100 my-2">
            <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl text-sm font-medium">
                <span>🚪</span> <span>Logout</span>
            </a>
        </aside>

        <main class="lg:col-span-3 space-y-6">
            <header>
                <h2 class="text-2xl font-bold text-gray-900">Account Profile Management</h2>
                <p class="text-xs text-gray-400">Update your CRUD bio details data and user information properties here.</p>
            </header>

            <?php if(!empty($feedbackMessage)): ?>
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold rounded-xl">
                    <?php echo $feedbackMessage; ?>
                </div>
            <?php endif; ?>

            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                <form action="profile.php" method="POST" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Full Name (Read Only)</label>
                            <input type="text" disabled value="<?php echo htmlspecialchars($userProfile['name']); ?>" class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Email Address (Read Only)</label>
                            <input type="email" disabled value="<?php echo htmlspecialchars($userProfile['email']); ?>" class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500 cursor-not-allowed">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Phone Number</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($userProfile['phone'] ?? ''); ?>" placeholder="Enter phone number" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Delivery Address</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($userProfile['address'] ?? ''); ?>" placeholder="Enter delivery address" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Bio Description</label>
                        <textarea name="bio" rows="4" placeholder="Tell us about yourself..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700"><?php echo htmlspecialchars($userProfile['bio'] ?? ''); ?></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit" name="update_profile" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-lg shadow-green-600/20 text-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>