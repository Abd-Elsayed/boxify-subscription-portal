<?php
class Subscription {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    
    public function calculateFinalPrice($tier, $user_id) {
        $prices = ['Standard' => 20, 'Gold' => 50, 'VIP' => 100];
        $basePrice = $prices[$tier];
        
        
        $stmt = $this->conn->prepare("SELECT credits FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $credits = $stmt->fetchColumn();
        
        return ($basePrice - ($credits * 0.1) > 0) ? $basePrice - ($credits * 0.1) : 0;
    }

    public function subscribe($user_id, $tier) {
        $stmt = $this->conn->prepare("INSERT INTO subscriptions (user_id, tier, start_date) VALUES (?, ?, CURDATE())");
        return $stmt->execute([$user_id, $tier]);
    }
}
?>