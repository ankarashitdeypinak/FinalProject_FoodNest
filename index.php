<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodNest - Delicious Food, Delivered Fast</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght=1,400;1,500&display=swap" rel="stylesheet">
    <script>
        // Tailwind ডার্ক মোড ক্লাস বেসড করার জন্য কনফিগারেশন
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-[#FAFAFA] text-gray-800 font-sans overflow-x-hidden transition-colors duration-200 dark:bg-gray-950 dark:text-gray-100">

<?php include 'includes/navbar.php'; ?>

<section class="relative overflow-hidden bg-transparent">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-10 lg:py-16">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 bg-[#E8F5E9] text-[#2E7D32] px-5 py-2 rounded-full text-sm font-medium mb-8 dark:bg-green-950/40 dark:text-green-400">
                    <span>🍃</span>
                    <span>Delicious Food, Delivered Fast</span>
                </div>

                <h1 class="text-[56px] lg:text-[82px] leading-[0.95] font-extrabold text-[#111111] tracking-tight dark:text-white">
                    Good Food<br>
                    <span class="text-[#2E7D32] font-normal dark:text-green-500" style="font-family:'Playfair Display', serif;">
                        Good Life
                    </span>
                </h1>

                <p class="text-gray-500 text-lg leading-relaxed max-w-md mt-8 dark:text-gray-400">
                    FoodNest is your favorite destination for ordering delicious meals from top restaurants near you. Fast, easy and reliable!
                </p>

                <div class="flex items-center gap-5 mt-10">
                    <button class="bg-[#2E7D32] hover:bg-[#25672A] text-white px-8 py-4 rounded-xl font-semibold shadow-lg shadow-green-700/10 transition flex items-center gap-2 dark:bg-green-600 dark:hover:bg-green-700">
                        Order Now
                        <span>🛍️</span>
                    </button>
                    <button class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-800 px-8 py-4 rounded-xl font-semibold transition flex items-center gap-2 shadow-sm dark:bg-gray-900 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-800/80">
                        Explore Menu
                        <span>🍴</span>
                    </button>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-14 pt-8 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 rounded-2xl bg-[#E8F5E9] flex items-center justify-center text-2xl dark:bg-green-950/40">
                            🏪
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-black leading-none dark:text-white">120+</h4>
                            <p class="text-gray-400 text-sm mt-1 dark:text-gray-500">Restaurants</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 rounded-2xl bg-[#FFF4D8] flex items-center justify-center text-2xl dark:bg-yellow-950/30">
                            🍳
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-black leading-none dark:text-white">1000+</h4>
                            <p class="text-gray-400 text-sm mt-1 dark:text-gray-500">Dishes</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 rounded-2xl bg-[#FFE9EC] flex items-center justify-center text-2xl dark:bg-rose-950/30">
                            🥰
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-black leading-none dark:text-white">5000+</h4>
                            <p class="text-gray-400 text-sm mt-1 dark:text-gray-500">Happy Customers</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative flex items-center justify-center">
                <div class="absolute w-[420px] h-[420px] bg-[#9BE15D] rounded-full blur-[110px] opacity-40 dark:bg-green-700 dark:opacity-20"></div>

                <div class="absolute top-0 left-12 text-5xl rotate-12 select-none z-10">🍃</div>
                <div class="absolute bottom-28 right-0 text-4xl -rotate-12 select-none z-10">🍃</div>
                <div class="absolute top-40 left-0 text-4xl rotate-45 select-none z-10">🍃</div>

                <div class="absolute top-12 right-6 grid grid-cols-4 gap-2 opacity-20 dark:opacity-40">
                    <?php for($i=0; $i<12; $i++): ?>
                        <div class="w-2 h-2 rounded-full bg-gray-400 dark:bg-gray-600"></div>
                    <?php endfor; ?>
                </div>

                <div class="relative w-[470px] h-[470px]">
                    <div class="w-full h-full rounded-full overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.15)] bg-white dark:bg-gray-900">
                        <img 
                            src="https://healthyfitnessmeals.com/wp-content/uploads/2018/09/Mexican-grilled-chicken-bowls-9-819x1024.jpg"
                            alt="Healthy Bowl"
                            class="w-full h-full object-cover"
                        >
                    </div>

                    <div class="absolute top-4 -right-2 w-24 h-24 bg-[#FF9800] rounded-full flex flex-col items-center justify-center text-white shadow-xl z-20 transform rotate-12 dark:bg-amber-600">
                        <span class="text-2xl font-black leading-none">20%</span>
                        <span class="text-xs tracking-widest font-bold mt-1">OFF</span>
                    </div>
                </div>

                <div class="absolute bottom-8 left-4 lg:left-10 bg-white/95 backdrop-blur-md px-6 py-4 rounded-3xl shadow-[0_8px_20px_rgba(0,0,0,0.08)] border border-white flex items-center gap-8 min-w-[290px] z-20 dark:bg-gray-900/95 dark:border-gray-800">
                    <div>
                        <span class="text-[11px] uppercase tracking-wider text-gray-400 font-semibold dark:text-gray-500">
                            Today's Special
                        </span>
                        <h4 class="font-bold text-lg text-[#111111] mt-1 dark:text-white">
                            Grilled Chicken Bowl
                        </h4>
                        <p class="text-[#2E7D32] font-extrabold text-2xl mt-1 dark:text-green-500">
                            ৳200
                        </p>
                    </div>
                    <button class="w-14 h-14 rounded-2xl bg-[#FFF0F3] flex items-center justify-center text-2xl text-rose-500 hover:scale-110 transition dark:bg-rose-950/50 dark:text-rose-400">
                        ❤
                    </button>
                </div>

            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

</body>
</html>