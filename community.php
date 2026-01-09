<?php

// Include database connection
require_once 'config/db.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Get community recipes (most recent first)
$query = "SELECT r.*, u.first_name, u.last_name FROM recipes r 
          JOIN users u ON r.user_id = u.id 
          WHERE r.is_community = 1 
          ORDER BY r.created_at DESC";
$result = mysqli_query($conn, $query);


// Check for query errors
if (!$result) {
    // Create users table if it doesn't exist
    $create_users_table = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    mysqli_query($conn, $create_users_table);
    
    // Insert a default user if none exists
    $check_users = mysqli_query($conn, "SELECT * FROM users LIMIT 1");
    if (mysqli_num_rows($check_users) == 0) {
        $default_password = password_hash("password123", PASSWORD_DEFAULT);
        $insert_user = "INSERT INTO users (first_name, last_name, email, password) 
                        VALUES ('Admin', 'User', 'admin@foodfusion.com', '$default_password')";
        mysqli_query($conn, $insert_user);
    }
    
    // Create recipes table if it doesn't exist
    $create_recipes_table = "CREATE TABLE IF NOT EXISTS recipes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        ingredients TEXT NOT NULL,
        instructions TEXT NOT NULL,
        prep_time INT,
        cook_time INT,
        servings INT,
        difficulty VARCHAR(50),
        cuisine_type VARCHAR(100),
        dietary_preferences VARCHAR(100),
        image_url VARCHAR(255),
        user_id INT,
        is_featured BOOLEAN DEFAULT 0,
        is_community BOOLEAN DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    mysqli_query($conn, $create_recipes_table);
    
    // Try the query again
    $result = mysqli_query($conn, $query);
}

// Get cooking tips
$tips_query = "SELECT * FROM cooking_tips ORDER BY created_at DESC LIMIT 5";
$tips_result = mysqli_query($conn, $tips_query);

// Create cooking_tips table if it doesn't exist
if (!$tips_result) {
    $create_tips_table = "CREATE TABLE IF NOT EXISTS cooking_tips (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        tip_content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    mysqli_query($conn, $create_tips_table);
    
    // Insert sample cooking tips
    $sample_tips = [
        "Always preheat your oven for at least 10 minutes before baking.",
        "Add a pinch of salt to enhance the sweetness in desserts.",
        "Let meat rest for 5-10 minutes after cooking before cutting into it.",
        "Use cold butter for flaky pastries and room temperature butter for cakes.",
        "Toast spices before using them to enhance their flavor."
    ];
    
    foreach ($sample_tips as $index => $tip) {
        $user_id = ($index % 5) + 1; // Assign to users 1-5
        $insert_tip = "INSERT INTO cooking_tips (user_id, tip_content) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert_tip);
        mysqli_stmt_bind_param($stmt, "is", $user_id, $tip);
        mysqli_stmt_execute($stmt);
    }
    
    // Refresh tips query
    $tips_result = mysqli_query($conn, "SELECT * FROM cooking_tips ORDER BY created_at DESC LIMIT 5");
}

// Include header
include 'includes/header.php';
?>

