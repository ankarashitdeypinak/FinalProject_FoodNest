<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config.php'; 

$baseUrl = "http://localhost/foodnest";

$navUserName = 'User';
if (isset($pdo) && isset($_SESSION['user_id'])) {
    $navStmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
    $navStmt->execute([$_SESSION['user_id']]);
    $navUserProfile = $navStmt->fetch(PDO::FETCH_ASSOC);
    if ($navUserProfile) {
        $navUserName = $navUserProfile['name'];
    }
}
?>

<nav id="main-navbar" class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between w-full z-50 sticky top-0 shadow-sm transition-colors duration-200">
    
    <div class="flex items-center">
        <a href="<?php echo $baseUrl; ?>/index.php" class="text-2xl font-bold text-green-600 flex items-center gap-1 no-underline dark:text-green-500">
            <span class="p-1.5 bg-green-100 rounded-lg text-lg dark:bg-green-950/40">🥗</span> FoodNest
        </a>
    </div>

    
    <div class="hidden md:flex items-center space-x-6 text-gray-700 font-medium text-sm dark:text-gray-300">
        <a href="<?php echo $baseUrl; ?>/index.php" class="text-green-600 border-b-2 border-green-600 pb-1 dark:text-green-500 dark:border-green-500">Home</a>
        
        <a href="#features" class="hover:text-green-600 transition dark:hover:text-green-500">Features</a>
        
        <a href="#categories" class="hover:text-green-600 transition dark:hover:text-green-500">Categories</a>
        
        <a href="#about-us" class="hover:text-green-600 transition dark:hover:text-green-500">About Us</a>
        
        <a href="#contact" class="hover:text-green-600 transition dark:hover:text-green-500">Contact</a>
    </div>

    
    <div class="flex items-center space-x-5">

        
        <div class="hidden sm:flex items-center space-x-4 border-r border-gray-200 pr-5 dark:border-gray-800">
            
            <a href="https://facebook.com" target="_blank" class="text-gray-600 hover:text-green-600 transition dark:text-gray-400 dark:hover:text-green-500">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.8z"/>
                </svg>
            </a>

            <a href="https://instagram.com" target="_blank" class="text-gray-600 hover:text-green-600 transition dark:text-gray-400 dark:hover:text-green-500">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204 0.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                </svg>
            </a>

            <a href="https://youtube.com" target="_blank" class="text-gray-600 hover:text-green-600 transition dark:text-gray-400 dark:hover:text-green-500">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.517 0-9.388.508a3.003 3.003 0 00-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 002.11 2.11c1.871.508 9.388.508 9.388.508s7.517 0 9.388-.508a3.003 3.003 0 002.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837z"/>
                </svg>
            </a>
        </div>

        
        <button id="theme-toggle" class="text-gray-600 hover:text-gray-900 transition text-xl focus:outline-none select-none dark:text-gray-400 dark:hover:text-white">
            <span id="theme-emoji">🌙</span>
        </button>

        <?php if(isset($_SESSION['user_id'])): ?>

            
            <div class="relative cursor-pointer">
                <button class="text-gray-500 hover:text-gray-700 text-lg transition focus:outline-none dark:text-gray-400 dark:hover:text-gray-300">🔔</button>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">3</span>
            </div>

            
            <div class="relative flex items-center space-x-2 py-1 select-none">

                <div id="profile-menu-btn" class="flex items-center space-x-2 cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&q=80" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-gray-100 dark:border-gray-800">

                    <span class="text-sm font-medium text-gray-700 max-w-[100px] truncate dark:text-gray-300">
                        <?php echo htmlspecialchars($navUserName); ?>
                    </span>

                    <span id="profile-arrow" class="text-[9px] text-gray-400 transition-transform duration-200">▼</span>
                </div>

                
                <div id="profile-dropdown" class="absolute right-0 top-full mt-2 w-48 bg-white rounded-2xl border border-gray-200 shadow-xl opacity-0 scale-95 pointer-events-none transition-all duration-200 z-50 p-2 dark:bg-gray-800 dark:border-gray-700">

                    <a href="<?php echo $baseUrl; ?>/dashboard/dashboard.php" class="flex items-center space-x-2 px-4 py-2.5 hover:bg-gray-50 rounded-xl text-sm text-gray-600 font-medium transition dark:text-gray-300 dark:hover:bg-gray-700/50">
                        <span>🏠</span> <span>Dashboard</span>
                    </a>

                    <a href="<?php echo $baseUrl; ?>/dashboard/profile.php" class="flex items-center space-x-2 px-4 py-2.5 hover:bg-gray-50 rounded-xl text-sm text-gray-600 font-medium transition dark:text-gray-300 dark:hover:bg-gray-700/50">
                        <span>👤</span> <span>My Profile</span>
                    </a>

                    <hr class="border-gray-100 my-1 dark:border-gray-700">

                    <a href="<?php echo $baseUrl; ?>/logout.php" class="flex items-center space-x-2 px-4 py-2.5 hover:bg-red-50 text-red-600 rounded-xl text-sm font-medium transition dark:text-red-400 dark:hover:bg-red-950/30">
                        <span>🚪</span> <span>Logout</span>
                    </a>
                </div>
            </div>

        <?php else: ?>

            <a href="<?php echo $baseUrl; ?>/login.php" class="border border-gray-200 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold shadow-sm hover:bg-gray-50 transition no-underline dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                Login
            </a>

            <a href="<?php echo $baseUrl; ?>/register.php" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl text-sm font-semibold shadow-sm transition no-underline dark:bg-green-500 dark:hover:bg-green-600">
                Register
            </a>

        <?php endif; ?>
    </div>
