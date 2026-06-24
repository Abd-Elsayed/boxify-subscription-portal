<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Boxify | Subscription System</title>
</head>
<body>

<nav class="navbar navbar-expand-lg py-3">
    <div class="container">
        
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <span class="fs-3 me-2">📦</span>
            <span class="fw-bold tracking-tight">BOXIFY</span>
        </a>

        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

      
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link px-3 fw-semibold" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-semibold" href="subscribe.php">Plans</a></li>
            </ul>

            
            <div class="d-flex align-items-center gap-2">
                <?php if(isset($_SESSION['user'])): ?>
                    
                    <a href="dashboard.php" class="btn btn-light rounded-pill px-4 fw-bold">Dashboard</a>
                    <a href="logout.php" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">Logout</a>
                <?php else: ?>
                    
                    <a href="login.php" class="btn btn-outline-primary rounded-pill px-4 fw-bold border-2">Login</a>
                    <a href="register.php" class="btn btn-primary rounded-pill px-4 fw-bold shadow">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4">