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

<nav id="main-navbar" class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between w-full z-40 sticky top-0 shadow-sm transition-colors duration-200">
    
    <div class="flex items-center">
        <a href="<?php echo $baseUrl; ?>/index.php" class="text-2xl font-bold text-green-600 flex items-center gap-1 no-underline dark:text-green-500">
            <span class="p-1.5 bg-green-100 rounded-lg text-lg dark:bg-green-950/40">🥗</span> FoodNest
        </a>
    </div>

    <div class="hidden md:flex items-center space-x-6 text-gray-700 font-medium text-sm dark:text-gray-300">
        <a href="<?php echo $baseUrl; ?>/index.php" class="text-green-600 border-b-2 border-green-600 pb-1 dark:text-green-500 dark:border-green-500">Home</a>
        
        <button onclick="openModal('modal-features')" class="hover:text-green-600 transition dark:hover:text-green-500 cursor-pointer bg-transparent border-none font-medium text-sm text-gray-700 dark:text-gray-300">Features</button>
        
        <button onclick="openModal('modal-categories')" class="hover:text-green-600 transition dark:hover:text-green-500 cursor-pointer bg-transparent border-none font-medium text-sm text-gray-700 dark:text-gray-300">Categories</button>
        
        <button onclick="openModal('modal-about')" class="hover:text-green-600 transition dark:hover:text-green-500 cursor-pointer bg-transparent border-none font-medium text-sm text-gray-700 dark:text-gray-300">About Us</button>
        
        <button onclick="openModal('modal-contact')" class="hover:text-green-600 transition dark:hover:text-green-500 cursor-pointer bg-transparent border-none font-medium text-sm text-gray-700 dark:text-gray-300">Contact</button>
    </div>

    <div class="flex items-center space-x-5">
        <div class="hidden sm:flex items-center space-x-4 border-r border-gray-200 pr-5 dark:border-gray-800">
            <a href="https://facebook.com" target="_blank" class="text-gray-500 hover:text-green-600 transition-colors dark:text-gray-300 dark:hover:text-green-500">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>
            <a href="https://instagram.com" target="_blank" class="text-gray-500 hover:text-green-600 transition-colors dark:text-gray-300 dark:hover:text-green-500">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 0C8.74 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.74 0 12s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.977 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.666-.014 4.947-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.666.014 15.259 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 3.005.137 4.507 1.628 4.645 4.645.055 1.265.07 1.648.07 4.851 0 3.203-.015 3.586-.07 4.852-.137 3.004-1.627 4.506-4.645 4.644-1.265.056-1.647.071-4.85.071-3.204 0-3.586-.015-4.852-.071-3.005-.138-4.506-1.628-4.644-4.644-.056-1.266-.071-1.648-.071-4.852 0-3.204.015-3.586.071-4.85 1.38-3.005 1.628-4.507 4.644-4.646 1.266-.054 1.648-.07 4.852-.07zM12 5.83a6.17 6.17 0 1 0 0 12.34 6.17 6.17 0 0 0 0-12.34zm0 10.18a4.01 4.01 0 1 1 0-8.02 4.01 4.01 0 0 1 0 8.02zm6.404-10.855a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                </svg>
            </a>
            <a href="https://youtube.com" target="_blank" class="text-gray-500 hover:text-green-600 transition-colors dark:text-gray-300 dark:hover:text-green-500">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23.498 6.163a3.003 3.003 0 0 0-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.517 0-9.388.508a3.003 3.003 0 0 0-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 0 0 2.11 2.11c1.871.508 9.388.508 9.388.508s7.517 0 9.388-.508a3.003 3.003 0 0 0 2.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
            </a>
        </div>

        <button id="theme-toggle" class="text-gray-600 hover:text-gray-900 transition text-xl focus:outline-none select-none dark:text-gray-400 dark:hover:text-white cursor-pointer">
            <span id="theme-emoji">🌙</span>
        </button>

        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="relative cursor-pointer">
                <button class="text-gray-500 hover:text-gray-700 text-lg transition focus:outline-none dark:text-gray-400 dark:hover:text-gray-300 cursor-pointer">🔔</button>
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
                    <a href="<?php echo $baseUrl; ?>/dashboard/dashboard.php" class="flex items-center space-x-2 px-4 py-2.5 hover:bg-gray-50 rounded-xl text-sm text-gray-600 font-medium transition dark:text-gray-300 dark:hover:bg-gray-700/50 no-underline">
                        <span>🏠</span> <span>Dashboard</span>
                    </a>
                    <a href="<?php echo $baseUrl; ?>/dashboard/profile.php" class="flex items-center space-x-2 px-4 py-2.5 hover:bg-gray-50 rounded-xl text-sm text-gray-600 font-medium transition dark:text-gray-300 dark:hover:bg-gray-700/50 no-underline">
                        <span>👤</span> <span>My Profile</span>
                    </a>
                    <hr class="border-gray-100 my-1 dark:border-gray-700">
                    <a href="<?php echo $baseUrl; ?>/logout.php" class="flex items-center space-x-2 px-4 py-2.5 hover:bg-red-50 text-red-600 rounded-xl text-sm font-medium transition dark:text-red-400 dark:hover:bg-red-950/30 no-underline">
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