</nav>



<section id="features" class="py-20 px-6 bg-gray-50 dark:bg-gray-900">
    
    <div class="max-w-6xl mx-auto text-center">

        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">
            Our Features
        </h2>

        <p class="text-gray-500 dark:text-gray-400 mb-12">
            FoodNest provides a fast and modern food ordering experience.
        </p>

        <div class="grid md:grid-cols-3 gap-8">

            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-md">
                <div class="text-5xl mb-4">🍔</div>
                <h3 class="text-xl font-semibold mb-2 dark:text-white">Delicious Foods</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    Browse a variety of tasty and fresh meals.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-md">
                <div class="text-5xl mb-4">⚡</div>
                <h3 class="text-xl font-semibold mb-2 dark:text-white">Fast Delivery</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    Get your favorite meals delivered quickly.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-md">
                <div class="text-5xl mb-4">🔒</div>
                <h3 class="text-xl font-semibold mb-2 dark:text-white">Secure Payment</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    Safe and secure online payment system.
                </p>
            </div>

        </div>
    </div>
</section>


<section id="categories" class="py-20 px-6 bg-white dark:bg-gray-950">

    <div class="max-w-6xl mx-auto text-center">

        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">
            Food Categories
        </h2>

        <p class="text-gray-500 dark:text-gray-400 mb-12">
            Explore foods by categories.
        </p>

        <div class="grid md:grid-cols-4 gap-6">

            <div class="bg-orange-100 dark:bg-orange-950/30 p-6 rounded-2xl text-xl font-semibold">
                🍕 Pizza
            </div>

            <div class="bg-red-100 dark:bg-red-950/30 p-6 rounded-2xl text-xl font-semibold">
                🍔 Burger
            </div>

            <div class="bg-yellow-100 dark:bg-yellow-950/30 p-6 rounded-2xl text-xl font-semibold">
                🍟 Snacks
            </div>

            <div class="bg-green-100 dark:bg-green-950/30 p-6 rounded-2xl text-xl font-semibold">
                🥗 Healthy
            </div>

        </div>
    </div>
</section>



