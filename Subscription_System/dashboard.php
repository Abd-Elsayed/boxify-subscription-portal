<?php 
session_start(); 
require_once 'classes/Database.php'; 
include 'includes/header.php'; 

if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$user_id = $_SESSION['user']['id'];


$query = "SELECT * FROM subscriptions WHERE user_id = ? LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute([$user_id]);
$subscription = $stmt->fetch(PDO::FETCH_ASSOC);


$hasItems = false;
if ($subscription) {
    $itemCheckQuery = "SELECT COUNT(*) FROM subscription_items WHERE subscription_id = ?";
    $itemStmt = $db->prepare($itemCheckQuery);
    $itemStmt->execute([$subscription['id']]);
    $hasItems = $itemStmt->fetchColumn() > 0;
}


$referral_code = $_SESSION['user']['referral_code'] ?? 'N/A';

if ($referral_code === 'N/A') {
    $refQuery = "SELECT referral_code FROM users WHERE id = ?";
    $refStmt = $db->prepare($refQuery);
    $refStmt->execute([$user_id]);
    $referral_code = $refStmt->fetchColumn() ?: 'N/A';
}
?>

<div class="container-fluid py-5 bg-light" style="min-height: 90vh;">
    <div class="container">
        <div class="row g-4">
           
            <div class="col-lg-3">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="bg-primary p-4 text-center">
            
            <h5 class="text-white fw-bold mb-1 text-truncate">
                <?php echo htmlspecialchars($_SESSION['user']['full_name'] ?? 'User'); ?>
            </h5>
            
            
            <div class="mt-2">
                <small class="text-white-50 d-block mb-1" style="font-size: 0.75rem;">Your Referral Code</small>
                <code class="bg-white text-primary px-3 py-1 rounded-pill fw-bold shadow-sm d-inline-block">
                    <?php echo htmlspecialchars($referral_code); ?>
                </code>
            </div>
        </div>

        <div class="list-group list-group-flush p-2">
            <a href="dashboard.php" class="list-group-item list-group-item-action border-0 active rounded-3 mb-2">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a href="subscribe.php" class="list-group-item list-group-item-action border-0 rounded-3 mb-2">
                <i class="bi bi-box-seam me-2"></i> My Subscription Box
            </a>
            <a href="profile.php" class="list-group-item list-group-item-action border-0 rounded-3 mb-2">
                <i class="bi bi-person-circle me-2"></i> My Profile
            </a>
            <hr class="my-2">
            <a href="logout.php" class="list-group-item list-group-item-action border-0 rounded-3 text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </div>
    </div>
</div>

            
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <h2 class="fw-bold mb-0">Overview</h2>
                    <span class="badge bg-white text-dark border p-2 px-3 shadow-sm rounded-3">
                        <i class="bi bi-clock me-2 text-primary"></i><?php echo date('D, d M Y'); ?>
                    </span>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <?php if (!$subscription): ?>
                        <div class="p-5 text-center bg-white">
                            <div class="mb-4">
                                <i class="bi bi-box-seam display-1 text-light"></i>
                            </div>
                            <h3 class="fw-bold">No Active Box Subscription</h3>
                            <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                                It looks like you haven't picked a box yet. Choose a plan and customize your items now!
                            </p>
                            <a href="subscribe.php" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm fw-bold">
                                <i class="bi bi-plus-lg me-2"></i>Start New Subscription
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="row g-0">
                            <div class="col-md-4 bg-primary p-5 text-white d-flex flex-column justify-content-center text-center">
                                <i class="bi bi-stars display-4 mb-2"></i>
                                <h4 class="fw-bold mb-0 text-uppercase"><?php echo htmlspecialchars($subscription['plan_name']); ?></h4>
                                <div class="mt-3">
                                    <span class="badge bg-white text-primary rounded-pill px-3 py-2">
                                        <i class="bi bi-check-circle-fill me-1"></i> Active Plan
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8 p-4 bg-white d-flex flex-column justify-content-center">
                                
                                <?php if ($hasItems): ?>
                                   
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="fw-bold mb-0">Delivery Status</h5>
                                        <span class="text-warning fw-bold small">
                                            <i class="bi bi-arrow-left-right me-1"></i> 
                                            <?php echo $subscription['swaps_left']; ?> Swaps Left
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-4">We are preparing your curated box. You can still swap items before it ships!</p>
                                    
                                    <div class="progress mb-2" style="height: 10px; border-radius: 5px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 35%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted fw-medium" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                        <span class="text-success text-uppercase">Ordered</span>
                                        <span class="text-uppercase">Packing</span>
                                        <span class="text-uppercase">Shipped</span>
                                    </div>
                                <?php else: ?>
                                    
                                    <div class="text-center py-3">
                                        <i class="bi bi-cart-x display-6 text-warning mb-2"></i>
                                        <h5 class="fw-bold">Your Box is Empty</h5>
                                        <p class="text-muted small">You've cleared your items. Add new ones to start delivery!</p>
                                        <a href="subscribe.php" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">
                                            <i class="bi bi-plus-circle me-1"></i> Pick New Items
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="mt-4 d-flex gap-2 flex-wrap border-top pt-3">
                                    <a href="subscribe.php" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">
                                        <i class="bi bi-pencil-square me-1"></i> Manage / Swap
                                    </a>
                                    <button onclick="confirmAction('cancel_box')" class="btn btn-outline-warning btn-sm rounded-pill px-4 fw-bold">
                                        <i class="bi bi-trash me-1"></i> Clear Box Items
                                    </button>
                                    <button onclick="confirmAction('cancel_sub')" class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold">
                                        <i class="bi bi-x-circle me-1"></i> Cancel Subscription
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

               
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 p-3 text-center bg-white h-100">
                            <div class="text-primary mb-2"><i class="bi bi-bag-check fs-3"></i></div>
                           
                            <div class="fw-bold h5 mb-0"><?php echo ($subscription && $hasItems) ? '1' : '0'; ?></div>
                            <div class="text-muted small">Active Orders</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 p-3 text-center bg-white h-100">
                            <div class="text-warning mb-2"><i class="bi bi-arrow-repeat fs-3"></i></div>
                            <div class="fw-bold h5 mb-0"><?php echo $subscription['swaps_left'] ?? 0; ?></div>
                            <div class="text-muted small">Swaps Avail.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmAction(type) {
    let msg = type === 'cancel_sub' 
        ? "Are you sure you want to PERMANENTLY cancel your subscription?" 
        : "Clear all items from your box? (Plan will remain active)";

    if (confirm(msg)) {
        let formData = new FormData();
        formData.append('action', type);

        fetch('api/manage_subscription.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); 
            } else {
                alert("Error: " + data.message);
            }
        });
    }
}
</script>
<?php include 'includes/footer.php'; ?>