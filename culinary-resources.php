<?php
// Include database connection
require_once 'config/db.php';

// Include header
include 'includes/header.php';
?>

<!-- Culinary Resources Hero Section -->
<section class="hero-section culinary-hero">
    <div class="container text-center py-5">
        <h1 class="display-4">Culinary Resources</h1>
        <p class="lead">Enhance your cooking skills with our downloadable recipe cards, tutorials, and instructional videos.</p>
    </div>
</section>

<!-- Search Section -->
<section class="search-section py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="input-group align-items-center">
                    <input type="text" id="resourceSearchInput" class="form-control form-control-lg border-right-0" placeholder="Search for recipes, tutorials, or videos...">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recipe Cards Section -->
<section class="recipe-cards-section content-section py-5">
    <div class="container">
        <h2 class="section-title mb-4">Downloadable Recipe Cards</h2>
        <p class="section-description mb-4">Print these beautifully designed recipe cards to build your physical cookbook collection.</p>
        
        <div class="row">
            <div class="col-md-4 mb-4 searchable-item">
                <div class="card h-100">
                    <img src="assets/images/ebooks/pasta_collection.jpeg" class="card-img-top" alt="Classic Pasta Recipe Card">
                    <div class="card-body">
                        <h5 class="card-title">Classic Pasta Collection</h5>
                        <p class="card-text">5 essential pasta recipes every home cook should master.</p>
                    </div>
                    <div class="card-footer border-top-0">
                        <a href="assets/ebooks/pasta_collection.pdf" class="btn btn-primary btn-sm"><i class="fas fa-download mr-1"></i> Download PDF</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 searchable-item">
                <div class="card h-100">
                    <img src="assets/images/ebooks/baking_basics.jpeg" class="card-img-top" alt="Baking Basics Recipe Card">
                    <div class="card-body">
                        <h5 class="card-title">Baking Basics</h5>
                        <p class="card-text">Essential recipes for cookies, cakes, and breads with detailed instructions.</p>
                    </div>
                    <div class="card-footer border-top-0">
                        <a href="assets/ebooks/baking_basics.pdf" class="btn btn-primary btn-sm"><i class="fas fa-download mr-1"></i> Download PDF</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 searchable-item">
                <div class="card h-100">
                    <img src="assets/images/ebooks/healthy_meals.jpeg" class="card-img-top" alt="Healthy Meals Recipe Card">
                    <div class="card-body">
                        <h5 class="card-title">30-Minute Healthy Meals</h5>
                        <p class="card-text">Quick and nutritious recipes for busy weeknights.</p>
                    </div>
                    <div class="card-footer border-top-0">
                        <a href="assets/ebooks/healthy_meals.epub" class="btn btn-primary btn-sm"><i class="fas fa-download mr-1"></i> Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cooking Tutorials Section -->
<section class="tutorials-section content-section py-5 bg-primary">
    <div class="container">
        <h2 class="section-title mb-4 text-white">Cooking Tutorials</h2>
        <p class="section-description mb-4 text-white">Step-by-step guides to master essential cooking techniques.</p>
        
        <div class="row">
            <div class="col-lg-6 mb-4 searchable-item">
                <div class="card tutorial-card">
                    <div class="row">
                        <div class="p-4" style="display: flex; justify-content: center;">
                            <iframe width="400" height="auto" style="aspect-ratio: 929/523;" src="https://www.youtube.com/embed/YrHpeEwk_-U" title="9 Essential Knife Skills To Master | Epicurious 101" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div>
                            <div class="card-body">
                                <h5 class="card-title">Knife Skills 101</h5>
                                <p class="card-text">Master the five essential knife skills to enhance your cooking.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4 searchable-item">
                <div class="card tutorial-card">
                    <div class="row">
                        <div class="p-4" style="display: flex; justify-content: center;">
                            <iframe width="400" height="auto" style="aspect-ratio: 929/523;" src="https://www.youtube.com/embed/LpalC9v8ffQ" title="These 5 Sauces Will Upgrade Your Weeknight Meal Game | Epicurious 101" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div>
                            <div class="card-body">
                                <h5 class="card-title">Sauce Basics</h5>
                                <p class="card-text">Master the five mother sauces and elevate your cooking instantly.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Instructional Videos Section -->
<section class="videos-section content-section py-5">
    <div class="container">
        <h2 class="section-title mb-4">Instructional Videos</h2>
        <p class="section-description mb-4">Watch our detailed video tutorials on various cooking techniques and kitchen hacks.</p>
        
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4 searchable-item">
                <div class="card video-card h-100">
                    <div class="video-thumbnail" style="display: flex; justify-content: center;">
                        <iframe width="400" height="auto" style="aspect-ratio: 929/523;" src="https://www.youtube.com/embed/AmC9SmCBUj4" title="Gordon Ramsay&#39;s ULTIMATE COOKERY COURSE: How to Cook the Perfect Steak" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">How to Cook the Perfect Steak</h5>
                        <p class="card-text">Learn the techniques for achieving restaurant-quality steak at home.</p>
                    </div>
                    <div class="card-footer border-top-0">
                        <small class="text-muted"><i class="far fa-clock mr-1"></i> 12:45 minutes</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 searchable-item">
                <div class="card video-card h-100">
                    <div class="video-thumbnail" style="display: flex; justify-content: center;">
                        <iframe width="400" height="auto" style="aspect-ratio: 929/523;" src="https://www.youtube.com/embed/Xw_NgS8iqhU" title="Easy Artisan Bread Recipe | No Kneading!" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Artisan Bread Baking</h5>
                        <p class="card-text">Learn the secrets of baking bread with a touch of artistry.</p>
                    </div>
                    <div class="card-footer border-top-0">
                        <small class="text-muted"><i class="far fa-clock mr-1"></i> 18:30 minutes</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4 searchable-item">
                <div class="card video-card h-100">
                    <div class="video-thumbnail" style="display: flex; justify-content: center;">
                        <iframe width="400" height="auto" style="aspect-ratio: 929/523;" src="https://www.youtube.com/embed/OcBs5miKM2Y" title="10 Cooking Hacks | Save Money &amp; Time | creative explained" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">10 Essential Kitchen Hacks</h5>
                        <p class="card-text">Time-saving tricks and tips to make cooking easier and more efficient.</p>
                    </div>
                    <div class="card-footer border-top-0">
                        <small class="text-muted"><i class="far fa-clock mr-1"></i> 8:15 minutes</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include 'includes/footer.php';
?>

<script>
$(document).ready(function() {
    $('#resourceSearchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        
        // Filter individual items
        $('.searchable-item').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });

        // Hide sections that have no visible items
        $('.content-section').each(function() {
            var visibleItems = $(this).find('.searchable-item').filter(function() {
                return $(this).css('display') !== 'none';
            }).length;
            
            if (visibleItems === 0) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
        
        // Optional: Show "No results" message
        var totalVisible = $('.searchable-item:visible').length;
        $('#no-results-msg').remove();
        if (totalVisible === 0 && value.length > 0) {
            $('.search-section .container').append('<div id="no-results-msg" class="alert alert-info mt-3 text-center">No resources found matching your search.</div>');
        }
    });
});
</script>