<section id="about-us" class="py-20 px-6 bg-gray-50 dark:bg-gray-900">

    <div class="max-w-5xl mx-auto text-center">

        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-6">
            About FoodNest
        </h2>

        <p class="text-lg text-gray-600 dark:text-gray-400 leading-8">
            FoodNest is a modern online food ordering platform designed to make food delivery fast, simple, and enjoyable. 
            Our goal is to connect food lovers with delicious meals through a beautiful and responsive website experience. 
            We focus on quality food, smooth ordering, and customer satisfaction.
        </p>

    </div>
</section>



<section id="contact" class="py-20 px-6 bg-white dark:bg-gray-950">

    <div class="max-w-5xl mx-auto text-center">

        <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-6">
            Contact Us
        </h2>

        <p class="text-gray-600 dark:text-gray-400 mb-8">
            Feel free to contact us anytime.
        </p>

        <div class="grid md:grid-cols-3 gap-8">

            <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-2xl shadow-md">
                <div class="text-4xl mb-3">📍</div>
                <h3 class="font-semibold text-lg dark:text-white">Location</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    Sylhet, Bangladesh
                </p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-2xl shadow-md">
                <div class="text-4xl mb-3">📞</div>
                <h3 class="font-semibold text-lg dark:text-white">Phone</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    +880 1XXXXXXXXX
                </p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-2xl shadow-md">
                <div class="text-4xl mb-3">✉️</div>
                <h3 class="font-semibold text-lg dark:text-white">Email</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    support@foodnest.com
                </p>
            </div>

        </div>
    </div>
</section>


<script>
const themeEmoji = document.getElementById('theme-emoji');
const navbarElement = document.getElementById('main-navbar');

function applyTheme() {

    const footerElement = document.getElementById('main-footer');

    if (
        localStorage.getItem('theme') === 'dark' ||
        (!('theme' in localStorage) &&
        window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {

        document.documentElement.classList.add('dark');

        if(themeEmoji) themeEmoji.textContent = '☀️';

        if(navbarElement) {
            navbarElement.classList.remove('bg-white', 'border-gray-100');
            navbarElement.classList.add('bg-gray-900', 'border-gray-800');
        }

        if(footerElement) {
            footerElement.classList.remove('bg-white', 'border-gray-100');
            footerElement.classList.add('bg-gray-900', 'border-gray-800');
        }

    } else {

        document.documentElement.classList.remove('dark');

        if(themeEmoji) themeEmoji.textContent = '🌙';

        if(navbarElement) {
            navbarElement.classList.remove('bg-gray-900', 'border-gray-800');
            navbarElement.classList.add('bg-white', 'border-gray-100');
        }

        if(footerElement) {
            footerElement.classList.remove('bg-gray-900', 'border-gray-800');
            footerElement.classList.add('bg-white', 'border-gray-100');
        }
    }
}

applyTheme();

document.getElementById('theme-toggle').addEventListener('click', () => {

    if (document.documentElement.classList.contains('dark')) {
        localStorage.setItem('theme', 'light');
    } else {
        localStorage.setItem('theme', 'dark');
    }

    applyTheme();
});


const profileBtn = document.getElementById('profile-menu-btn');
const profileDropdown = document.getElementById('profile-dropdown');
const profileArrow = document.getElementById('profile-arrow');

if (profileBtn && profileDropdown) {

    profileBtn.addEventListener('click', (e) => {

        e.stopPropagation();

        const isOpen = profileDropdown.classList.contains('pointer-events-auto');

        if (!isOpen) {

            profileDropdown.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
            profileDropdown.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');

            profileArrow.classList.add('rotate-180');

        } else {

            profileDropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            profileDropdown.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');

            profileArrow.classList.remove('rotate-180');
        }
    });

    document.addEventListener('click', (e) => {

        if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {

            profileDropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            profileDropdown.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');

            profileArrow.classList.remove('rotate-180');
        }
    });
}
</script>