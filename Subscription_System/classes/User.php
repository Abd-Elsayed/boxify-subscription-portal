<?php
class User {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function register($name, $email, $pass, $phone, $address) {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $ref = strtoupper(substr(md5(uniqid()), 0, 6));
        $stmt = $this->conn->prepare("INSERT INTO users (full_name, email, password, phone, address, referral_code) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hash, $phone, $address, $ref]);
    }

    public function login($email, $pass) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($user && password_verify($pass, $user['password'])) ? $user : false;
    }
}
?>