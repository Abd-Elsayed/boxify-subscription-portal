<?php 
session_start(); 
require_once 'classes/Database.php'; 
require_once 'classes/User.php';
include 'includes/header.php';

if($_POST) {
    $user = (new User((new Database())->getConnection()))->login($_POST['email'], $_POST['pass']);
    if($user) { 
        $_SESSION['user'] = $user; 
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "<div class='alert alert-danger text-center rounded-pill'>Login Failed! Check email or password.</div>";
    }
}
?>
<div class="container py-5">
    <div class="card p-4 shadow-sm mx-auto border-0 rounded-4" style="max-width: 400px;">
        <div class="text-center mb-4">
            <i class="bi bi-person-lock display-4 text-primary"></i>
            <h3 class="fw-bold mt-2">Login</h3>
        </div>
        <form method="POST">
            <div class="mb-3">
                <label class="small fw-bold text-muted">Email Address</label>
                <input type="email" name="email" class="form-control rounded-pill border-light bg-light shadow-none" placeholder="name@example.com" required>
            </div>
            <div class="mb-3">
                <label class="small fw-bold text-muted">Password</label>
                <input type="password" name="pass" class="form-control rounded-pill border-light bg-light shadow-none" placeholder="••••••••" required>
            </div>
            <button class="btn btn-success w-100 rounded-pill py-2 fw-bold shadow-sm mb-3">Sign In</button>
            
            <div class="text-center">
                <a href="forgot_password.php" class="text-decoration-none small text-muted">Forgot Password?</a>
            </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>