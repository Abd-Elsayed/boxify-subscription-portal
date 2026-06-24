</div> 

<footer class="bg-white pt-5 pb-4 mt-5 border-top">
    <div class="container">
        <div class="row text-md-start text-center">
            
            
            <div class="col-md-4 col-lg-4 col-xl-3 mx-auto mt-3">
                <h5 class="fw-bold mb-4 text-primary">📦 BOXIFY</h5>
                <p class="text-muted small">
                    The world's first smart subscription box system built with pure OOP logic. 
                    Tailored experiences delivered right to your doorstep.
                </p>
            </div>

           
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h6 class="fw-bold mb-4">Quick Links</h6>
                <p><a href="index.php" class="text-muted text-decoration-none small">Home</a></p>
                <p><a href="subscribe.php" class="text-muted text-decoration-none small">Our Plans</a></p>
                <?php if(!isset($_SESSION['user'])): ?>
                    <p><a href="register.php" class="text-muted text-decoration-none small">Join Now</a></p>
                <?php endif; ?>
            </div>

          
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                <h6 class="fw-bold mb-4">Support</h6>
                <p><a href="#" class="text-muted text-decoration-none small">Help Center</a></p>
                <p><a href="#" class="text-muted text-decoration-none small">Terms of Service</a></p>
                <p><a href="#" class="text-muted text-decoration-none small">Privacy Policy</a></p>
            </div>

            
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                <h6 class="fw-bold mb-4">Contact</h6>
                <p class="text-muted small"><i class="bi bi-geo-alt-fill me-2"></i> Cairo, Egypt</p>
                <p class="text-muted small"><i class="bi bi-envelope-fill me-2"></i> support@boxify.com</p>
                <p class="text-muted small"><i class="bi bi-phone-fill me-2"></i> +20 123 456 7890</p>
            </div>
        </div>

        <hr class="mb-4 mt-4 text-muted">

       
        <div class="row align-items-center">
            <div class="col-md-7 col-lg-8">
                <p class="text-muted small">
                    © 2026 <strong>Boxify</strong>. All rights reserved. 
                    <span class="ms-2 badge bg-light text-dark border">v2.1 Stable</span>
                </p>
            </div>
            <div class="col-md-5 col-lg-4 text-md-end text-center">
                <a href="#" class="text-muted me-3 fs-5"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-muted me-3 fs-5"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="text-muted me-3 fs-5"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-muted fs-5"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>