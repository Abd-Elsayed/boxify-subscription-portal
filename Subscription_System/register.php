<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/User.php';


$database = new Database();
$db = $database->getConnection();


$user = new User($db); 

$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? ''; 
    $phone  = $_POST['phone'] ?? '';
    $address  = $_POST['address'] ?? '';

    
    if (!empty($name) && !empty($email) && !empty($password)) {
        
        
        if ($user->register($name, $email, $password, $phone, $address)) {
            
            header("Location: login.php?msg=success");
            exit();
        } else {
            $message = "Registration failed. This email address is already in use";
            $messageType = "danger";
        }
    } else {
        $message = "Please fill in all required fields.";
        $messageType = "warning";
    }
}

include 'includes/header.php'; 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
           
            <div class="card border-0 shadow-lg p-4" style="border-radius: 25px;">
                <div class="text-center mb-4">
                    <div class="bg-primary d-inline-block p-3 rounded-circle mb-3 shadow-sm">
                        <i class="bi bi-person-plus-fill text-white fs-3"></i>
                    </div>
                    <h2 class="fw-bold">Create Account</h2>
                    <p class="text-muted small">Join us and start your subscription today</p>
                </div>

                
                <?php if($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?> small fw-bold mb-4 rounded-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="name" class="form-control py-2 shadow-none bg-light border-0" placeholder="John Doe" required>
                        </div>
                    </div>
                    
                   
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control py-2 shadow-none bg-light border-0" placeholder="name@example.com" required>
                        </div>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control py-2 shadow-none bg-light border-0" placeholder="••••••••" required>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">Shipping Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-muted"></i></span>
                            <input type="text" name="address" class="form-control py-2 shadow-none bg-light border-0" placeholder="City, Street, Building" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Phone Number</label>
                        <div class="input-group">
                             <span class="input-group-text bg-light border-0"><i class="bi bi-telephone text-muted"></i></span>
                             <input type="text" name="phone" class="form-control py-2 shadow-none bg-light border-0" placeholder="01xxxxxxxxx" required>
                        </div>
                    </div>

                    
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm mb-3">
                        Sign Up Now
                    </button>
                    
                    <div class="text-center">
                        <p class="small text-muted mb-0">Already have an account? <a href="login.php" class="text-primary fw-bold text-decoration-none">Login here</a></p>
                    </div>
                </form>
            </div>
            
            <div class="text-center mt-4">
                <a href="index.php" class="text-muted small text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Home</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>