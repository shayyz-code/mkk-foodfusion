<?php
// Include database connection
require_once 'config/db.php';

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
        
        // Output recipe details in HTML format for the modal
        ?>
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $recipe['image_path']; ?>" alt="<?php echo $recipe['title']; ?>" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h4><?php echo $recipe['title']; ?></h4>
                <p><?php echo $recipe['description']; ?></p>
                
                <div class="recipe-meta mb-3">
                    <div><strong>Cuisine:</strong> <?php echo $recipe['cuisine_type']; ?></div>
                    <div><strong>Dietary:</strong> <?php echo $recipe['dietary_pref']; ?></div>
                    <div><strong>Difficulty:</strong> 
                        <span class="badge badge-<?php 
                            echo $recipe['difficulty'] == 'Easy' ? 'success' : 
                                ($recipe['difficulty'] == 'Medium' ? 'warning' : 'danger'); 
                        ?>">
                            <?php echo $recipe['difficulty']; ?>
                        </span>
                    </div>
                    <div><strong>Prep Time:</strong> <?php echo $recipe['prep_time']; ?> mins</div>
                    <div><strong>Cook Time:</strong> <?php echo $recipe['cook_time']; ?> mins</div>
                    <div><strong>Total Time:</strong> <?php echo $recipe['prep_time'] + $recipe['cook_time']; ?> mins</div>
                </div>
                
                <h5>Ingredients</h5>
                <ul class="ingredients-preview">
                    <?php
                    $ingredients = explode("\n", $recipe['ingredients']);
                    $count = 0;
                    foreach ($ingredients as $ingredient) {
                        if (!empty(trim($ingredient)) && $count < 5) {
                            echo '<li>' . $ingredient . '</li>';
                            $count++;
                        }
                    }
                    
                    if (count($ingredients) > 5) {
                        echo '<li>... and ' . (count($ingredients) - 5) . ' more ingredients</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php
    } else {
        echo '<div class="alert alert-danger">Recipe not found.</div>';
    }
} else {
    echo '<div class="alert alert-warning">No recipe ID provided.</div>';
}
?>