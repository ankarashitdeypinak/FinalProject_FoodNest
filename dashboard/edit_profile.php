<?php
require_once '../includes/config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $bio = trim($_POST['bio']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    try {
        $stmt = $pdo->prepare("UPDATE profiles SET bio = ?, phone = ?, address = ? WHERE user_id = ?");
        $stmt->execute([$bio, $phone, $address, $userId]);
        
        logActivity($pdo, $userId, "Updated profile contact information");
        
        $message = "Profile updated successfully!";
        $messageType = "success";
    } catch (PDOException $e) {
        $message = "Error updating profile: " . $e->getMessage();
        $messageType = "error";
    }
}

$stmt = $pdo->prepare("
    SELECT u.name, u.email, p.phone, p.address, p.bio, p.avatar 
    FROM users u 
    LEFT JOIN profiles p ON u.id = p.user_id 
    WHERE u.id = ?
");
$stmt->execute([$userId]);
$userProfile = $stmt->fetch(PDO::FETCH_ASSOC);

$avatarUrl = !empty($userProfile['avatar']) ? $userProfile['avatar'] : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&q=80';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodNest - Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <?php include '../includes/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <aside class="space-y-2 bg-white p-6 rounded-2xl border border-gray-100 h-fit shadow-sm">
            <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                <span>📊</span> <span>Dashboard</span>
            </a>
            <a href="profile.php" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                <span>👤</span> <span>My Profile</span>
            </a>
            <a href="edit_profile.php" class="flex items-center space-x-3 px-4 py-3 bg-green-50 text-green-700 rounded-xl font-semibold text-sm transition">
                <span>⚙️</span> <span>Edit Profile</span>
            </a>
            <a href="activity_log.php" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                <span>📜</span> <span>Activity Log</span>
            </a>
            <hr class="border-gray-100 my-2">
            <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl text-sm font-medium transition">
                <span>🚪</span> <span>Logout</span>
            </a>
        </aside>

        <main class="lg:col-span-3 space-y-6">
            <header class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Edit Profile</h2>
                    <p class="text-xs text-gray-400">Modify your public presentation details and shipping metrics.</p>
                </div>
            </header>

            <?php if(!empty($message)): ?>
                <div class="p-4 rounded-xl text-sm font-medium transition border <?php echo $messageType === 'success' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <form action="edit_profile.php" method="POST" class="space-y-6">
                    
                    <div class="flex items-center space-x-6 border-b border-gray-100 pb-6">
                        <div class="w-20 h-20 bg-gray-100 rounded-full overflow-hidden border border-gray-200 shadow-inner">
                            <img src="<?php echo $avatarUrl; ?>" alt="Avatar image photo" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm">Profile Picture</h4>
                            <p class="text-xs text-gray-400 mt-0.5">Avatar mutations are managed via global cloud nodes.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Full Name (System Locked)</label>
                            <input type="text" disabled value="<?php echo htmlspecialchars($userProfile['name']); ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-400 cursor-not-allowed font-medium focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email Address (System Locked)</label>
                            <input type="email" disabled value="<?php echo htmlspecialchars($userProfile['email']); ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-400 cursor-not-allowed font-medium focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Phone Number</label>
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($userProfile['phone'] ?? ''); ?>" placeholder="Enter phone number" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700 font-medium transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Default Delivery Address</label>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($userProfile['address'] ?? ''); ?>" placeholder="Enter precise flat/street address location" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700 font-medium transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Short Bio Description</label>
                        <textarea name="bio" rows="4" placeholder="Tell the kitchen a bit about your culinary food tastes..." class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm text-gray-700 font-medium transition resize-none"><?php echo htmlspecialchars($userProfile['bio'] ?? ''); ?></textarea>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" name="update_profile" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-xl transition duration-150 shadow-md shadow-green-600/10 text-sm">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>