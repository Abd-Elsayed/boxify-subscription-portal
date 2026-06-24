<?php
session_start();
require_once 'classes/Database.php';
include 'includes/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];
$db = new Database(); 

$sub = $db->query("SELECT * FROM subscriptions WHERE user_id = ?", [$user_id])->fetch();
$hasSubscription = $sub ? true : false;

$plans = [
    'Standard' => ['items' => 3, 'swaps' => 1, 'price' => 20, 'color' => '#f8f9fa', 'text' => '#6c757d'],
    'Gold'     => ['items' => 6, 'swaps' => 3, 'price' => 50, 'color' => 'linear-gradient(135deg, #fff3b0 0%, #ffd700 100%)', 'text' => '#856404'],
    'VIP'      => ['items' => 10, 'swaps' => 'unlimited', 'price' => 100, 'color' => 'linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%)', 'text' => '#495057']
];

$items = [
    
    1 => ['name' => 'Wireless Headphones', 'img' => '🎧', 'cat' => 'Tech'],
    2 => ['name' => 'Smart Watch Pro', 'img' => '⌚', 'cat' => 'Tech'],
    3 => ['name' => 'Fast Charger 65W', 'img' => '🔌', 'cat' => 'Tech'],
    4 => ['name' => 'Bluetooth Speaker', 'img' => '🔊', 'cat' => 'Tech'],
    5 => ['name' => 'Power Bank 20,000mAh', 'img' => '🔋', 'cat' => 'Tech'],
    6 => ['name' => 'Mechanical Keyboard', 'img' => '⌨️', 'cat' => 'Tech'],
    7 => ['name' => 'Wireless Gaming Mouse', 'img' => '🖱️', 'cat' => 'Tech'],
    8 => ['name' => 'Screen Light Bar', 'img' => '💡', 'cat' => 'Tech'],
    9 => ['name' => 'USB-C Hub (7-in-1)', 'img' => '📑', 'cat' => 'Tech'],
    10 => ['name' => 'Mini Security Camera', 'img' => '📹', 'cat' => 'Tech'],

    
    11 => ['name' => 'Coffee Maker Pro', 'img' => '☕', 'cat' => 'Home'],
    12 => ['name' => 'Air Purifier Plus', 'img' => '🍃', 'cat' => 'Home'],
    13 => ['name' => 'Scented Candle Set', 'img' => '🕯️', 'cat' => 'Home'],
    14 => ['name' => 'Digital Kitchen Scale', 'img' => '⚖️', 'cat' => 'Home'],
    15 => ['name' => 'Electric Milk Frother', 'img' => '🌪️', 'cat' => 'Home'],
    16 => ['name' => 'Self-Watering Pot', 'img' => '🪴', 'cat' => 'Home'],
    17 => ['name' => 'Smart LED Bulb', 'img' => '🌈', 'cat' => 'Home'],
    18 => ['name' => 'Memory Foam Pillow', 'img' => '☁️', 'cat' => 'Home'],
    19 => ['name' => 'Ultrasonic Diffuser', 'img' => '🌫️', 'cat' => 'Home'],
    20 => ['name' => 'Magnetic Tool Kit', 'img' => '🧰', 'cat' => 'Home'],

    
    21 => ['name' => 'Organic Raw Honey', 'img' => '🍯', 'cat' => 'Market'],
    22 => ['name' => 'Extra Virgin Olive Oil', 'img' => '🫒', 'cat' => 'Market'],
    23 => ['name' => 'Premium Mixed Nuts', 'img' => '🥜', 'cat' => 'Market'],
    24 => ['name' => 'Dark Chocolate', 'img' => '🍫', 'cat' => 'Market'],
    25 => ['name' => 'Japanese Matcha Powder', 'img' => '🍵', 'cat' => 'Market'],
    26 => ['name' => 'Peanut Butter (Crunchy)', 'img' => '🍞', 'cat' => 'Market'],
    27 => ['name' => 'Protein Bar Box', 'img' => '🏋️', 'cat' => 'Market'],
    28 => ['name' => 'Himalayan Pink Salt', 'img' => '🧂', 'cat' => 'Market'],
    29 => ['name' => 'Instant Gold Coffee', 'img' => '☕', 'cat' => 'Market'],
    30 => ['name' => 'Dried Mango Slices', 'img' => '🥭', 'cat' => 'Market'],

    
    31 => ['name' => 'Hyaluronic Acid Serum', 'img' => '🧪', 'cat' => 'Care'],
    32 => ['name' => 'Bamboo Toothbrush Set', 'img' => '🪥', 'cat' => 'Care'],
    33 => ['name' => 'Organic Shower Gel', 'img' => '🧼', 'cat' => 'Care'],
    34 => ['name' => 'Deep Repair Hair Mask', 'img' => '🎭', 'cat' => 'Care'],
    35 => ['name' => 'Sunscreen SPF 50+', 'img' => '☀️', 'cat' => 'Care'],
    36 => ['name' => 'Beard Grooming Oil', 'img' => '🧔', 'cat' => 'Care'],
    37 => ['name' => 'Vitamin C Face Wash', 'img' => '🍊', 'cat' => 'Care'],
    38 => ['name' => 'Electric Toothbrush', 'img' => '🪥', 'cat' => 'Care'],
    39 => ['name' => 'Aromatherapy Bath Salt', 'img' => '🛁', 'cat' => 'Care'],
    40 => ['name' => 'Moisturizing Hand Cream', 'img' => '🧴', 'cat' => 'Care']
];


