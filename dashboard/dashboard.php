<?php
require_once '../includes/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Get profile details - Fixed schema mapping
$stmt = $pdo->prepare("SELECT users.name, users.email, profiles.phone, profiles.address, profiles.bio FROM users JOIN profiles ON users.id = profiles.user_id WHERE users.id = ?");
$stmt->execute([$userId]);
$userProfile = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodNest - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-icons/css/font-awesome.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    
    <?php include '../includes/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">
        <aside class="space-y-1 bg-white p-4 rounded-2xl border border-gray-100 h-fit shadow-sm">
            <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 bg-green-50 text-green-700 rounded-xl font-semibold text-sm">
                <span class="text-base">🏠</span> <span>Dashboard</span>
            </a>
            <a href="profile.php" class="flex items-center space-x-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                <span class="text-base text-gray-400">👤</span> <span>My Profile</span>
            </a>
            <a href="orders.php" class="flex items-center space-x-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                <span class="text-base text-gray-400">🛍️</span> <span>My Orders</span>
            </a>
            <a href="wishlist.php" class="flex items-center space-x-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                <span class="text-base text-gray-400">🤍</span> <span>Wishlist</span>
            </a>
            <a href="payments.php" class="flex items-center space-x-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                <span class="text-base text-gray-400">💳</span> <span>Payments</span>
            </a>
            <a href="activity_log.php" class="flex items-center space-x-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                <span class="text-base text-gray-400">📊</span> <span>Activity Log</span>
            </a>
            <a href="settings.php" class="flex items-center space-x-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                <span class="text-base text-gray-400">⚙️</span> <span>Settings</span>
            </a>
            <hr class="border-gray-100 my-2">
            <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 text-gray-500 hover:bg-red-50 hover:text-red-600 rounded-xl text-sm font-medium transition">
                <span class="text-base text-gray-400">🚪</span> <span>Logout</span>
            </a>
        </aside>

        <main class="lg:col-span-3 space-y-6">
            <header class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
                </div>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-gray-400 text-xs font-medium">Total Orders</span>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">12</h3>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-[11px] text-gray-400 hover:underline cursor-pointer">View all orders</span>
                        <span class="w-7 h-7 bg-green-50 text-green-600 rounded-lg flex items-center justify-center text-sm">🛍️</span>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-gray-400 text-xs font-medium">Pending Orders</span>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">3</h3>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-[11px] text-gray-400 hover:underline cursor-pointer">View all orders</span>
                        <span class="w-7 h-7 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center text-sm">⏳</span>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-gray-400 text-xs font-medium">Total Spent</span>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">৳245.50</h3>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-[11px] text-gray-400 hover:underline cursor-pointer">View details</span>
                        <span class="w-7 h-7 bg-green-50 text-green-600 rounded-lg flex items-center justify-center text-sm">📊</span>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-gray-400 text-xs font-medium">Wishlist</span>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">8</h3>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-[11px] text-gray-400 hover:underline cursor-pointer">View wishlist</span>
                        <span class="w-7 h-7 bg-rose-50 text-rose-500 rounded-lg flex items-center justify-center text-sm">❤️</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm md:col-span-2 space-y-4">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-gray-900 text-sm">Recent Orders</h4>
                        <a href="orders.php" class="text-xs text-green-600 font-medium hover:underline">View All</a>
                    </div>
                    <div class="divide-y divide-gray-100 text-sm">
                        <div class="flex items-center justify-between py-3.5">
                            <div class="flex items-center space-x-3">
                                <span class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-xl border border-gray-100">🍲</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Grilled Chicken Bowl</p>
                                    <p class="text-[11px] text-gray-400">May 20, 2026</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 text-sm">৳8.99</p>
                                <span class="text-[10px] bg-green-50 text-green-700 px-2 py-0.5 rounded-full font-semibold">Delivered</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between py-3.5">
                            <div class="flex items-center space-x-3">
                                <span class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-xl border border-gray-100">🍕</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Veggie Delight Pizza</p>
                                    <p class="text-[11px] text-gray-400">May 18, 2026</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 text-sm">৳11.50</p>
                                <span class="text-[10px] bg-green-50 text-green-700 px-2 py-0.5 rounded-full font-semibold">Delivered</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between py-3.5">
                            <div class="flex items-center space-x-3">
                                <span class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-xl border border-gray-100">🍔</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Chicken Burger</p>
                                    <p class="text-[11px] text-gray-400">May 15, 2026</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 text-sm">৳6.99</p>
                                <span class="text-[10px] bg-red-50 text-red-600 px-2 py-0.5 rounded-full font-semibold">Cancelled</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 md:col-span-1">
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-gray-900 text-sm">Profile Summary</h4>
                            <a href="profile.php" class="text-xs text-green-600 font-medium hover:underline">Edit Profile</a>
                        </div>
                        <div class="flex items-center space-x-3 py-2">
                            <div class="w-14 h-14 rounded-full overflow-hidden border border-gray-100 shrink-0">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&q=80" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <h5 class="font-bold text-gray-900 text-sm truncate"><?php echo htmlspecialchars($userProfile['name']); ?></h5>
                                <p class="text-xs text-gray-400 truncate"><?php echo htmlspecialchars($userProfile['email']); ?></p>
                                <p class="text-[11px] text-gray-500 mt-0.5"><?php echo htmlspecialchars($userProfile['phone'] ?? '+123 456 7890'); ?></p>
                                <p class="text-[10px] text-gray-400"><?php echo htmlspecialchars($userProfile['address'] ?? 'Dhaka, Bangladesh'); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm space-y-3">
                        <h4 class="font-bold text-gray-900 text-sm">Quick Actions</h4>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <a href="profile.php" class="p-2 border border-gray-100 rounded-xl hover:bg-gray-50 flex flex-col items-center justify-center transition">
                                <span class="text-base mb-1">👤</span>
                                <span class="text-[9px] font-medium text-gray-600 whitespace-nowrap">Update Profile</span>
                            </a>
                            <a href="settings.php" class="p-2 border border-gray-100 rounded-xl hover:bg-gray-50 flex flex-col items-center justify-center transition">
                                <span class="text-base mb-1">🔒</span>
                                <span class="text-[9px] font-medium text-gray-600 whitespace-nowrap">Password</span>
                            </a>
                            <a href="payments.php" class="p-2 border border-gray-100 rounded-xl hover:bg-gray-50 flex flex-col items-center justify-center transition">
                                <span class="text-base mb-1">💳</span>
                                <span class="text-[9px] font-medium text-gray-600 whitespace-nowrap">Methods</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-emerald-800 to-green-700 rounded-3xl p-8 text-white relative overflow-hidden shadow-sm flex items-center justify-between min-h-[160px]">
                <div class="space-y-2 z-10 max-w-[60%]">
                    <h3 class="text-xl font-bold tracking-tight">Get 20% OFF on your next order!</h3>
                    <p class="text-xs text-green-100/80 flex items-center">Use code: <span class="bg-emerald-900/50 px-2 py-1 rounded-md font-mono text-white font-bold ml-2 tracking-wider border border-emerald-600/40">FOODNEST20</span></p>
                    <button class="mt-3 bg-white text-green-800 font-bold text-xs px-5 py-2.5 rounded-xl shadow-md hover:bg-green-50 transition active:scale-95">Order Now</button>
                </div>
                <div class="absolute right-0 bottom-0 top-0 w-2/5 flex items-center justify-center z-0 overflow-hidden">
                    <img src="https://www.pngarts.com/files/3/Burger-PNG-Transparent-Image.png" alt="Promo Burger" class="w-40 h-40 object-contain drop-shadow-2xl transform rotate-6 translate-y-3 translate-x-2">
                </div>
            </div>
        </main>
    </div>
</body>
</html>