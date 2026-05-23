<?php 
require_once dirname(__DIR__) . '/includes/config.php'; 

if (!isset($conn)) {
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - FoodNest</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FAFAFA] text-gray-800 font-sans min-h-screen flex flex-col justify-between overflow-x-hidden">

<?php include dirname(__DIR__) . '/includes/navbar.php'; ?>

<main class="max-w-7xl mx-auto px-6 lg:px-12 py-10 lg:py-16 flex-grow w-full grid grid-cols-1 lg:grid-cols-12 gap-8 relative">
    
    <aside class="lg:col-span-3 bg-white border border-gray-100 rounded-3xl p-6 shadow-[0_10px_30px_rgba(0,0,0,0.02)] h-fit space-y-2">
        <div class="flex items-center space-x-3 px-3 py-4 border-b border-gray-50 mb-4">
            <div class="w-12 h-12 bg-[#E8F5E9] text-[#2E7D32] rounded-2xl flex items-center justify-center text-xl font-bold">
                FN
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-sm leading-tight">FoodNest User</h3>
                <p class="text-[11px] text-gray-400">Manage account & track</p>
            </div>
        </div>

        <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-[#FAFAFA] hover:text-gray-800 transition font-medium text-sm">
            <span>📊</span> <span>Dashboard</span>
        </a>
        <a href="profile.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-[#FAFAFA] hover:text-gray-800 transition font-medium text-sm">
            <span>👤</span> <span>My Profile</span>
        </a>
        <a href="orders.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-[#E8F5E9] text-[#2E7D32] transition font-semibold text-sm">
            <span>📦</span> <span>My Orders</span>
        </a>
        <a href="wishlist.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-[#FAFAFA] hover:text-gray-800 transition font-medium text-sm">
            <span>❤️</span> <span>Wishlist</span>
        </a>
        <a href="payments.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-[#FAFAFA] hover:text-gray-800 transition font-medium text-sm">
            <span>💳</span> <span>Payments</span>
        </a>
        <hr class="border-gray-50 my-4">
        <a href="logout.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition font-medium text-sm">
            <span>🚪</span> <span>Logout</span>
        </a>
    </aside>

    <section class="lg:col-span-9 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-[#111111] tracking-tight">Recent Orders</h1>
                <p class="text-xs text-gray-400 mt-1">Check the status of your live track orders and look over history</p>
            </div>
            <span class="text-xs font-bold text-[#2E7D32] bg-[#E8F5E9] px-4 py-2 rounded-xl">
                Active History
            </span>
        </div>

        <div class="space-y-4">
            
            <?php
            $mock_orders = [
                [
                    'id' => '#ORD-8932',
                    'image' => 'https://healthyfitnessmeals.com/wp-content/uploads/2018/09/Mexican-grilled-chicken-bowls-9-819x1024.jpg',
                    'item' => 'Grilled Chicken Bowl',
                    'restaurant' => 'Healthy Bites Tavern',
                    'date' => 'May 20, 2026',
                    'price' => '৳8.99',
                    'status' => 'Delivered',
                    'status_color' => 'bg-[#E8F5E9] text-[#2E7D32]'
                ],
                [
                    'id' => '#ORD-7741',
                    'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=500&q=80',
                    'item' => 'Veggie Delicacy Pizza',
                    'restaurant' => 'Pizza House Co.',
                    'date' => 'May 16, 2026',
                    'price' => '৳31.55',
                    'status' => 'Delivered',
                    'status_color' => 'bg-[#E8F5E9] text-[#2E7D32]'
                ],
                [
                    'id' => '#ORD-3129',
                    'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=500&q=80',
                    'item' => 'Smoked Chicken Burger',
                    'restaurant' => 'Burger Hub Express',
                    'date' => 'May 15, 2026',
                    'price' => '৳5.99',
                    'status' => 'Cancelled',
                    'status_color' => 'bg-[#FFEBEE] text-rose-600'
                ]
            ];

            foreach ($mock_orders as $order):
            ?>
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-[0_8px_25px_rgba(0,0,0,0.01)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:border-gray-200/80">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-50 flex-shrink-0 border border-gray-100">
                        <img src="<?php echo $order['image']; ?>" alt="Dish" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-[11px] font-mono font-bold text-gray-400 tracking-wider"><?php echo $order['id']; ?></span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?php echo $order['status_color']; ?>"><?php echo $order['status']; ?></span>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mt-0.5"><?php echo $order['item']; ?></h4>
                        <p class="text-[11px] text-gray-400 mt-0.5">Ordered from <span class="text-gray-500 font-medium"><?php echo $order['restaurant']; ?></span></p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between sm:justify-end gap-6 border-t sm:border-t-0 border-gray-50 pt-3 sm:pt-0">
                    <div class="text-left sm:text-right">
                        <span class="text-[10px] text-gray-400 block tracking-wider uppercase font-medium">Placed on</span>
                        <span class="text-xs font-bold text-gray-600 mt-0.5 block"><?php echo $order['date']; ?></span>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-[10px] text-gray-400 block tracking-wider uppercase font-medium">Total Paid</span>
                        <span class="text-sm font-extrabold text-[#2E7D32] mt-0.5 block"><?php echo $order['price']; ?></span>
                    </div>
                    <div>
                        <button class="bg-white border border-gray-100 text-gray-700 font-bold text-xs px-4 py-2.5 rounded-xl hover:bg-gray-50 shadow-sm transition whitespace-nowrap">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </section>

</main>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>

</body>
</html>