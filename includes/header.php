<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion | Culinary Excellence</title>
    <meta name="description" content="Discover delicious recipes, cooking tips, and food infographics to elevate your culinary skills.">

    <!-- Standard favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="public/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="public/favicon-16x16.png">

    <!-- Apple touch icon (for iPhone/iPad) -->
    <link rel="apple-touch-icon" sizes="180x180" href="public/apple-touch-icon.png">

    <!-- Android Chrome -->
    <link rel="icon" type="image/png" sizes="192x192" href="public/android-chrome-192x192.png">


    <!-- Shortcut icon for older browsers -->
    <link rel="shortcut icon" href="public/favicon.ico">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root { --primary-color: #5865F2; --secondary-color: rgba(24, 131, 207, 1)}
        .title-color-primary { color: var(--primary-color); }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background-color: #4752c4; border-color: #4752c4; }
        .btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); }
        .btn-outline-primary:hover { color: #fff; background-color: var(--primary-color); border-color: var(--primary-color); }
        .text-primary { color: var(--primary-color) !important; }
        .text-secondary { color: rgba(8, 151, 253, 1) !important; }
        .bg-primary { background-color: var(--primary-color) !important; }
        .nav-link:hover, .nav-link:focus { color: var(--primary-color); }
        

        /* Mobile sidebar styles */
        /* Navbar toggler icon overrides for theme-aware color */
        .navbar-toggler { border-color: rgba(0,0,0,0.15); }
        .dark-mode .navbar-toggler { border-color: rgba(255,255,255,0.3); }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%235865F2' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E") !important;
        }
        .dark-mode .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%23ffffff' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E") !important;
        }
        .mobile-sidebar { position: fixed; top: 0; left: 0; height: 100%; width: 280px; background: #fff; box-shadow: 2px 0 10px rgba(0,0,0,0.1); transform: translateX(-100%); transition: transform 0.3s ease; z-index: 1050; padding: 1rem; }
        .mobile-sidebar.open { transform: translateX(0); }
        .sidebar-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.35); opacity: 0; visibility: hidden; transition: opacity 0.3s ease; z-index: 1040; }
        .sidebar-overlay.show { opacity: 1; visibility: visible; }
        @media (min-width: 992px) { /* lg and up */
            .mobile-sidebar, .sidebar-overlay { display: none !important; }
        }
        @media (max-width: 991.98px) {
            .navbar .navbar-collapse { display: none !important; }
        }

        /* Dark mode overrides */
        .dark-mode { background-color: #121212; color: #eaeaea; }
        .dark-mode .navbar { background-color: var(--dark-color) !important; }
        .dark-mode .navbar .navbar-brand { color: #fff; }
        .dark-mode .navbar .nav-link { color: #eaeaea; }
        .dark-mode .navbar .nav-link:hover, .dark-mode .navbar .nav-link:focus { color: var(--primary-color); }
        .dark-mode .dropdown-menu { background-color: var(--dark-color); color: #eaeaea; border-color: rgba(255,255,255,0.1); }
        .dark-mode .dropdown-item { color: #eaeaea; }
        .dark-mode .dropdown-item:hover { background-color: rgba(36, 39, 61, 1); color: #fff; }
        .dark-mode .mobile-sidebar { background-color: var(--dark-color); color: #eaeaea; }
        .dark-mode .sidebar-overlay { background: rgba(0,0,0,0.6); }
        .dark-mode .btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); }
        .dark-mode .btn-outline-primary:hover { color: #fff; background-color: var(--primary-color); border-color: var(--primary-color); }
        .dark-mode .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <span><img src="public/transparent-logo.png" alt="FoodFusion" style="width: 60px;"></span><span class="title-color-primary">Food</span><span class="title-color-secondary">Fusion</span>
            </a>
            <button class="navbar-toggler" type="button" id="mobileNavToggle" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="recipes.php">Recipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="community.php">Cookbook</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="resourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Resources</a>
                        <ul class="dropdown-menu" aria-labelledby="resourcesDropdown">
                            <li><a class="dropdown-item" href="culinary-resources.php">Culinary Resources</a></li>
                            <li><a class="dropdown-item" href="educational-resources.php">Educational Resources</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                </ul>
                <div class="navbar-nav ms-auto">
                    <button class="btn btn-outline-secondary me-2" id="themeToggleBtn" aria-label="Toggle theme"><i class="fas fa-moon"></i></button>
                    <?php if ($isLoggedIn): ?>
                        <div class="dropdown">
                            <button class="nav-link dropdown-toggle btn btn-link" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> <?php echo $_SESSION['first_name']; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="auth/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Join Us</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar & Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay"></div>
    <aside id="mobileSidebar" class="mobile-sidebar">
        <div class="d-flex align-items-center mb-3">
            <a class="navbar-brand" href="index.php">
                <span class="title-color-primary">Food</span><span class="title-color-secondary">Fusion</span>
            </a>
            <button type="button" class="btn btn-link ms-auto" id="mobileSidebarClose" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="recipes.php">Recipe Collection</a></li>
            <li class="nav-item"><a class="nav-link" href="community.php">Community Cookbook</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="mobileResourcesDropdown" data-bs-toggle="dropdown" aria-expanded="false">Resources</a>
                <ul class="dropdown-menu" aria-labelledby="mobileResourcesDropdown">
                    <li><a class="dropdown-item" href="culinary-resources.php">Culinary Resources</a></li>
                    <li><a class="dropdown-item" href="educational-resources.php">Educational Resources</a></li>
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
        </ul>
        <div class="mt-3">
            <?php if ($isLoggedIn): ?>
                <a class="btn btn-outline-primary w-100" href="auth/logout.php">Logout</a>
            <?php else: ?>
                <button class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#registerModal">Join Us</button>
            <?php endif; ?>
        </div>
    </aside>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="container mt-3">
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <?php 
        // Clear the message after displaying
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        ?>
    <?php endif; ?>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login to FoodFusion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_SESSION['errors']) && isset($_SESSION['form_type']) && $_SESSION['form_type'] == 'login'): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php 
                        unset($_SESSION['errors']);
                        unset($_SESSION['form_type']);
                        ?>
                    <?php endif; ?>

                    <form action="auth/login.php" method="post">
                        <div class="mb-3">
                            <label for="login-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="login-email" name="email" required
                                value="<?php echo isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="login-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="login-password" name="password" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="remember-me" name="remember">
                            <label class="form-check-label" for="remember-me">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <p class="mb-0">
                        Don't have an account? 
                        <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Join FoodFusion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_SESSION['errors']) && isset($_SESSION['form_type']) && $_SESSION['form_type'] == 'register'): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php 
                        unset($_SESSION['errors']);
                        unset($_SESSION['form_type']);
                        ?>
                    <?php endif; ?>

                    <form action="auth/register.php" method="post" id="register-form">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="first-name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first-name" name="first_name" required
                                    value="<?php echo isset($_SESSION['form_data']['first_name']) ? $_SESSION['form_data']['first_name'] : ''; ?>">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="last-name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last-name" name="last_name" required
                                    value="<?php echo isset($_SESSION['form_data']['last_name']) ? $_SESSION['form_data']['last_name'] : ''; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="register-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="register-email" name="email" required
                                value="<?php echo isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="register-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="register-password" name="password" required>
                            <div class="form-text">Password must be at least 8 characters long.</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="privacy.php">Terms and Conditions</a></label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <p class="mb-0">
                        Already have an account? 
                        <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>


    <?php
    // Clear form data after displaying
    if (isset($_SESSION['form_data'])) {
        unset($_SESSION['form_data']);
    }
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggleBtn = document.getElementById('mobileNavToggle');
            var sidebar = document.getElementById('mobileSidebar');
            var overlay = document.getElementById('sidebarOverlay');
            var closeBtn = document.getElementById('mobileSidebarClose');
            var themeToggleBtn = document.getElementById('themeToggleBtn');

            function openSidebar() {
                sidebar.classList.add('open');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);

            // Theme toggle
            function applyTheme(theme) {
                if (theme === 'dark') {
                    document.body.classList.add('dark-mode');
                    if (themeToggleBtn) themeToggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
                } else {
                    document.body.classList.remove('dark-mode');
                    if (themeToggleBtn) themeToggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
                }
            }
            var storedTheme = localStorage.getItem('theme');
            if (!storedTheme) {
                // respect system preference by default
                storedTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            applyTheme(storedTheme);
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function() {
                    var current = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
                    var next = current === 'dark' ? 'light' : 'dark';
                    localStorage.setItem('theme', next);
                    applyTheme(next);
                });
            }
        });
    </script>