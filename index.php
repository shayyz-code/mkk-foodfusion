<?php
// Include database connection
require_once 'config/db.php';

// Include header
include_once 'includes/header.php';

// Get featured recipes
$featured_recipes_query = "SELECT * FROM recipes ORDER BY created_at DESC LIMIT 3";
$featured_recipes = mysqli_query($conn, $featured_recipes_query);

// Get upcoming events
$events_query = "SELECT * FROM events ORDER BY event_date ASC LIMIT 3";
$events = mysqli_query($conn, $events_query);

// Get news feed
$news_query = "SELECT * FROM news ORDER BY created_at DESC LIMIT 3";
$news = mysqli_query($conn, $news_query);
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Welcome to FoodFusion</h1>
            <p>Where culinary traditions meet modern innovation</p>
            <button class="btn btn-primary join-btn">Join Us</button>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="mission">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Our Mission</h2>
                <p>At FoodFusion, we believe that cooking is an art that brings people together. Our mission is to create a global community of food enthusiasts who share their passion for culinary excellence, cultural diversity, and sustainable cooking practices.</p>
                <p>Whether you're a professional chef or a home cook, FoodFusion provides a platform to explore, create, and share delicious recipes from around the world.</p>
                <a href="about.php" class="btn btn-outline-primary">Learn More</a>
            </div>
            <div class="col-md-6">
                <img src="assets/images/mission.jpg" alt="FoodFusion Mission" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Featured Recipes Section -->
<section class="featured-recipes">
    <div class="container">
        <h2>Featured Recipes</h2>
        <div class="row">
            <?php
            if (mysqli_num_rows($featured_recipes) > 0) {
                while ($recipe = mysqli_fetch_assoc($featured_recipes)) {
            ?>
                <div class="col-md-4">
                    <div class="card recipe-card">
                        <img src="<?php echo $recipe['image_path']; ?>" class="card-img-top" alt="<?php echo $recipe['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $recipe['title']; ?></h5>
                            <p class="card-text"><?php echo substr($recipe['description'], 0, 100) . '...'; ?></p>
                            <div class="recipe-meta">
                                <span><i class="fas fa-utensils"></i> <?php echo $recipe['cuisine_type']; ?></span>
                                <span><i class="fas fa-leaf"></i> <?php echo $recipe['dietary_pref']; ?></span>
                                <span><i class="fas fa-clock"></i> <?php echo $recipe['prep_time'] + $recipe['cook_time']; ?> mins</span>
                            </div>
                            <a href="recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-primary">View Recipe</a>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p>No featured recipes available at the moment.</p>";
            }
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="recipes.php" class="btn btn-outline-primary">View All Recipes</a>
        </div>
    </div>
</section>

<!-- News Feed Section -->
<section class="news-feed">
    <div class="container">
        <h2>Culinary News & Trends</h2>
        <div class="row">
            <?php
            if (mysqli_num_rows($news) > 0) {
                while ($news_item = mysqli_fetch_assoc($news)) {
            ?>
                <div class="col-md-4">
                    <div class="card news-card">
                        <img src="<?php echo $news_item['image_path']; ?>" class="card-img-top" alt="<?php echo $news_item['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $news_item['title']; ?></h5>
                            <p class="card-text"><?php echo substr($news_item['content'], 0, 100) . '...'; ?></p>
                            <p class="text-muted"><small>Posted on <?php echo date('F d, Y', strtotime($news_item['created_at'])); ?></small></p>
                            <a href="news.php?id=<?php echo $news_item['id']; ?>" class="btn btn-sm btn-outline-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p>No news available at the moment.</p>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Events Carousel Section -->
<section class="events-carousel">
    <div class="container">
        <h2>Upcoming Cooking Events</h2>
        <div id="eventsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                if (mysqli_num_rows($events) > 0) {
                    $active = true;
                    while ($event = mysqli_fetch_assoc($events)) {
                ?>
                    <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
                    <div class="carousel-item-bg d-flex justify-content-center align-items-center" style="height: 200px;">
                        <div class="text-center">
                        <h5><?php echo htmlspecialchars($event['title']); ?></h5>
                        <p><?php echo htmlspecialchars($event['description']); ?></p>
                        <p><strong>Date: <?php echo date('F d, Y', strtotime($event['event_date'])); ?></strong></p>
                        </div>
                    </div>
                    </div>
                <?php
                        $active = false;
                    }
                } else {
                ?>
                    <div class="carousel-item active">
                    <div class="d-flex justify-content-center align-items-center" style="height: 200px; background-color: #f8f9fa;">
                        <div class="text-center">
                        <h5>No Upcoming Events</h5>
                        <p>Check back soon for exciting cooking events!</p>
                        </div>
                    </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#eventsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#eventsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- Cookie consent banner is now in footer.php -->

<?php
// Include footer
include_once 'includes/footer.php';
?>