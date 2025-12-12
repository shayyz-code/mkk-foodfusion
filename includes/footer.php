<style>
    .site-footer { background-color: #f8f9fa; color: #212529; }
    .site-footer a { color: inherit; text-decoration: none; }
    .site-footer a:hover { color: var(--primary-color); }
    .site-footer .social-links a { margin-right: 0.75rem; }
    .dark-mode .site-footer { background-color: var(--dark-color); color: #eaeaea; }
    .dark-mode .site-footer a { color: #eaeaea; }
    .dark-mode .site-footer a:hover { color: var(--primary-color); }
    .cookie-consent-banner { background-color: #f8f9fa; color: #212529; padding: 0.75rem 0; border-top: 1px solid rgba(0,0,0,0.1); }
    .cookie-consent-banner a { color: var(--primary-color); }
    .dark-mode .cookie-consent-banner { background-color: #121212; color: #eaeaea; border-top-color: rgba(255,255,255,0.1); }
    .dark-mode .cookie-consent-banner a { color: var(--primary-color); }
    /* Make outline-secondary readable in dark mode */
    .dark-mode .cookie-consent-banner .btn-outline-secondary { color: #fff; border-color: #fff; }
    .dark-mode .cookie-consent-banner .btn-outline-secondary:hover { background-color: #fff; color: #000; }
</style>
<footer class="site-footer py-4">
        <div class="container">
            <div class="row">
                <!-- Social Media Links -->
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5>Connect With Us</h5>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#"><i class="fab fa-pinterest fa-lg"></i></a>
                        <a href="#"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="recipes.php">Recipe Collection</a></li>
                        <li><a href="community.php">Community Cookbook</a></li>
                    </ul>
                </div>
                
                <!-- Legal Links -->
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5>Legal</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="privacy.php">Privacy Policy</a></li>
                        <li><a href="terms.php">Terms of Use</a></li>
                        <li><a href="cookies.php">Cookie Policy</a></li>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                <div class="col-md-3">
                    <h5>Newsletter</h5>
                    <p class="small">Subscribe to get the latest recipes and cooking tips</p>
                    <form class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Subscribe</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <hr class="bg-secondary">
            
            <!-- Copyright -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> FoodFusion. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Cookie Consent Banner -->
    <div class="cookie-consent-banner" id="cookieConsentBanner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <p class="mb-md-0">We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies. <a href="cookies.php">Learn more</a></p>
                </div>
                <div class="col-md-4 text-md-right">
                    <button class="btn btn-sm btn-outline-secondary mr-2 cookie-settings">Cookie Settings</button>
                    <button class="btn btn-sm btn-primary accept-cookies">Accept</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    <!-- Removed legacy mobile nav script; header manages sidebar toggle -->
</body>
</html>
