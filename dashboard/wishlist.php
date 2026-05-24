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


if (isset($_GET['remove_id'])) {
    $removeId = (int)$_GET['remove_id'];
    if (isset($pdo)) {
        $deleteStmt = $pdo->prepare("DELETE FROM wishlists WHERE id = ? AND user_id = ?");
        if ($deleteStmt->execute([$removeId, $userId])) {
            $successMessage = "Item removed from your wishlist.";
        } else {
            $errorMessage = "Failed to remove item. Try again.";
        }
    }
}


$wishlistItems = [];
if (isset($pdo)) {
    $query = "SELECT w.id AS wishlist_id, d.id AS dish_id, d.name, d.price, d.image 
              FROM wishlists w 
              JOIN dishes d ON w.dish_id = d.id 
              WHERE w.user_id = ? 
              ORDER BY w.id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $wishlistItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - FoodNest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-[#FAFAFA] text-gray-800 font-sans overflow-x-hidden transition-colors duration-200 dark:bg-gray-950 dark:text-gray-100">

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="max-w-7xl mx-auto px-6 lg:px-12 py-10">
    
    <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">My Wishlist</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Your favorite dishes saved to order later.</p>
        </div>
        <a href="../menu.php" class="inline-flex items-center gap-2 border border-gray-200 hover:bg-gray-50 text-gray-800 px-5 py-3 rounded-xl font-semibold text-sm transition dark:bg-gray-900 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-800/80 self-start sm:self-auto">
            <span>🍴</span> Continue Exploring
        </a>
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

    <?php if (count($wishlistItems) > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($wishlistItems as $item): ?>
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col group dark:bg-gray-900 dark:border-gray-800">
                    
                    <div class="relative aspect-video w-full overflow-hidden bg-gray-100 dark:bg-gray-800">
                        <img 
                            src="<?php echo htmlspecialchars($item['image'] ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c'); ?>" 
                            alt="<?php echo htmlspecialchars($item['name']); ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                        >
                        <a href="?remove_id=<?php echo $item['wishlist_id']; ?>" 
                           onclick="return confirm('Are you sure you want to remove this item?')"
                           class="absolute top-3 right-3 w-9 h-9 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-rose-500 shadow-sm hover:bg-rose-50 transition"
                           title="Remove from wishlist">
                            ✕
                        </a>
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white leading-snug mb-1">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </h3>
                        <p class="text-[#2E7D32] font-extrabold text-xl mt-auto dark:text-green-500">
                            ৳<?php echo htmlspecialchars($item['price']); ?>
                        </p>
                        
                        <div class="mt-4 pt-3 border-t border-gray-50 dark:border-gray-800/60">
                            <form action="../cart_action.php" method="POST">
                                <input type="hidden" name="dish_id" value="<?php echo $item['dish_id']; ?>">
                                <input type="hidden" name="action" value="add">
                                <button type="submit" class="w-full bg-[#2E7D32] hover:bg-[#25672A] text-white py-3 rounded-xl font-semibold text-sm shadow-sm transition flex items-center justify-center gap-2 dark:bg-green-600 dark:hover:bg-green-700">
                                    <span>🛒</span> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-20 bg-white border border-gray-100 rounded-3xl dark:bg-gray-900 dark:border-gray-800">
            <div class="text-5xl mb-4">❤️</div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Your wishlist is empty</h3>
            <p class="text-gray-400 text-sm mt-1 max-w-sm mx-auto">Explore our menu and save your favorite meals here to order them instantly later.</p>
            <div class="mt-6">
                <a href="../menu.php" class="bg-[#2E7D32] hover:bg-[#25672A] text-white px-6 py-3 rounded-xl font-semibold text-sm shadow-md transition dark:bg-green-600 dark:hover:bg-green-700">
                    Explore Our Menu
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>