<?php
// Include database connection
require_once 'config/db.php';

// Include header
include_once 'includes/header.php';

// Check if recipe ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $recipe_id = $_GET['id'];
    
    // Get recipe details
    $recipe_query = "SELECT * FROM recipes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $recipe_query);
    mysqli_stmt_bind_param($stmt, "i", $recipe_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $recipe = mysqli_fetch_assoc($result);
    } else {
        // Recipe not found
        echo '<div class="container py-5 text-center">
                <div class="alert alert-danger">
                    <h4>Recipe Not Found</h4>
                    <p>The recipe you are looking for does not exist or has been removed.</p>
                    <a href="recipes.php" class="btn btn-primary">Back to Recipes</a>
                </div>
              </div>';
        include_once 'includes/footer.php';
        exit;
    }
} else {
    // No recipe ID provided
    echo '<div class="container py-5 text-center">
            <div class="alert alert-warning">
                <h4>No Recipe Selected</h4>
                <p>Please select a recipe to view its details.</p>
                <a href="recipes.php" class="btn btn-primary">Browse Recipes</a>
            </div>
          </div>';
    include_once 'includes/footer.php';
    exit;
}
?>

<!-- Recipe Detail Section -->
<section class="recipe-detail py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1><?php echo $recipe['title']; ?></h1>
                
                <div class="recipe-meta mb-4">
                    <span class="mr-3"><i class="fas fa-utensils"></i> <?php echo $recipe['cuisine_type']; ?></span>
                    <span class="mr-3"><i class="fas fa-leaf"></i> <?php echo $recipe['dietary_pref']; ?></span>
                    <span class="mr-3"><i class="fas fa-clock"></i> Prep: <?php echo $recipe['prep_time']; ?> mins</span>
                    <span class="mr-3"><i class="fas fa-fire"></i> Cook: <?php echo $recipe['cook_time']; ?> mins</span>
                    <span><i class="fas fa-chart-line"></i> 
                        <span class="badge badge-<?php 
                            echo $recipe['difficulty'] == 'Easy' ? 'success' : 
                                ($recipe['difficulty'] == 'Medium' ? 'warning' : 'danger'); 
                        ?>">
                            <?php echo $recipe['difficulty']; ?>
                        </span>
                    </span>
                </div>
                
                <div class="recipe-image mb-4">
                    <img src="<?php echo $recipe['image_path']; ?>" alt="<?php echo $recipe['title']; ?>" class="img-fluid rounded">
                </div>
                
                <div class="recipe-description mb-4">
                    <h4>Description</h4>
                    <p><?php echo $recipe['description']; ?></p>
                </div>
                
                <div class="recipe-ingredients mb-4">
                    <h4>Ingredients</h4>
                    <ul class="list-group">
                        <?php
                        $ingredients = explode("\n", $recipe['ingredients']);
                        foreach ($ingredients as $ingredient) {
                            if (!empty(trim($ingredient))) {
                                echo '<li class="list-group-item">' . $ingredient . '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
                
                <div class="recipe-instructions">
                    <h4>Instructions</h4>
                    <ol class="instruction-list">
                        <?php
                        $instructions = explode("\n", $recipe['instructions']);
                        foreach ($instructions as $instruction) {
                            if (!empty(trim($instruction))) {
                                echo '<li class="mb-3">' . $instruction . '</li>';
                            }
                        }
                        ?>
                    </ol>
                </div>
                
                <!-- Recipe Rating and Comments Section -->
                <div class="recipe-rating-comments mt-5">
                    <h4>Ratings & Comments</h4>
                    
                    <?php
                    // Display rating messages
                    if (isset($_SESSION['rating_message'])) {
                        $message_type = isset($_SESSION['rating_type']) ? $_SESSION['rating_type'] : 'info';
                        echo '<div class="alert alert-' . $message_type . ' alert-dismissible fade show" role="alert">';
                        echo $_SESSION['rating_message'];
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';
                        unset($_SESSION['rating_message']);
                        unset($_SESSION['rating_type']);
                    }
                    ?>
                    
                    <!-- Rating Form -->
                    <div class="rating-form mb-4">
                        <form action="rate_recipe.php" method="post">
                            <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
                            <div class="form-group">
                                <label for="user_name">Your Name:</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" 
                                       value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] : ''; ?>" 
                                       required>
                            </div>
                            <div class="form-group">
                                <label>Rate this recipe:</label>
                                <div class="rating-stars mb-2">
                                    <i class="far fa-star" data-value="1"></i>
                                    <i class="far fa-star" data-value="2"></i>
                                    <i class="far fa-star" data-value="3"></i>
                                    <i class="far fa-star" data-value="4"></i>
                                    <i class="far fa-star" data-value="5"></i>
                                    <input type="hidden" name="rating" id="rating-value" value="0" required>
                                </div>
                                <small class="text-muted">Click on the stars to rate</small>
                            </div>
                            <div class="form-group">
                                <label for="comment">Your Comment:</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" 
                                          placeholder="Share your thoughts about this recipe..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Rating</button>
                        </form>
                    </div>
                    
                    <!-- Comments Display -->
                    <div class="comments-section">
                        <?php
                        // Get average rating
                        $avg_rating_query = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_ratings FROM recipe_ratings WHERE recipe_id = ?";
                        $stmt = mysqli_prepare($conn, $avg_rating_query);
                        mysqli_stmt_bind_param($stmt, "i", $recipe_id);
                        mysqli_stmt_execute($stmt);
                        $avg_result = mysqli_stmt_get_result($stmt);
                        $avg_data = mysqli_fetch_assoc($avg_result);
                        
                        $avg_rating = round($avg_data['avg_rating'], 1);
                        $total_ratings = $avg_data['total_ratings'];
                        ?>
                        
                        <div class="rating-summary mb-4">
                            <h5>User Ratings & Comments</h5>
                            <?php if ($total_ratings > 0): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rating-display mr-3">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $avg_rating) {
                                                echo '<i class="fas fa-star text-warning"></i>';
                                            } elseif ($i - 0.5 <= $avg_rating) {
                                                echo '<i class="fas fa-star-half-alt text-warning"></i>';
                                            } else {
                                                echo '<i class="far fa-star text-warning"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <span class="h6 mb-0"><?php echo $avg_rating; ?> out of 5</span>
                                    <span class="text-muted ml-2">(<?php echo $total_ratings; ?> rating<?php echo $total_ratings != 1 ? 's' : ''; ?>)</span>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No ratings yet. Be the first to rate this recipe!</p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="comment-list">
                            <?php
                            // Get all comments for this recipe
                            $comments_query = "SELECT user_name, rating, comment, created_at FROM recipe_ratings 
                                             WHERE recipe_id = ? AND comment IS NOT NULL AND comment != '' 
                                             ORDER BY created_at DESC";
                            $stmt = mysqli_prepare($conn, $comments_query);
                            mysqli_stmt_bind_param($stmt, "i", $recipe_id);
                            mysqli_stmt_execute($stmt);
                            $comments_result = mysqli_stmt_get_result($stmt);
                            
                            if (mysqli_num_rows($comments_result) > 0) {
                                while ($comment = mysqli_fetch_assoc($comments_result)) {
                            ?>
                                <div class="comment-item p-3 mb-3 bg-primary rounded">
                                    <div class="d-flex justify-content-between">
                                        <h6><?php echo htmlspecialchars($comment['user_name']); ?></h6>
                                        <div class="rating-display">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $comment['rating']) {
                                                    echo '<i class="fas fa-star text-warning"></i>';
                                                } else {
                                                    echo '<i class="far fa-star text-warning"></i>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <p class="mb-1"><?php echo htmlspecialchars($comment['comment']); ?></p>
                                    <small class="text">Posted on <?php echo date('F j, Y', strtotime($comment['created_at'])); ?></small>
                                </div>
                            <?php
                                }
                            } else {
                                echo '<p class="text-muted">No comments yet. Be the first to share your thoughts!</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Recipe Sharing -->
                <div class="recipe-sharing p-4 rounded mb-4">
                    <h4>Share This Recipe</h4>
                    <div class="social-sharing mt-3">
                        <a href="#" class="btn btn-outline-primary mr-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-info mr-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-danger mr-2"><i class="fab fa-pinterest"></i></a>
                        <a href="#" class="btn btn-outline-success"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
                
                <!-- Recipe Print/Save -->
                <div class="recipe-actions p-4 rounded mb-4">
                    <h4>Recipe Actions</h4>
                    <div class="action-buttons mt-3">
                        <a href="#" class="btn btn-outline-secondary btn-block mb-2" onclick="window.print()"><i class="fas fa-print"></i> Print Recipe</a>
                    </div>
                </div>
                
                <!-- Similar Recipes -->
                <div class="similar-recipes p-4 rounded">
                    <h4>You Might Also Like</h4>
                    <?php
                    // Get similar recipes based on cuisine type
                    $similar_query = "SELECT id, title, image_path FROM recipes 
                                     WHERE cuisine_type = ? AND id != ? 
                                     ORDER BY RAND() LIMIT 3";
                    $stmt = mysqli_prepare($conn, $similar_query);
                    mysqli_stmt_bind_param($stmt, "si", $recipe['cuisine_type'], $recipe_id);
                    mysqli_stmt_execute($stmt);
                    $similar_result = mysqli_stmt_get_result($stmt);
                    
                    if (mysqli_num_rows($similar_result) > 0) {
                        while ($similar = mysqli_fetch_assoc($similar_result)) {
                    ?>
                        <div class="similar-recipe-item d-flex align-items-center mt-3">
                            <img src="<?php echo $similar['image_path']; ?>" alt="<?php echo $similar['title']; ?>" class="img-fluid rounded mr-3" style="width: 80px; height: 60px; object-fit: cover;">
                            <a href="recipe.php?id=<?php echo $similar['id']; ?>"><?php echo $similar['title']; ?></a>
                        </div>
                    <?php
                        }
                    } else {
                        echo '<p class="mt-3">No similar recipes found.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- More Recipes Section -->
<section class="more-recipes bg-primary py-5">
    <div class="container">
        <h3 class="text-center mb-4">Explore More Recipes</h3>
        <div class="row">
            <?php
            // Get random recipes
            $random_query = "SELECT id, title, image_path, cuisine_type, difficulty FROM recipes 
                           WHERE id != ? ORDER BY RAND() LIMIT 3";
            $stmt = mysqli_prepare($conn, $random_query);
            mysqli_stmt_bind_param($stmt, "i", $recipe_id);
            mysqli_stmt_execute($stmt);
            $random_result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($random_result) > 0) {
                while ($random = mysqli_fetch_assoc($random_result)) {
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card recipe-card h-100">
                        <img src="<?php echo $random['image_path']; ?>" class="card-img-top" alt="<?php echo $random['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $random['title']; ?></h5>
                            <div class="recipe-meta">
                                <span><i class="fas fa-utensils"></i> <?php echo $random['cuisine_type']; ?></span>
                                <span><i class="fas fa-chart-line"></i> 
                                    <span class="badge badge-<?php 
                                        echo $random['difficulty'] == 'Easy' ? 'success' : 
                                            ($random['difficulty'] == 'Medium' ? 'warning' : 'danger'); 
                                    ?>">
                                        <?php echo $random['difficulty']; ?>
                                    </span>
                                </span>
                            </div>
                            <a href="recipe.php?id=<?php echo $random['id']; ?>" class="btn btn-primary mt-3">View Recipe</a>
                        </div>
                    </div>
                </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<?php
// Include footer
include_once 'includes/footer.php';
?>