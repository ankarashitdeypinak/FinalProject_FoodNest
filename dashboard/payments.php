<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/config.php'; 

$baseUrl = "http://localhost/foodnest";

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $baseUrl . "/index.php");
    exit();
}

include __DIR__ . '/../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Simulation - FoodNest</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .payment-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .payment-card.active { border-color: #16a34a; background-color: rgba(22, 163, 74, 0.05); }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen transition-colors duration-200">

<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden p-6 md:p-8 transition-colors duration-200">
        
        <div class="border-b border-gray-100 dark:border-gray-800 pb-6 mb-8">
            <h2 class="text-2xl font-bold dark:text-white flex items-center gap-2">
                💳 Secure Payment Checkout
            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Select a payment method and simulate your transaction.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-2 space-y-4">
                <h3 class="text-lg font-semibold dark:text-white mb-3">1. Select Payment Method</h3>
                
                <div onclick="selectMethod('bkash')" id="method-bkash" class="payment-card border border-gray-200 dark:border-gray-700 rounded-2xl p-4 flex items-center justify-between cursor-pointer hover:border-pink-500 bg-white dark:bg-gray-800/50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/20 rounded-xl flex items-center justify-center font-bold text-pink-600 text-xs">
                            bKash
                        </div>
                        <div>
                            <p class="font-medium dark:text-white">bKash Wallet</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Pay instantly using bKash account</p>
                        </div>
                    </div>
                    <span class="text-pink-500 font-bold text-lg opacity-0 check-icon">✓</span>
                </div>

                <div onclick="selectMethod('nagad')" id="method-nagad" class="payment-card border border-gray-200 dark:border-gray-700 rounded-2xl p-4 flex items-center justify-between cursor-pointer hover:border-orange-500 bg-white dark:bg-gray-800/50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-xl flex items-center justify-center font-bold text-orange-600 text-xs">
                            Nagad
                        </div>
                        <div>
                            <p class="font-medium dark:text-white">Nagad Account</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Fast and secure digital gateway</p>
                        </div>
                    </div>
                    <span class="text-orange-500 font-bold text-lg opacity-0 check-icon">✓</span>
                </div>

                <div onclick="selectMethod('card')" id="method-card" class="payment-card border border-gray-200 dark:border-gray-700 rounded-2xl p-4 flex items-center justify-between cursor-pointer hover:border-blue-500 bg-white dark:bg-gray-800/50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-xl flex items-center justify-center font-bold text-blue-600 text-xs">
                            CARD
                        </div>
                        <div>
                            <p class="font-medium dark:text-white">Credit / Debit Card</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Visa, Mastercard or Amex</p>
                        </div>
                    </div>
                    <span class="text-blue-500 font-bold text-lg opacity-0 check-icon">✓</span>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-semibold dark:text-white mb-4">2. Payment Details</h3>
                    
                    <div id="form-mfs" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" id="label-mfs-phone">Phone Number</label>
                            <input type="text" id="mfs-phone" maxlength="11" placeholder="01XXXXXXXXX" class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-xl focus:outline-none focus:border-green-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" id="label-mfs-pin">Enter PIN</label>
                            <input type="password" id="mfs-pin" placeholder="••••" maxlength="5" class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-xl focus:outline-none focus:border-green-600">
                        </div>
                    </div>

                    <div id="form-card" class="hidden space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Card Holder Name</label>
                            <input type="text" id="card-name" placeholder="John Doe" class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-xl focus:outline-none focus:border-green-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Card Number</label>
                            <input type="text" id="card-number" placeholder="4242 4242 4242 4242" class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-xl focus:outline-none focus:border-green-600">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Expiry Date</label>
                                <input type="text" id="card-expiry" placeholder="MM/YY" class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-xl focus:outline-none focus:border-green-600">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CVV</label>
                                <input type="password" id="card-cvv" placeholder="•••" maxlength="3" class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-xl focus:outline-none focus:border-green-600">
                            </div>
                        </div>
                    </div>

                    <div id="select-prompt" class="text-gray-400 text-sm italic py-4">
                        Please choose a payment method above to proceed...
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800/40 rounded-2xl p-5 border border-gray-100 dark:border-gray-800/80 h-fit">
                <h3 class="text-md font-bold dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">Summary</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Subtotal</span>
                        <span>৳245</span>
                    </div>
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Delivery Fee</span>
                        <span>৳30</span>
                    </div>
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Vat / Tax</span>
                        <span>৳0.00</span>
                    </div>
                    <hr class="border-gray-200 dark:border-gray-700 my-2">
                    <div class="flex justify-between font-bold text-base dark:text-white">
                        <span>Total Payable</span>
                        <span class="text-green-600">৳275</span>
                    </div>
                </div>

                <button onclick="runSimulation()" id="pay-btn" disabled class="w-full mt-6 bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-semibold py-3.5 rounded-xl cursor-not-allowed transition-all duration-300 flex items-center justify-center gap-2">
                    Pay Now
                </button>
            </div>
        </div>

    </div>
