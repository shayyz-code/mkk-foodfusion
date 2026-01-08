<?php
// Include database connection
require_once 'config/db.php';

// Include header
include_once 'includes/header.php';

// Get all recipes
$recipes_query = "SELECT * FROM recipes ORDER BY created_at DESC";
$recipes = mysqli_query($conn, $recipes_query);

// Get cuisine types for filter
$cuisine_query = "SELECT DISTINCT cuisine_type FROM recipes ORDER BY cuisine_type";
$cuisines = mysqli_query($conn, $cuisine_query);

// Get dietary preferences for filter
$dietary_query = "SELECT DISTINCT dietary_pref FROM recipes ORDER BY dietary_pref";
$dietary_prefs = mysqli_query($conn, $dietary_query);

// Get difficulty levels for filter
$difficulty_query = "SELECT DISTINCT difficulty FROM recipes ORDER BY FIELD(difficulty, 'Easy', 'Medium', 'Hard')";
$difficulties = mysqli_query($conn, $difficulty_query);
?>

<!-- Recipe Collection Header -->
<section class="recipe-header py-5">
    <div class="container text-center">
        <h1>Recipe Collection</h1>
        <p class="lead">Explore our curated collection of diverse recipes from around the world</p>
    </div>
</section>

<!-- Recipe Filters -->
<section class="recipe-filters py-4">
    <div class="container">
        <div class="filter-section">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="cuisine-filter">Cuisine Type</label>
                    <select id="cuisine-filter" class="form-control recipe-filter">
                        <option value="all">All Cuisines</option>
                        <?php
                        if (mysqli_num_rows($cuisines) > 0) {
                            while ($cuisine = mysqli_fetch_assoc($cuisines)) {
                                echo '<option value="' . $cuisine['cuisine_type'] . '">' . $cuisine['cuisine_type'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="dietary-filter">Dietary Preference</label>
                    <select id="dietary-filter" class="form-control recipe-filter">
                        <option value="all">All Preferences</option>
                        <?php
                        if (mysqli_num_rows($dietary_prefs) > 0) {
                            while ($dietary = mysqli_fetch_assoc($dietary_prefs)) {
                                echo '<option value="' . $dietary['dietary_pref'] . '">' . $dietary['dietary_pref'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="difficulty-filter">Difficulty</label>
                    <select id="difficulty-filter" class="form-control recipe-filter">
                        <option value="all">All Levels</option>
                        <?php
                        if (mysqli_num_rows($difficulties) > 0) {
                            while ($difficulty = mysqli_fetch_assoc($difficulties)) {
                                echo '<option value="' . $difficulty['difficulty'] . '">' . $difficulty['difficulty'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="recipe-search">Search Recipes</label>
                    <input type="text" id="recipe-search" class="form-control" placeholder="Search by name or ingredient">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recipe Grid -->
<section class="recipe-collection py-4">
    <div class="container">
        <div class="row" id="recipe-grid">
            <?php
            if (mysqli_num_rows($recipes) > 0) {
                while ($recipe = mysqli_fetch_assoc($recipes)) {
            ?>
                <div class="col-md-4 mb-4 recipe-item" 
                     data-cuisine="<?php echo $recipe['cuisine_type']; ?>" 
                     data-dietary="<?php echo $recipe['dietary_pref']; ?>" 
                     data-difficulty="<?php echo $recipe['difficulty']; ?>">
                    <div class="card recipe-card h-100">
                        <img src="<?php echo $recipe['image_path']; ?>" class="card-img-top" alt="<?php echo $recipe['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $recipe['title']; ?></h5>
                            <p class="card-text"><?php echo substr($recipe['description'], 0, 100) . '...'; ?></p>
                            <div class="recipe-meta">
                                <span><i class="fas fa-utensils"></i> <?php echo $recipe['cuisine_type']; ?></span>
                                <span><i class="fas fa-leaf"></i> <?php echo $recipe['dietary_pref']; ?></span>
                                <span><i class="fas fa-clock"></i> <?php echo $recipe['prep_time'] + $recipe['cook_time']; ?> mins</span>
                            </div>
                            <div class="difficulty-badge mt-2 mb-3">
                                <span class="badge badge-<?php 
                                    echo $recipe['difficulty'] == 'Easy' ? 'success' : 
                                        ($recipe['difficulty'] == 'Medium' ? 'warning' : 'danger'); 
                                ?>">
                                    <?php echo $recipe['difficulty']; ?>
                                </span>
                            </div>
                            <a href="recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-primary">View Recipe</a>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<div class="col-12 text-center"><p>No recipes found. Be the first to add a recipe!</p></div>';
            }
            ?>
        </div>
        
        <!-- No Results Message -->
        <div id="no-results" class="text-center py-4" style="display: none;">
            <p>No recipes match your current filters. Try adjusting your search criteria.</p>
        </div>
    </div>
</section>

<!-- Share Your Recipe CTA -->
<section class="share-recipe-cta bg-primary text-white py-5 text-center">
    <div class="container">
        <h2>Have a Recipe to Share?</h2>
        <p class="lead mb-4">Join our community and contribute your favorite recipes to the FoodFusion collection.</p>
        <a href="community.php" class="btn btn-light btn-lg">Share Your Recipe</a>
    </div>
</section>

<!-- Recipe Detail Modal -->
<div class="modal fade" id="recipeModal" tabindex="-1" role="dialog" aria-labelledby="recipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recipeModalLabel">Recipe Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="recipeModalContent">
                <!-- Recipe details will be loaded here via AJAX -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" id="fullRecipeLink" class="btn btn-primary">View Full Recipe</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Quick view recipe functionality
    $(document).ready(function() {
        // Check if there are any recipes displayed
        function checkResults() {
            if ($('.recipe-item:visible').length === 0) {
                $('#no-results').show();
            } else {
                $('#no-results').hide();
            }
        }
        
        // Filter recipes based on selected criteria
        $('.recipe-filter').change(function() {
            filterRecipes();
        });
        
        $('#recipe-search').on('input', function() {
            filterRecipes();
        });
        
        function filterRecipes() {
            const cuisine = $('#cuisine-filter').val();
            const dietary = $('#dietary-filter').val();
            const difficulty = $('#difficulty-filter').val();
            const searchTerm = $('#recipe-search').val().toLowerCase();
            
            $('.recipe-item').each(function() {
                const $recipe = $(this);
                const recipeCuisine = $recipe.data('cuisine');
                const recipeDietary = $recipe.data('dietary');
                const recipeDifficulty = $recipe.data('difficulty');
                const recipeTitle = $recipe.find('.card-title').text().toLowerCase();
                const recipeDesc = $recipe.find('.card-text').text().toLowerCase();
                
                const cuisineMatch = cuisine === 'all' || recipeCuisine === cuisine;
                const dietaryMatch = dietary === 'all' || recipeDietary === dietary;
                const difficultyMatch = difficulty === 'all' || recipeDifficulty === difficulty;
                const searchMatch = searchTerm === '' || recipeTitle.includes(searchTerm) || recipeDesc.includes(searchTerm);
                
                if (cuisineMatch && dietaryMatch && difficultyMatch && searchMatch) {
                    $recipe.show();
                } else {
                    $recipe.hide();
                }
            });
            
            checkResults();
        }
        
        // Quick view recipe
        $('.recipe-card').click(function(e) {
            if (!$(e.target).hasClass('btn')) {
                e.preventDefault();
                const recipeId = $(this).closest('.recipe-item').find('a').attr('href').split('=')[1];
                $('#fullRecipeLink').attr('href', 'recipe.php?id=' + recipeId);
                $('#recipeModal').modal('show');
                
                // Load recipe details via AJAX
                $.ajax({
                    url: 'get_recipe.php',
                    type: 'GET',
                    data: { id: recipeId },
                    success: function(response) {
                        $('#recipeModalContent').html(response);
                    },
                    error: function() {
                        $('#recipeModalContent').html('<p class="text-danger">Error loading recipe details. Please try again.</p>');
                    }
                });
            }
        });
    });
</script>

<?php
// Include footer
include_once 'includes/footer.php';
?>