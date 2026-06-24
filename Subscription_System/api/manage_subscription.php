<?php
session_start();
require_once '../classes/Database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$database = new Database();
$db = $database->getConnection();
$user_id = $_SESSION['user']['id'];
$action = $_POST['action'] ?? '';
$msg = "No action performed."; 
try {
    $stmt = $db->prepare("SELECT id FROM subscriptions WHERE user_id = ? LIMIT 1");
    $stmt->execute([$user_id]);
    $sub = $stmt->fetch();

    if (!$sub) throw new Exception("No active subscription found.");

    if ($action === 'cancel_box') {
        $del = $db->prepare("DELETE FROM subscription_items WHERE subscription_id = ?");
        $del->execute([$sub['id']]);

        $plan_stmt = $db->prepare("SELECT plan_name FROM subscriptions WHERE id = ?");
        $plan_stmt->execute([$sub['id']]);
        $plan = $plan_stmt->fetchColumn();

        $reset_swaps = 1; 
        if ($plan === 'Gold') $reset_swaps = 3;
        if ($plan === 'VIP') $reset_swaps = 'Unlimited';

        $update = $db->prepare("UPDATE subscriptions SET swaps_left = ? WHERE id = ?");
        $update->execute([$reset_swaps, $sub['id']]);

        $msg = "Box items cleared and swaps reset!";
    }
    elseif ($action === 'cancel_sub') {
        $delItems = $db->prepare("DELETE FROM subscription_items WHERE subscription_id = ?");
        $delItems->execute([$sub['id']]);

        $delSub = $db->prepare("DELETE FROM subscriptions WHERE id = ?");
        $delSub->execute([$sub['id']]);
        $msg = "Subscription cancelled!";
    } else {
        
        throw new Exception("Invalid action requested.");
    }

    echo json_encode(['success' => true, 'message' => $msg]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

