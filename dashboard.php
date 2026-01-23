<?php
// Include database connection
require_once 'config/db.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['message'] = "Please login to access your dashboard.";
    $_SESSION['message_type'] = "warning";
    header("Location: index.php");
    exit();
}

// Get user info
$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];

// Get user's recipes
$query = "SELECT * FROM recipes WHERE user_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$my_recipes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $my_recipes[] = $row;
}

?>
<?php include 'includes/header.php'; ?>

<div class="container py-5 mt-5">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <!-- User Profile Card -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px; border-radius: 50%; font-size: 2.5rem;">
                            <?php echo strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1)); ?>
                        </div>
                    </div>
                    <h4 class="card-title fw-bold"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h4>
                    <p class="text-muted mb-4"><?php echo htmlspecialchars($email); ?></p>
                    
                    <div class="d-grid gap-2">
                        <a href="recipes.php" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i>Submit New Recipe</a>
                        <a href="community.php" class="btn btn-outline-primary"><i class="fas fa-users me-2"></i>Browse Community</a>
                        <a href="auth/logout.php" class="btn btn-outline-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="card shadow-sm border-0 rounded-3 mt-4">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">Your Stats</h5>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Recipes Shared</span>
                        <span class="badge bg-primary rounded-pill"><?php echo count($my_recipes); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <!-- My Recipes Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">My Recipes</h3>
            </div>
            
            <?php if (empty($my_recipes)): ?>
                <div class="card border-0 shadow-sm rounded-3 p-5 text-center">
                    <div class="mb-3">
                        <i class="fas fa-utensils fa-3x text-muted opacity-50"></i>
                    </div>
                    <h5>No recipes yet</h5>
                    <p class="text-muted">Share your culinary creations with the community!</p>
                    <div class="mt-3">
                        <a href="submit_recipe.php" class="btn btn-primary">Share Your First Recipe</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <?php foreach ($my_recipes as $recipe): ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden recipe-card">
                                <?php if (!empty($recipe['image_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($recipe['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($recipe['title']); ?>" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-utensils fa-3x text-secondary opacity-50"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($recipe['cuisine_type']); ?></span>
                                        <small class="text-muted"><i class="far fa-clock me-1"></i> <?php echo $recipe['cook_time'] + $recipe['prep_time']; ?> min</small>
                                    </div>
                                    <h5 class="card-title fw-bold"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                                    <p class="card-text text-muted text-truncate"><?php echo htmlspecialchars($recipe['description']); ?></p>
                                </div>
                                <div class="card-footer bg-white border-top-0 pb-3">
                                     <small class="text-muted">Shared on <?php echo date('M d, Y', strtotime($recipe['created_at'])); ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
