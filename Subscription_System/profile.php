<?php 
session_start(); 
require_once 'classes/Database.php'; 
include 'includes/header.php'; 

if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit();
}

$db = (new Database())->getConnection();
$user_id = $_SESSION['user']['id'];
$message = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $phone   = $_POST['phone'];
    $address = $_POST['address'];
    $new_password = $_POST['password']; 

    try {
        $db->beginTransaction();

        
        $updateStmt = $db->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        $updateStmt->execute([$name, $email, $phone, $address, $user_id]);

        
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $pwStmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $pwStmt->execute([$hashed_password, $user_id]);
        }

        $db->commit();
        
        $_SESSION['user']['full_name'] = $name;
        $message = "<div class='alert alert-success rounded-pill shadow-sm px-4'><i class='bi bi-check-circle-fill me-2'></i>Profile and Password Updated Successfully</div>";
    } catch (PDOException $e) {
        $db->rollBack();
        $message = "<div class='alert alert-danger rounded-pill shadow-sm px-4'>Error: " . $e->getMessage() . "</div>";
    }
}


$userStmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$userStmt->execute([$user_id]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

$realName    = $user['name'] ?? $user['username'] ?? $user['full_name'] ?? "User";
$realEmail   = $user['email'] ?? "No Email";
$realPhone   = $user['phone'] ?? "No Phone";
$realAddress = $user['address'] ?? "No Address";
?>

<div class="container-fluid py-5 bg-light" style="min-height: 90vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <?php echo $message; ?>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="p-5 text-center bg-white border-bottom">
                        <div class="mb-3">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($realName); ?>&background=0d6efd&color=fff&size=128&bold=true" 
                                 class="rounded-circle shadow-sm" style="border: 4px solid #fff;">
                        </div>
                        <h3 class="fw-bold mb-1 text-dark"><?php echo htmlspecialchars($realName); ?></h3>
                        <p class="text-muted mb-0">Personal Profile & Contact Info</p>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="text-muted small fw-bold mb-2 d-block text-uppercase">Email Address</label>
                                <div class="p-3 rounded-3 bg-light d-flex align-items-center">
                                    <i class="bi bi-envelope text-primary me-3 fs-5"></i>
                                    <span class="fw-bold"><?php echo htmlspecialchars($realEmail); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small fw-bold mb-2 d-block text-uppercase">Phone Number</label>
                                <div class="p-3 rounded-3 bg-light d-flex align-items-center">
                                    <i class="bi bi-telephone text-primary me-3 fs-5"></i>
                                    <span class="fw-bold"><?php echo htmlspecialchars($realPhone); ?></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="text-muted small fw-bold mb-2 d-block text-uppercase">Shipping Address</label>
                                <div class="p-3 rounded-3 bg-light d-flex align-items-center">
                                    <i class="bi bi-geo-alt text-primary me-3 fs-5"></i>
                                    <span class="fw-bold"><?php echo htmlspecialchars($realAddress); ?></span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="bi bi-pencil-square me-2"></i> Edit Profile
                            </button>
                            <a href="logout.php" class="btn btn-outline-danger px-4 rounded-pill fw-bold">Logout</a>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="dashboard.php" class="text-muted text-decoration-none small"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold" id="editModalLabel">Edit My Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body p-4 pt-0">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control bg-light border-0 shadow-none py-2" value="<?php echo htmlspecialchars($realName); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control bg-light border-0 shadow-none py-2" value="<?php echo htmlspecialchars($realEmail); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-primary">New Password (Leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control bg-white border shadow-none py-2" placeholder="Enter new password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control bg-light border-0 shadow-none py-2" value="<?php echo htmlspecialchars($realPhone); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Shipping Address</label>
                        <textarea name="address" class="form-control bg-light border-0 shadow-none py-2" rows="3" required><?php echo htmlspecialchars($realAddress); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_profile" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>