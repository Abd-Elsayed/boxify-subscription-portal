<?php
session_start();
require_once '../classes/Database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$user_id = $_SESSION['user']['id'];


$old_item_id = $_POST['old_id'];
$new_item_id = $_POST['new_id'];

try {
   
    $sub = $conn->prepare("SELECT id, swaps_left FROM subscriptions WHERE user_id = ? LIMIT 1");
    $sub->execute([$user_id]);
    $subscription = $sub->fetch();

    if (!$subscription || $subscription['swaps_left'] <= 0) {
        throw new Exception("No swaps remaining!");
    }

    $conn->beginTransaction();

    
    $updateItem = $conn->prepare("UPDATE subscription_items SET item_id = ? WHERE subscription_id = ? AND item_id = ? LIMIT 1");
    $updateItem->execute([$new_item_id, $subscription['id'], $old_item_id]);

    
    if ($subscription['swaps_left'] < 900) {
        $updateSwaps = $conn->prepare("UPDATE subscriptions SET swaps_left = swaps_left - 1 WHERE id = ?");
        $updateSwaps->execute([$subscription['id']]);
    }

    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    if ($conn->inTransaction()) $conn->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}