<?php 
session_start();
require_once 'classes/Database.php';
include 'includes/header.php';

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    
    $db = (new Database())->getConnection();
    
    
    $check = $db->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    
    if ($check->fetch()) {
        $update = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
        if ($update->execute([$new_pass, $email])) {
            $message = "<div class='alert alert-success rounded-pill px-4'>Password Reset Successfully! <a href='login.php'>Login now</a></div>";
        }
    } else {
        $message = "<div class='alert alert-danger rounded-pill px-4'>Email not found in our records.</div>";
    }
}
?>

<div class="container py-5">
    <div class="card p-4 shadow-sm mx-auto border-0 rounded-4" style="max-width: 400px;">
        <div class="text-center mb-4">
            <i class="bi bi-shield-lock display-4 text-warning"></i>
            <h3 class="fw-bold mt-2">Reset Password</h3>
            <p class="text-muted small">Enter your email to set a new password</p>
        </div>

        <?php echo $message; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="small fw-bold text-muted">Confirm Your Email</label>
                <input type="email" name="email" class="form-control rounded-pill border-light bg-light shadow-none" placeholder="Your registered email" required>
            </div>
            <div class="mb-4">
                <label class="small fw-bold text-muted">New Password</label>
                <input type="password" name="new_pass" class="form-control rounded-pill border-light bg-light shadow-none" placeholder="Enter new password" required>
            </div>
            <button class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm mb-3">Update Password</button>
            <div class="text-center">
                <a href="login.php" class="text-decoration-none small text-muted">Back to Login</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>