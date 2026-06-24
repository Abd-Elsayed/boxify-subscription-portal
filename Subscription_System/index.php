<?php 

session_start(); 


include 'includes/header.php'; 
?>


<div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
    <div class="container-fluid py-5 text-center">
        <h1 class="display-4 fw-bold text-primary">📦 Welcome to Boxify</h1>
        <p class="col-md-12 fs-5 text-muted">
            The next generation of subscription box services. 
            Experience a system built with cutting-edge <b>OOP Technologies</b>, 
            smart referral logic, and personalized box management.
        </p>
        
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
            <?php if(!isset($_SESSION['user'])): ?>
                
                <a href="register.php" class="btn btn-primary btn-lg px-4 gap-3">Get Started</a>
                <a href="login.php" class="btn btn-outline-secondary btn-lg px-4">Sign In</a>
            <?php else: ?>
               
                <a href="dashboard.php" class="btn btn-success btn-lg px-4">Go to My Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
    <div class="feature col text-center">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white fs-2 mb-3 p-3 rounded-circle shadow-sm" style="width: 80px; height: 80px;">
            💎
        </div>
        <h3 class="fs-4 fw-bold">Tiered Subscriptions</h3>
        <p class="text-muted">Choose between Standard, Gold, or VIP tiers. Our system dynamically adjusts content based on your selection.</p>
    </div>
    
    <div class="feature col text-center">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-success bg-gradient text-white fs-2 mb-3 p-3 rounded-circle shadow-sm" style="width: 80px; height: 80px;">
            🚀
        </div>
        <h3 class="fs-4 fw-bold">Referral Rewards</h3>
        <p class="text-muted">Invite friends using your unique code. Our back-end logic automatically calculates discounts for your next box.</p>
    </div>
    
    <div class="feature col text-center">
        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-dark bg-gradient text-white fs-2 mb-3 p-3 rounded-circle shadow-sm" style="width: 80px; height: 80px;">
            🛡️
        </div>
        <h3 class="fs-4 fw-bold">Secure Architecture</h3>
        <p class="text-muted">Built with PDO Prepared Statements and encrypted passwords to ensure professional-grade data protection.</p>
    </div>
</div>


<hr class="my-5">
<div class="row text-center mb-5 py-4 bg-light rounded shadow-sm">
    <div class="col-md-4">
        <h2 class="fw-bold text-primary">1,200+</h2>
        <p class="text-muted fw-bold">Active Members</p>
    </div>
    <div class="col-md-4 border-start border-end">
        <h2 class="fw-bold text-primary">5,000+</h2>
        <p class="text-muted fw-bold">Boxes Delivered</p>
    </div>
    <div class="col-md-4">
        <h2 class="fw-bold text-primary">99.9%</h2>
        <p class="text-muted fw-bold">System Uptime</p>
    </div>
</div>

<?php 

include 'includes/footer.php'; 
?>