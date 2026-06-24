<?php

ob_start(); 

session_start();
require_once 'classes/Database.php';


header('Content-Type: application/json');


if (!isset($_SESSION['user'])) {
    ob_clean(); 
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user']['id'];
$db = new Database();

$plan_name = $_POST['plan_name'] ?? '';
$swaps = $_POST['swaps'] ?? 0;
$selected_items = $_POST['items'] ?? [];


$referral_code = $_POST['referral_code'] ?? null; 

if (empty($plan_name) || empty($selected_items)) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Missing data']);
    exit();
}

try {
  
    $stmt = $db->query("SELECT id FROM subscriptions WHERE user_id = ?", [$user_id]);
    $existingSub = $stmt->fetch();

    if ($existingSub) {
        $subscription_id = $existingSub['id'];
        
        $db->query("UPDATE subscriptions SET plan_name = ?, swaps_left = ?, referral_code = ? WHERE id = ?", 
                  [$plan_name, $swaps, $referral_code, $subscription_id]);
        
        $db->query("DELETE FROM subscription_items WHERE subscription_id = ?", [$subscription_id]);
    } else {
        
        $db->query("INSERT INTO subscriptions (user_id, plan_name, swaps_left, referral_code) VALUES (?, ?, ?, ?)", 
                  [$user_id, $plan_name, $swaps, $referral_code]);
        
        $subscription_id = $db->getLastInsertId(); 
    }

   
    foreach ($selected_items as $item_id) {
        $db->query("INSERT INTO subscription_items (subscription_id, item_id) VALUES (?, ?)", 
                  [$subscription_id, $item_id]);
    }

   
    ob_clean(); 
    echo json_encode(['success' => true, 'message' => 'Order processed successfully']);
    exit();

} catch (Exception $e) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
    exit();
}