<div id="modal-features" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300 px-4">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-2xl max-w-sm w-full transform scale-95 transition-all duration-300 relative border border-gray-100 dark:border-gray-700">
        <button onclick="closeModal('modal-features')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-lg font-bold cursor-pointer">&times;</button>
        <div class="text-center">
            <span class="text-4xl block mb-2">⭐</span>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Our Features</h3>
            <div class="space-y-3 text-left">
                <div class="flex items-start gap-3 p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <span class="text-xl">🍔</span>
                    <div>
                        <h4 class="font-semibold text-sm text-gray-800 dark:text-white">Delicious Foods</h4>
                        <p class="text-xs text-gray-400">Browse a variety of tasty and fresh meals.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <span class="text-xl">⚡</span>
                    <div>
                        <h4 class="font-semibold text-sm text-gray-800 dark:text-white">Fast Delivery</h4>
                        <p class="text-xs text-gray-400">Get your favorite meals delivered quickly.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <span class="text-xl">🔒</span>
                    <div>
                        <h4 class="font-semibold text-sm text-gray-800 dark:text-white">Secure Payment</h4>
                        <p class="text-xs text-gray-400">Safe and secure online payment system.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-categories" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300 px-4">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-2xl max-w-sm w-full transform scale-95 transition-all duration-300 relative border border-gray-100 dark:border-gray-700">
        <button onclick="closeModal('modal-categories')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-lg font-bold cursor-pointer">&times;</button>
        <div class="text-center">
            <span class="text-4xl block mb-2">🍽️</span>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Food Categories</h3>
            <p class="text-xs text-gray-400 mb-4">Explore foods by categories</p>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-orange-50 dark:bg-orange-950/20 p-3 rounded-2xl text-sm font-semibold text-orange-700 dark:text-orange-400">🍕 Pizza</div>
                <div class="bg-red-50 dark:bg-red-950/20 p-3 rounded-2xl text-sm font-semibold text-red-700 dark:text-red-400">🍔 Burger</div>
                <div class="bg-yellow-50 dark:bg-yellow-950/20 p-3 rounded-2xl text-sm font-semibold text-yellow-700 dark:text-yellow-500">🍟 Snacks</div>
                <div class="bg-green-50 dark:bg-green-950/20 p-3 rounded-2xl text-sm font-semibold text-green-700 dark:text-green-400">🥗 Healthy</div>
            </div>
        </div>
    </div>
</div>

<div id="modal-about" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300 px-4">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-2xl max-w-sm w-full transform scale-95 transition-all duration-300 relative border border-gray-100 dark:border-gray-700">
        <button onclick="closeModal('modal-about')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-lg font-bold cursor-pointer">&times;</button>
        <div class="text-center">
            <span class="text-4xl block mb-2">📖</span>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-3">About FoodNest</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-justify leading-relaxed">
                FoodNest is a modern online food ordering platform designed to make food delivery fast, simple, and enjoyable. Our goal is to connect food lovers with delicious meals through a beautiful and responsive website experience. We focus on quality food, smooth ordering, and customer satisfaction.
            </p>
        </div>
    </div>
</div>

<div id="modal-contact" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300 px-4">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-2xl max-w-sm w-full transform scale-95 transition-all duration-300 relative border border-gray-100 dark:border-gray-700">
        <button onclick="closeModal('modal-contact')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-lg font-bold cursor-pointer">&times;</button>
        <div class="text-center">
            <span class="text-4xl block mb-2">📞</span>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Contact Us</h3>
            <div class="space-y-3 text-left">
                <div class="bg-gray-50 dark:bg-gray-900/50 p-3 rounded-2xl flex items-center gap-3">
                    <span class="text-xl">📍</span>
                    <div>
                        <h4 class="font-bold text-xs text-gray-400 uppercase">Location</h4>
                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Sylhet, Bangladesh</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/50 p-3 rounded-2xl flex items-center gap-3">
                    <span class="text-xl">📞</span>
                    <div>
                        <h4 class="font-bold text-xs text-gray-400 uppercase">Phone</h4>
                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">+880 1XXXXXXXXX</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900/50 p-3 rounded-2xl flex items-center gap-3">
                    <span class="text-xl">✉️</span>
                    <div>
                        <h4 class="font-bold text-xs text-gray-400 uppercase">Email</h4>
                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">support@foodnest.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if(modal) {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
        modal.firstElementChild.classList.remove('scale-95');
        modal.firstElementChild.classList.add('scale-100');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if(modal) {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        modal.firstElementChild.classList.add('scale-95');
        modal.firstElementChild.classList.remove('scale-100');
    }
}

window.addEventListener('click', (e) => {
    const modals = ['modal-features', 'modal-categories', 'modal-about', 'modal-contact'];
    modals.forEach(id => {
        const modal = document.getElementById(id);
        if (e.target === modal) {
            closeModal(id);
        }
    });
});

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
            if(profileArrow) profileArrow.classList.add('rotate-180');
        } else {
            profileDropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            profileDropdown.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
            if(profileArrow) profileArrow.classList.remove('rotate-180');
        }
    });

    document.addEventListener('click', (e) => {
        if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
            profileDropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            profileDropdown.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
            if(profileArrow) profileArrow.classList.remove('rotate-180');
        }
    });
}
</script>