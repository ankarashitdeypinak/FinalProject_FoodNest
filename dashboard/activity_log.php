<?php
require_once '../includes/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT action, ip_address, timestamp FROM activity_log WHERE user_id = ? ORDER BY timestamp DESC");
$stmt->execute([$userId]);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>FoodNest - Activity Log</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <?php include '../includes/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-4 gap-8">
        <aside class="space-y-2 bg-white p-6 rounded-2xl border border-gray-100 h-fit">
            <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium">
                <span>📊</span> <span>Dashboard</span>
            </a>
            <a href="profile.php" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium">
                <span>👤</span> <span>My Profile</span>
            </a>
            <a href="activity_log.php" class="flex items-center space-x-3 px-4 py-3 bg-green-50 text-green-700 rounded-xl font-semibold text-sm">
                <span>📜</span> <span>Activity Log</span>
            </a>
            <hr class="border-gray-100 my-2">
            <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl text-sm font-medium">
                <span>🚪</span> <span>Logout</span>
            </a>
        </aside>

        <main class="lg:col-span-3 space-y-6">
            <header>
                <h2 class="text-2xl font-bold text-gray-900">Your Activity History</h2>
                <p class="text-xs text-gray-400">Security event logging monitoring active sessions.</p>
            </header>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Action Type Event</th>
                            <th class="px-6 py-4">IP Address Location</th>
                            <th class="px-6 py-4">Timestamp Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm text-gray-600">
                        <?php if(count($logs) > 0): ?>
                            <?php foreach($logs as $log): ?>
                                <tr>
                                    <td class="px-6 py-4 font-semibold text-gray-800"><?php echo htmlspecialchars($log['action']); ?></td>
                                    <td class="px-6 py-4 font-mono text-xs"><?php echo htmlspecialchars($log['ip_address']); ?></td>
                                    <td class="px-6 py-4 text-xs text-gray-400"><?php echo htmlspecialchars($log['timestamp']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-400 text-sm">No recorded system entries detected yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>