<main class="community-page">
    <!-- Hero Section -->
    <section class="community-hero">
        <div class="container text-center py-5">
            <h1 class="display-4">Community Cookbook</h1>
            <p class="lead">Share your culinary masterpieces and discover recipes from fellow food enthusiasts</p>
            <?php if (!$isLoggedIn): ?>
                <button class="btn btn-primary btn-lg join-btn" data-toggle="modal" data-target="#loginModal">Join to Share Your Recipes</button>
            <?php endif; ?>
        </div>
    </section>

    <!-- Community Features Section -->
    <section class="container py-4">
        <div class="row">
            <div class="col-md-8">
                <!-- Recipe Submission Form (visible only to logged-in users) -->
                <?php if ($isLoggedIn): ?>
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Share Your Recipe</h4>
                    </div>
                    <div class="card-body">
                        <form id="community-recipe-form" action="submit_recipe.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="is_community" value="1">
                            
                            <div class="form-group">
                                <label for="recipe-title">Recipe Title</label>
                                <input type="text" class="form-control" id="recipe-title" name="title" required>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="cuisine-type">Cuisine Type</label>
                                    <select class="form-control" id="cuisine-type" name="cuisine_type" required>
                                        <option value="">Select Cuisine</option>
                                        <option value="Italian">Italian</option>
                                        <option value="Mexican">Mexican</option>
                                        <option value="Asian">Asian</option>
                                        <option value="Mediterranean">Mediterranean</option>
                                        <option value="American">American</option>
                                        <option value="Indian">Indian</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dietary-pref">Dietary Preference</label>
                                    <select class="form-control" id="dietary-pref" name="dietary_pref">
                                        <option value="">Select Preference</option>
                                        <option value="Vegetarian">Vegetarian</option>
                                        <option value="Vegan">Vegan</option>
                                        <option value="Gluten-Free">Gluten-Free</option>
                                        <option value="Dairy-Free">Dairy-Free</option>
                                        <option value="Keto">Keto</option>
                                        <option value="None">None</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="difficulty">Difficulty</label>
                                    <select class="form-control" id="difficulty" name="difficulty" required>
                                        <option value="">Select Difficulty</option>
                                        <option value="Easy">Easy</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Hard">Hard</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="prep-time">Prep Time (minutes)</label>
                                    <input type="number" class="form-control" id="prep-time" name="prep_time" min="1" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cook-time">Cook Time (minutes)</label>
                                    <input type="number" class="form-control" id="cook-time" name="cook_time" min="1" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="recipe-description">Description</label>
                                <textarea class="form-control" id="recipe-description" name="description" rows="3" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Ingredients</label>
                                <div id="ingredients-container">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="ingredients[]" placeholder="e.g., 2 cups flour" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-danger remove-field" disabled>Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-ingredient">+ Add Ingredient</button>
                            </div>
                            
                            <div class="form-group">
                                <label>Instructions</label>
                                <div id="instructions-container">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="instructions[]" placeholder="Step 1" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-danger remove-field" disabled>Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-instruction">+ Add Instruction</button>
                            </div>
                            
                            <div class="form-group">
                                <label for="recipe-image">Recipe Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="recipe-image" name="recipe_image" accept="image/*,application/pdf">
                                    <label class="custom-file-label" for="recipe-image">Choose file</label>
                                </div>
                                <div id="image-preview-container" class="mt-2 d-none">
                                    <img id="image-preview" class="img-fluid rounded" alt="Recipe preview">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Submit Recipe</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Community Recipes -->
                <h3 class="mb-4">Community Recipes</h3>
                
                <div class="row" id="community-recipes">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($recipe = mysqli_fetch_assoc($result)): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm recipe-card">
                                    <?php if (!empty($recipe['image_path'])): ?>
                                        <?php $ext = strtolower(pathinfo($recipe['image_path'], PATHINFO_EXTENSION)); ?>
                                        <?php if (in_array($ext, ['jpg','jpeg','png','gif','webp'])): ?>
                                            <img src="<?php echo $recipe['image_path']; ?>" class="card-img-top recipe-img" alt="<?php echo $recipe['title']; ?>">
                                        <?php else: ?>
                                            <div class="p-3">
                                                <a href="<?php echo $recipe['image_path']; ?>" class="btn btn-outline-secondary btn-sm" target="_blank">View File</a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $recipe['title']; ?></h5>
                                        <p class="card-text text-muted">By <?php echo $recipe['first_name'] . ' ' . $recipe['last_name']; ?></p>
                                        <div class="recipe-meta mb-2">
                                            <span class="badge badge-light"><?php echo $recipe['cuisine_type']; ?></span>
                                            <?php if (!empty($recipe['dietary_pref'])): ?>
                                                <span class="badge badge-light"><?php echo $recipe['dietary_pref']; ?></span>
                                            <?php endif; ?>
                                            <span class="badge badge-<?php 
                                                echo $recipe['difficulty'] == 'Easy' ? 'success' : 
                                                    ($recipe['difficulty'] == 'Medium' ? 'warning' : 'danger'); 
                                            ?>">
                                                <?php echo $recipe['difficulty']; ?>
                                            </span>
                                        </div>
                                        <p class="card-text"><?php echo substr($recipe['description'], 0, 100); ?>...</p>
                                        <a href="recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-outline-primary btn-sm">View Recipe</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                No community recipes yet. Be the first to share your recipe!
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <!-- Cooking Tips Section -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Cooking Tips</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush cooking-tips">
                            <?php while ($tip = mysqli_fetch_assoc($tips_result)): ?>
                                <li class="list-group-item">
                                    <p class="mb-0"><?php echo $tip['tip_content']; ?></p>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        
                        <?php if ($isLoggedIn): ?>
                            <form id="tip-form" class="mt-3" action="submit_tip.php" method="post">
                                <div class="form-group">
                                    <label for="cooking-tip">Share Your Cooking Tip</label>
                                    <textarea class="form-control" id="cooking-tip" name="tip_content" rows="2" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">Share Tip</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Community Leaderboard -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Top Contributors</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Chef Maria</span>
                                <span class="badge badge-primary badge-pill">15 recipes</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Baker John</span>
                                <span class="badge badge-primary badge-pill">12 recipes</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Grill Master Steve</span>
                                <span class="badge badge-primary badge-pill">9 recipes</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Pastry Queen Lisa</span>
                                <span class="badge badge-primary badge-pill">7 recipes</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Spice Expert Raj</span>
                                <span class="badge badge-primary badge-pill">6 recipes</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Upcoming Community Events -->
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Upcoming Events</h4>
                    </div>
                    <div class="card-body">
                        <div class="event-item mb-3">
                            <h5>Virtual Cooking Class</h5>
                            <p class="text-muted mb-1">July 15, 2023 • 6:00 PM</p>
                            <p class="mb-0">Learn to make authentic Italian pasta from scratch!</p>
                        </div>
                        <div class="event-item mb-3">
                            <h5>Recipe Contest</h5>
                            <p class="text-muted mb-1">August 5-10, 2023</p>
                            <p class="mb-0">Submit your best summer dessert recipe for a chance to win prizes!</p>
                        </div>
                        <div class="event-item">
                            <h5>Community Potluck</h5>
                            <p class="text-muted mb-1">September 3, 2023 • 12:00 PM</p>
                            <p class="mb-0">Bring your signature dish and meet fellow food enthusiasts!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Recipe Submission Handler -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add ingredient field
    document.getElementById('add-ingredient').addEventListener('click', function() {
        const container = document.getElementById('ingredients-container');
        const newField = document.createElement('div');
        newField.className = 'input-group mb-2';
        newField.innerHTML = `
            <input type="text" class="form-control" name="ingredients[]" placeholder="e.g., 2 cups flour" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-outline-danger remove-field">Remove</button>
            </div>
        `;
        container.appendChild(newField);
        
        // Enable the first remove button if it was disabled
        if (container.children.length > 1) {
            container.querySelector('.remove-field').disabled = false;
        }
    });
    
    // Add instruction field
    document.getElementById('add-instruction').addEventListener('click', function() {
        const container = document.getElementById('instructions-container');
        const newField = document.createElement('div');
        newField.className = 'input-group mb-2';
        newField.innerHTML = `
            <input type="text" class="form-control" name="instructions[]" placeholder="Step ${container.children.length + 1}" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-outline-danger remove-field">Remove</button>
            </div>
        `;
        container.appendChild(newField);
        
        // Enable the first remove button if it was disabled
        if (container.children.length > 1) {
            container.querySelector('.remove-field').disabled = false;
        }
    });
    
    // Remove field functionality (using event delegation)
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-field')) {
            const fieldGroup = e.target.closest('.input-group');
            const container = fieldGroup.parentElement;
            
            fieldGroup.remove();
            
            // If only one field remains, disable its remove button
            if (container.children.length === 1) {
                container.querySelector('.remove-field').disabled = true;
            }
            
            // Update instruction step numbers if this is an instruction field
            if (container.id === 'instructions-container') {
                Array.from(container.querySelectorAll('input')).forEach((input, index) => {
                    input.placeholder = `Step ${index + 1}`;
                });
            }
        }
    });
    
    // Image preview
    const imageInput = document.getElementById('recipe-image');
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                const previewContainer = document.getElementById('image-preview-container');
                const preview = document.getElementById('image-preview');
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('d-none');
                }
                
                reader.readAsDataURL(file);
                
                // Update file input label
                const fileLabel = this.nextElementSibling;
                fileLabel.textContent = file.name;
            }
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>