$categories = array_unique(array_column($items, 'cat'));


$userItems = [];
if ($hasSubscription) {
    $res = $db->query("SELECT item_id FROM subscription_items WHERE subscription_id = ?", [$sub['id']])->fetchAll();
    foreach ($res as $row) {
        $userItems[] = $row['item_id'];
    }
}
$isBoxEmpty = empty($userItems);
?>

<div class="container py-5">

    <?php if (!$hasSubscription || ($hasSubscription && $isBoxEmpty)): ?>
        <script>
           
            <?php if ($hasSubscription && $isBoxEmpty): ?>
                window.onload = function() {
                    let currentPlanName = "<?php echo $sub['plan_name']; ?>";
                    let maxItems = 0;

                    
                    if (currentPlanName === 'Standard') maxItems = 3;
                    else if (currentPlanName === 'Gold') maxItems = 6;
                    else if (currentPlanName === 'VIP') maxItems = 10;

                    initBox(currentPlanName, maxItems);

                    
                    document.getElementById('step-1').style.display = 'none';
                };
            <?php endif; ?>
        </script>
        <div id="success-message-container" class="d-none animate-up mb-4">
            <div class="alert alert-success border-0 shadow-lg p-4 rounded-4 text-center">
                <div class="display-4 mb-3">🎉</div>
                <h3 class="fw-bold">Order Confirmed!</h3>
                <p class="mb-0">A confirmation email has been sent to <strong><?php echo $_SESSION['user']['email']; ?></strong>.</p>
                
                <p class="mt-2 fw-medium text-dark">Your order will be delivered within 3 business days.</p>

                <p class="small opacity-75">Redirecting to your box management...</p>
            </div>
        </div>

        <div id="step-1">
            <h2 class="text-center mb-5 fw-bold text-dark">Step 1: Choose Your Plan</h2>
            <div class="row g-4 justify-content-center">
                <?php foreach ($plans as $name => $info): ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 shadow border-0 plan-selector text-center p-4"
                            style="background: <?php echo $info['color']; ?>; transition: transform 0.3s; border-radius: 20px;"
                            onclick="initBox('<?php echo $name; ?>', <?php echo $info['items']; ?>, <?php echo $info['price']; ?>)">

                            
                            <div class="mb-2">
                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(0,0,0,0.05); color: <?php echo $info['text']; ?>; font-weight: 800; letter-spacing: 1px;">
                                    <?php echo strtoupper($name); ?>
                                </span>
                            </div>

                           
                            <h2 class="fw-bold mb-0" style="color: <?php echo $info['text']; ?>;">$<?php echo $info['price']; ?></h2>

                            <ul class="list-unstyled my-4 small fw-bold" style="color: <?php echo $info['text']; ?>; opacity: 0.8;">
                                <li class="mb-2">📦 <?php echo $info['items']; ?> Items</li>
                                <li>🔄 <?php echo is_numeric($info['swaps']) ? $info['swaps'] : 'Unlimited'; ?> Swaps</li>
                            </ul>

                            <button class="btn w-100 rounded-pill fw-bold btn-sm mt-auto shadow-sm"
                                style="background: white; color: <?php echo $info['text']; ?>; border: 1px solid rgba(0,0,0,0.1);">
                                Select Plan
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="step-2" class="mt-5 d-none animate-up">
            
            <div class="sticky-top bg-light py-3 border-bottom mb-4" style="top: 0; z-index: 1000;">
                <div class="d-flex justify-content-between align-items-center p-3 bg-white shadow-sm rounded-4 border-start border-primary border-4">
                    <div>
                        <h5 class="mb-0 fw-bold text-primary" id="display-plan">-</h5>
                    </div>
                    <div class="text-end">
                        <h5 class="mb-0 fw-bold text-success"><span id="count">0</span> / <span id="max">0</span> Items</h5>
                    </div>
                </div>

                
                <div class="container-fluid mt-3">
                    <div class="selected-tray-box">
                        <div class="selected-tray-header">
                            <span class="selected-tray-label">Your box</span>
                            <span class="selected-tray-counter" id="tray-counter">0 / <span id="max-label">0</span> selected</span>
                        </div>
                        <div id="selected-tray" class="selected-tray-pills">
                            <span id="tray-empty-hint" class="selected-tray-empty">Nothing selected yet — add items below</span>
                        </div>
                    </div>
                </div>

                
                <div class="container-fluid mt-2 overflow-auto">
                    <div class="d-flex gap-2 pb-2 category-scroll">
                        <button class="btn btn-dark rounded-pill px-4 cat-filter-btn active" onclick="filterItems('all', this)">All Items</button>
                        <?php foreach ($categories as $cat): ?>
                            <button class="btn btn-outline-dark rounded-pill px-4 cat-filter-btn" onclick="filterItems('<?php echo $cat; ?>', this)">
                                <?php echo $cat; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            
            <div class="row g-3" id="items-grid">
                <?php foreach ($items as $id => $item): ?>
                    <div class="col-6 col-md-4 col-lg-3 item-wrapper" data-category="<?php echo $item['cat']; ?>">
                        <div class="card p-3 border-0 shadow-sm item-card h-100" id="item-<?php echo $id; ?>">
                            <div class="display-5 text-center my-2"><?php echo $item['img']; ?></div>
                            <div class="text-center mb-1"><span class="badge bg-light text-muted fw-normal" style="font-size: 0.6rem;"><?php echo $item['cat']; ?></span></div>
                            <h6 class="fw-bold text-center small mb-3"><?php echo $item['name']; ?></h6>
                            <button class="btn btn-dark w-100 rounded-pill fw-bold btn-sm mt-auto" onclick="addToBox(<?php echo $id; ?>)">Add</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-5 mb-5">
                <button class="btn btn-primary btn-lg px-5 shadow-lg rounded-pill py-3 fw-bold" onclick="openCheckout()">Proceed to Checkout</button>
            </div>
        </div>

    <?php else: ?>
        <div id="manage-box" class="animate-up">

            
            <?php if ($sub['swaps_left'] <= 0): ?>
                <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center p-3 animate-up">
                    <div class="display-6 me-3">⚠️</div>
                    <div>
                        <h6 class="fw-bold mb-1">You've used all your swaps!</h6>
                        <p class="small mb-0 opacity-75">You can still enjoy your current items, but you can't change them until your next cycle.</p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-5 bg-white p-4 rounded-4 shadow-sm border">
                

                <div class="d-flex justify-content-between align-items-center mb-5 bg-white p-4 rounded-4 shadow-sm border">
                    <div>
                        <h2 class="fw-bold mb-0">My Custom Box</h2>
                        <span class="badge bg-primary rounded-pill mt-2">Plan: <?php echo $sub['plan_name']; ?></span>
                    </div>
                    <div class="text-end">
                        <h4 class="fw-bold text-warning mb-0">
                            <?php echo $sub['swaps_left'] > 100 ? 'Unlimited' : $sub['swaps_left']; ?>
                        </h4>
                        <small class="text-muted fw-bold">SWAPS REMAINING</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-7">
                        <h5 class="fw-bold mb-4">Items in my box</h5>
                        <div class="row g-3">
                            <?php foreach ($userItems as $itemId): ?>
                                <div class="col-md-6">
                                    <div class="card p-3 border-0 shadow-sm h-100 text-center">
                                        <div class="display-6 mb-2"><?php echo $items[$itemId]['img']; ?></div>
                                        <h6 class="fw-bold mb-3"><?php echo $items[$itemId]['name']; ?></h6>
                                        <button class="btn btn-outline-danger btn-sm rounded-pill fw-bold <?php echo $sub['swaps_left'] <= 0 ? 'disabled' : ''; ?>"
                                            onclick="startSwap(<?php echo $itemId; ?>)">
                                            <i class="bi bi-arrow-left-right me-1"></i> Swap
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div id="swap-options" class="col-lg-5 d-none">
                        <div class="card border-0 shadow-lg p-4 rounded-4 sticky-top" style="top: 20px;">
                            <h5 class="fw-bold mb-3">Replace with...</h5>
                            <p class="small text-muted mb-4">Select an item to swap with your current selection.</p>
                            <div class="row g-2 overflow-auto" style="max-height: 500px;">
                                <?php foreach ($items as $id => $item): ?>
                                    <?php if (!in_array($id, $userItems)): ?>
                                        <div class="col-6">
                                            <div class="card p-2 border text-center item-card" onclick="confirmSwap(<?php echo $id; ?>)">
                                                <div class="fs-4"><?php echo $item['img']; ?></div>
                                                <div class="small fw-bold text-truncate"><?php echo $item['name']; ?></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <button class="btn btn-light w-100 mt-3 rounded-pill" onclick="cancelSwap()">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        </div>

        <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                    <div class="modal-body p-5">
                        <h3 class="fw-bold mb-4 text-center">Checkout</h3>

                        <div class="mb-4">
                            <label class="fw-bold small text-muted mb-2">Payment Method</label>
                            <select class="form-select py-3 shadow-none border-light bg-light" id="paymentMethod" onchange="toggleVisa()">
                                <option value="cash">💵 Cash on Delivery</option>
                                <option value="visa">💳 Visa / Credit Card</option>
                            </select>
                        </div>

                        
                        <div class="mb-4 pt-3 border-top">
                            <label class="fw-bold small text-muted mb-2">Do you have a Referral Code?</label>
                            <div class="input-group">
                                <input type="text" id="referralCodeInput" class="form-control py-2 bg-light border-0" placeholder="Enter Code (Optional)" style="border-radius: 12px 0 0 12px;">
                                <button class="btn btn-outline-primary fw-bold" type="button" id="applyRefBtn" onclick="checkReferral()" style="border-radius: 0 12px 12px 0; font-size: 0.8rem;">Apply</button>
                            </div>
                            <div id="refFeedback" class="small mt-1" style="font-size: 0.75rem;"></div>
                        </div>

                        
                        <div id="priceSummary" class="mt-3 p-3 rounded-4 bg-light d-none">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">Original Price:</span>
                                <span class="text-muted small text-decoration-line-through" id="oldPrice">$0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 text-success">
                                <span class="fw-bold small">Discount (20%):</span>
                                <span class="fw-bold small" id="discountValue">-$0</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total to Pay:</span>
                                <span class="fw-bold h4 mb-0 text-primary" id="finalPrice">$0</span>
                            </div>
                        </div>

                        
                        <div id="visa-fields" class="d-none animate-up">
                            <div class="mb-3">
                                <input type="text" id="cardNum" class="form-control py-3 bg-light border-0" placeholder="Card Number (16 digits)" maxlength="16">
                            </div>
                            <div class="row g-2">
                                <div class="col-8">
                                    <input type="text" id="expiry" class="form-control py-3 bg-light border-0" placeholder="MM/YY" maxlength="5">
                                </div>
                                <div class="col-4">
                                    <input type="password" id="cvv" class="form-control py-3 bg-light border-0" placeholder="CVV" maxlength="3">
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-success btn-lg w-100 py-3 mt-4 fw-bold rounded-pill" onclick="validateAndFinish(event)">
                            Confirm Order
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let count = 0;
            let maxAllowed = 0;
            let selectedItems = [];
            let itemToReplace = null;
            let currentPlan = "";
            let currentPrice = 0;

            
            const itemMeta = {
                1:  { name: 'Wireless Headphones',   img: '🎧' },
                2:  { name: 'Smart Watch Pro',        img: '⌚' },
                3:  { name: 'Fast Charger 65W',       img: '🔌' },
                4:  { name: 'Bluetooth Speaker',      img: '🔊' },
                5:  { name: 'Power Bank 20,000mAh',   img: '🔋' },
                6:  { name: 'Mechanical Keyboard',    img: '⌨️' },
                7:  { name: 'Wireless Gaming Mouse',  img: '🖱️' },
                8:  { name: 'Screen Light Bar',       img: '💡' },
                9:  { name: 'USB-C Hub (7-in-1)',     img: '📑' },
                10: { name: 'Mini Security Camera',   img: '📹' },
                11: { name: 'Coffee Maker Pro',       img: '☕' },
                12: { name: 'Air Purifier Plus',      img: '🍃' },
                13: { name: 'Scented Candle Set',     img: '🕯️' },
                14: { name: 'Digital Kitchen Scale',  img: '⚖️' },
                15: { name: 'Electric Milk Frother',  img: '🌪️' },
                16: { name: 'Self-Watering Pot',      img: '🪴' },
                17: { name: 'Smart LED Bulb',         img: '🌈' },
                18: { name: 'Memory Foam Pillow',     img: '☁️' },
                19: { name: 'Ultrasonic Diffuser',    img: '🌫️' },
                20: { name: 'Magnetic Tool Kit',      img: '🧰' },
                21: { name: 'Organic Raw Honey',      img: '🍯' },
                22: { name: 'Extra Virgin Olive Oil', img: '🫒' },
                23: { name: 'Premium Mixed Nuts',     img: '🥜' },
                24: { name: 'Dark Chocolate',         img: '🍫' },
                25: { name: 'Japanese Matcha Powder', img: '🍵' },
                26: { name: 'Peanut Butter (Crunchy)',img: '🍞' },
                27: { name: 'Protein Bar Box',        img: '🏋️' },
                28: { name: 'Himalayan Pink Salt',    img: '🧂' },
                29: { name: 'Instant Gold Coffee',    img: '☕' },
                30: { name: 'Dried Mango Slices',     img: '🥭' },
                31: { name: 'Hyaluronic Acid Serum',  img: '🧪' },
                32: { name: 'Bamboo Toothbrush Set',  img: '🪥' },
                33: { name: 'Organic Shower Gel',     img: '🧼' },
                34: { name: 'Deep Repair Hair Mask',  img: '🎭' },
                35: { name: 'Sunscreen SPF 50+',      img: '☀️' },
                36: { name: 'Beard Grooming Oil',     img: '🧔' },
                37: { name: 'Vitamin C Face Wash',    img: '🍊' },
                38: { name: 'Electric Toothbrush',    img: '🪥' },
                39: { name: 'Aromatherapy Bath Salt', img: '🛁' },
                40: { name: 'Moisturizing Hand Cream',img: '🧴' },
            };

            
            function renderTray() {
                const tray    = document.getElementById('selected-tray');
                const counter = document.getElementById('tray-counter');
                const maxLbl  = document.getElementById('max-label');

                if (maxLbl) maxLbl.textContent = maxAllowed;
                if (counter) counter.textContent = selectedItems.length + ' / ' + maxAllowed + ' selected';

                if (selectedItems.length === 0) {
                    tray.innerHTML = '<span class="selected-tray-empty">Nothing selected yet — add items below</span>';
                    return;
                }

                tray.innerHTML = '';
                selectedItems.forEach(id => {
                    const meta = itemMeta[id];
                    if (!meta) return;
                    const chip = document.createElement('div');
                    chip.className = 'selected-chip';
                    chip.id = 'chip-' + id;
                    chip.innerHTML =
                        '<span class="chip-em">' + meta.img + '</span>' +
                        '<span class="chip-nm">' + meta.name + '</span>' +
                        '<button class="chip-x" onclick="removeFromBox(' + id + ')" title="Remove">&#x2715;</button>';
                    tray.appendChild(chip);
                });
            }

            function initBox(plan, max, price) {
                maxAllowed = max;
                currentPlan = plan;
                currentPrice = price;
                document.getElementById('display-plan').innerText = "Plan: " + plan;
                document.getElementById('max').innerText = max;
                renderTray(); 
                document.getElementById('step-1').classList.add('d-none');
                document.getElementById('step-2').classList.remove('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            function addToBox(id) {
                if (count < maxAllowed) {
                    count++;
                    selectedItems.push(id);
                    document.getElementById('count').innerText = count;

                   
                    let card = document.getElementById('item-' + id);
                    let btn  = card.querySelector('button');
                    btn.innerText = "✕ Remove";
                    btn.className = "btn btn-outline-danger w-100 rounded-pill fw-bold btn-sm mt-auto";
                    btn.setAttribute('onclick', 'removeFromBox(' + id + ')');
                    card.classList.add('item-selected');

                    renderTray();
                } else {
                    alert("Plan limit reached! Remove an item first.");
                }
            }

            function removeFromBox(id) {
                count--;
                selectedItems = selectedItems.filter(i => i !== id);
                document.getElementById('count').innerText = count;

                
                let card = document.getElementById('item-' + id);
                let btn  = card.querySelector('button');
                btn.innerText = "Add";
                btn.className = "btn btn-dark w-100 rounded-pill fw-bold btn-sm mt-auto";
                btn.setAttribute('onclick', 'addToBox(' + id + ')');
                card.classList.remove('item-selected');

                renderTray();
            }

            
            function startSwap(oldId) {
                itemToReplace = oldId;
                document.getElementById('swap-options').classList.remove('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            function cancelSwap() {
                itemToReplace = null;
                document.getElementById('swap-options').classList.add('d-none');
            }

            function confirmSwap(newId) {
                let formData = new FormData();
                formData.append('old_id', itemToReplace);
                formData.append('new_id', newId);

                document.getElementById('swap-options').style.opacity = "0.5";
                document.getElementById('swap-options').style.pointerEvents = "none";

                fetch('api/swap.php', { method: 'POST', body: formData })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert("Error: " + data.message);
                            document.getElementById('swap-options').style.opacity = "1";
                            document.getElementById('swap-options').style.pointerEvents = "auto";
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("Server connection failed.");
                    });
            }

           
            function openCheckout() {
                if (count < maxAllowed) {
                    alert(`Please select all ${maxAllowed} items for your plan!`);
                    return;
                }
                new bootstrap.Modal(document.getElementById('paymentModal')).show();
            }

            function validateAndFinish(event) {
                if (event) event.preventDefault();

                let btn = event.currentTarget;
                let originalText = btn.innerText;
                let method = document.getElementById('paymentMethod').value;

                if (method === 'visa') {
                    let cardNum = document.getElementById('cardNum').value.trim();
                    let expiry  = document.getElementById('expiry').value.trim();
                    let cvv     = document.getElementById('cvv').value.trim();

                    if (!cardNum || !expiry || !cvv) {
                        alert("⚠️ Please fill in all card details!");
                        return;
                    }
                    if (cardNum.length !== 16 || isNaN(cardNum)) {
                        alert("⚠️ Invalid Card Number! Must be 16 digits.");
                        return;
                    }
                    let expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
                    if (!expiryRegex.test(expiry)) {
                        alert("⚠️ Invalid Expiry Date! Use MM/YY format (e.g., 12/26).");
                        return;
                    }
                    if (cvv.length !== 3 || isNaN(cvv)) {
                        alert("⚠️ Invalid CVV! Must be 3 digits.");
                        return;
                    }
                }

                btn.disabled = true;
                btn.innerText = "Processing... Please wait";

                let orderData = new FormData();
                orderData.append('plan_name', currentPlan);
                orderData.append('referral_code', document.getElementById('referralCodeInput').value.trim());

                let swaps = 1;
                if (currentPlan === 'Gold') swaps = 3;
                if (currentPlan === 'VIP') swaps = 'Unlimited';

                orderData.append('swaps', swaps);
                selectedItems.forEach(id => orderData.append('items[]', id));

                fetch('process_order.php', { method: 'POST', body: orderData })
                    .then(response => {
                        if (!response.ok) throw new Error('HTTP error! status: ' + response.status);
                        return response.text();
                    })
                    .then(text => {
                        try {
                            const data = JSON.parse(text);
                            if (data.success) {
                                bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
                                document.getElementById('step-2').classList.add('d-none');
                                document.getElementById('success-message-container').classList.remove('d-none');
                                setTimeout(() => { location.reload(); }, 3000);
                            } else {
                                alert("Error: " + data.message);
                                btn.disabled = false;
                                btn.innerText = originalText;
                            }
                        } catch (e) {
                            console.error("Server sent non-JSON response:", text);
                            alert("Server returned an invalid response. Check console for details.");
                            btn.disabled = false;
                            btn.innerText = originalText;
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert("Connection failed: " + error.message);
                        btn.disabled = false;
                        btn.innerText = originalText;
                    });
            }

            function toggleVisa() {
                let method = document.getElementById('paymentMethod').value;
                document.getElementById('visa-fields').classList.toggle('d-none', method !== 'visa');
            }

            
            document.getElementById('expiry').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 2) {
                    e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
                } else {
                    e.target.value = value;
                }
            });

          
            function filterItems(category, btn) {
                document.querySelectorAll('.cat-filter-btn').forEach(b => {
                    b.classList.remove('active', 'btn-dark');
                    b.classList.add('btn-outline-dark');
                });
                btn.classList.remove('btn-outline-dark');
                btn.classList.add('active', 'btn-dark');

                let items = document.querySelectorAll('.item-wrapper');
                items.forEach(item => {
                    if (category === 'all' || item.getAttribute('data-category') === category) {
                        item.style.display = 'block';
                        item.classList.add('animate-up');
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            
            function checkReferral() {
                let code     = document.getElementById('referralCodeInput').value.trim();
                let feedback = document.getElementById('refFeedback');
                let btn      = document.getElementById('applyRefBtn');

                if (!code) {
                    feedback.innerHTML = "<span class='text-warning'>Please enter a code first.</span>";
                    return;
                }

                btn.disabled = true;
                btn.innerText = "Checking...";

                fetch('api/check_ref.php?code=' + code)
                    .then(response => response.json())
                    .then(data => {
                        if (data.valid) {
                            let discountPercent = 0.20;
                            let discountAmount  = currentPrice * discountPercent;
                            let finalAmount     = currentPrice - discountAmount;

                            feedback.innerHTML = "<span class='text-success fw-bold'>✅ Success! 20% Discount Applied.</span>";

                            document.getElementById('oldPrice').innerText      = "$" + currentPrice;
                            document.getElementById('discountValue').innerText  = "-$" + discountAmount.toFixed(2);
                            document.getElementById('finalPrice').innerText     = "$" + finalAmount.toFixed(2);
                            document.getElementById('priceSummary').classList.remove('d-none');

                            document.getElementById('referralCodeInput').classList.add('is-valid');
                            document.getElementById('referralCodeInput').readOnly = true;
                            btn.innerHTML = "Applied";
                        } else {
                            feedback.innerHTML = "<span class='text-danger'>❌ " + data.message + "</span>";
                            btn.disabled = false;
                            btn.innerText = "Apply";
                        }
                    })
                    .catch(err => {
                        feedback.innerHTML = "<span class='text-primary'>Code entered. (20% Discount Demo)</span>";

                        let demoDiscount = currentPrice * 0.20;
                        document.getElementById('oldPrice').innerText     = "$" + currentPrice;
                        document.getElementById('discountValue').innerText = "-$" + demoDiscount.toFixed(2);
                        document.getElementById('finalPrice').innerText    = "$" + (currentPrice - demoDiscount).toFixed(2);
                        document.getElementById('priceSummary').classList.remove('d-none');

                        btn.disabled = false;
                        btn.innerText = "Apply";
                    });
            }
        </script>

        <style>
            
            .plan-selector {
                cursor: pointer;
                position: relative;
                overflow: hidden;
            }
            .plan-selector:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
            }
            .plan-selector::after {
                content: "";
                position: absolute;
                top: -50%; left: -50%;
                width: 200%; height: 200%;
                background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
                transform: rotate(45deg);
                transition: 0.5s;
            }
            .plan-selector:hover::after { left: 100%; top: 100%; }

            
            .item-card {
                border-radius: 18px;
                border: 1px solid #eee;
                transition: border-color 0.2s, opacity 0.25s, box-shadow 0.2s;
                cursor: pointer;
            }
            .item-card:hover { border-color: #0d6efd; }
            .item-card.item-selected {
                opacity: 0.72;
                border-color: #dc3545 !important;
                box-shadow: 0 0 0 2px rgba(220,53,69,0.18);
            }

            
            .selected-tray-box {
                background: #fff;
                border: 1px solid #e9ecef;
                border-radius: 14px;
                padding: 10px 14px;
            }
            .selected-tray-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 8px;
            }
            .selected-tray-label {
                font-size: 12px;
                font-weight: 600;
                color: #6c757d;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .selected-tray-counter {
                font-size: 12px;
                font-weight: 600;
                color: #6c757d;
                background: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 99px;
                padding: 2px 10px;
            }
            .selected-tray-pills {
                display: flex;
                flex-wrap: wrap;
                gap: 7px;
                min-height: 32px;
                align-items: center;
            }
            .selected-tray-empty {
                font-size: 13px;
                color: #adb5bd;
                font-style: italic;
            }
            .selected-chip {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 8px 4px 11px;
                border-radius: 99px;
                border: 1px solid #dee2e6;
                background: #f8f9fa;
                font-size: 13px;
                font-weight: 500;
                color: #212529;
                animation: chipIn 0.18s ease-out;
            }
            .selected-chip .chip-em { font-size: 14px; line-height: 1; }
            .selected-chip .chip-nm {
                max-width: 100px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .selected-chip .chip-x {
                display: flex; align-items: center; justify-content: center;
                width: 17px; height: 17px;
                border-radius: 50%;
                border: none; background: none;
                cursor: pointer;
                font-size: 11px;
                color: #adb5bd;
                flex-shrink: 0;
                transition: background 0.12s, color 0.12s;
            }
            .selected-chip .chip-x:hover {
                background: #ffe3e3;
                color: #dc3545;
            }

           
            .animate-up { animation: fadeInUp 0.5s ease-out; }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(30px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @keyframes chipIn {
                from { opacity: 0; transform: scale(0.8); }
                to   { opacity: 1; transform: scale(1); }
            }

           
            .bg-light { background-color: #f8f9fa !important; }
            .category-scroll {
                flex-wrap: nowrap;
                scrollbar-width: none;
            }
            .category-scroll::-webkit-scrollbar { display: none; }
            .cat-filter-btn {
                white-space: nowrap;
                font-size: 0.85rem;
                font-weight: 600;
                transition: 0.3s;
            }
            .item-wrapper { transition: transform 0.4s ease; }
            .badge.bg-light {
                letter-spacing: 1px;
                text-transform: uppercase;
            }
        </style>

<?php include 'includes/footer.php'; ?>