</div>

<div id="payment-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl border border-gray-100 dark:border-gray-800">
        
        <div id="modal-loading" class="space-y-4">
            <div class="w-16 h-16 border-4 border-green-600 border-t-transparent rounded-full animate-spin mx-auto"></div>
            <h4 class="text-xl font-bold dark:text-white">Processing Payment...</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">Communicating securely with the banking server. Please wait.</p>
        </div>

        <div id="modal-success" class="hidden space-y-4">
            <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 text-green-600 text-3xl flex items-center justify-center rounded-full mx-auto font-bold animate-bounce">
                ✓
            </div>
            <h4 class="text-xl font-bold dark:text-white">Payment Successful!</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">Your dummy transaction was verified. Money has been allocated successfully.</p>
            <button onclick="closeModal()" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 rounded-xl transition">
                Back to Dashboard
            </button>
        </div>
    </div>
</div>

<script>
let selectedPaymentMethod = '';

function selectMethod(method) {
    selectedPaymentMethod = method;
    
    document.querySelectorAll('.payment-card').forEach(card => {
        card.classList.remove('active', 'border-pink-500', 'border-orange-500', 'border-blue-500');
        card.querySelector('.check-icon').classList.add('opacity-0');
    });

    const activeCard = document.getElementById(`method-${method}`);
    const payBtn = document.getElementById('pay-btn');
    const selectPrompt = document.getElementById('select-prompt');
    const formMfs = document.getElementById('form-mfs');
    const formCard = document.getElementById('form-card');


    document.getElementById('mfs-phone').value = '';
    document.getElementById('mfs-pin').value = '';

    payBtn.removeAttribute('disabled');
    payBtn.className = "w-full mt-6 bg-green-600 hover:bg-green-700 text-white font-semibold py-3.5 rounded-xl cursor-pointer shadow-lg shadow-green-600/20 transition-all duration-300 flex items-center justify-center gap-2";
    selectPrompt.classList.add('hidden');

    if (method === 'bkash') {
        activeCard.classList.add('active', 'border-pink-500');
        activeCard.querySelector('.check-icon').classList.remove('opacity-0');
        formMfs.classList.remove('hidden');
        formCard.classList.add('hidden');
        document.getElementById('label-mfs-phone').innerText = 'Enter your bKash Number';
        document.getElementById('label-mfs-pin').innerText = 'Enter bKash PIN';
    } else if (method === 'nagad') {
        activeCard.classList.add('active', 'border-orange-500');
        activeCard.querySelector('.check-icon').classList.remove('opacity-0');
        formMfs.classList.remove('hidden');
        formCard.classList.add('hidden');
        document.getElementById('label-mfs-phone').innerText = 'Enter your Nagad Number';
        document.getElementById('label-mfs-pin').innerText = 'Enter Nagad PIN';
    } else if (method === 'card') {
        activeCard.classList.add('active', 'border-blue-500');
        activeCard.querySelector('.check-icon').classList.remove('opacity-0');
        formCard.classList.remove('hidden');
        formMfs.classList.add('hidden');
    }
}

function runSimulation() {
    
    if (selectedPaymentMethod === 'bkash' || selectedPaymentMethod === 'nagad') {
        const phone = document.getElementById('mfs-phone').value.trim();
        const pin = document.getElementById('mfs-pin').value.trim();
        const mfsName = selectedPaymentMethod === 'bkash' ? 'bKash' : 'Nagad';

        if (phone.length !== 11 || isNaN(phone)) {
            alert(`Please enter a valid 11-digit ${mfsName} phone number.`);
            return;
        }
        if (pin.length < 4 || isNaN(pin)) {
            alert(`Please enter a valid PIN number.`);
            return;
        }
    }

    if (selectedPaymentMethod === 'card') {
        const cardName = document.getElementById('card-name').value.trim();
        const cardNumber = document.getElementById('card-number').value.trim();
        if(!cardName || !cardNumber) {
            alert('Please fill out card details properly.');
            return;
        }
    }

    const modal = document.getElementById('payment-modal');
    const loadingState = document.getElementById('modal-loading');
    const successState = document.getElementById('modal-success');

    modal.classList.remove('hidden');
    loadingState.classList.remove('hidden');
    successState.classList.add('hidden');

    setTimeout(() => {
        loadingState.classList.add('hidden');
        successState.classList.remove('hidden');
    }, 3000);
}

function closeModal() {
    document.getElementById('payment-modal').classList.add('hidden');
    window.location.href = "<?php echo $baseUrl; ?>/dashboard/dashboard.php";
}
</script>

</body>
</html>