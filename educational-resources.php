<?php
// Include database connection
require_once 'config/db.php';

// Include header
include 'includes/header.php';
?>

<!-- Educational Resources Hero Section -->
<section class="hero-section educational-hero">
    <div class="container text-center py-5">
        <h1 class="display-4">Educational Resources</h1>
        <p class="lead">Learn about renewable energy and sustainable cooking practices with our downloadable resources.</p>
    </div>
</section>


<!-- Educational Videos Section -->
<section class="edu-videos-section py-5">
    <div class="container">
        <h2 class="section-title mb-4">Educational Videos</h2>
        <p class="section-description mb-4">Watch our informative videos on renewable energy topics.</p>
        
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card video-card h-100">
                    <div class="video-thumbnail" style="display: flex; justify-content: center;">
                        <iframe width="400" height="auto" style="aspect-ratio: 929/523;" src="https://www.youtube.com/embed/G64pMW-ZTq4" title="SOLAR COOKING! All Season SOL COOK Demo - Sun Energy" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Introduction to Solar Cooking</h5>
                        <p class="card-text">Learn how to harness the sun's energy to cook delicious meals.</p>
                    </div>
                    <div class="card-footer border-top-0">
                        <small class="text-muted"><i class="far fa-clock mr-1"></i> 15:20 minutes</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card video-card h-100">
                    <div class="video-thumbnail" style="display: flex; justify-content: center;">
                        <iframe width="400" height="auto" style="aspect-ratio: 929/523;" src="https://www.youtube.com/embed/DwvwC17F6bM" title="What Are The Best Energy-efficient Kitchen Appliances? - Minimalist Home Life" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Creating an Energy-Efficient Kitchen</h5>
                        <p class="card-text">Tips for reducing energy consumption in your kitchen.</p>
                    </div>
                    <div class="card-footer border-top-0">
                        <small class="text-muted"><i class="far fa-clock mr-1"></i> 12:45 minutes</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card video-card h-100">
                    <div class="video-thumbnail" style="display: flex; justify-content: center;">
                        <iframe width="400" height="auto" style="aspect-ratio: 929/523;" src="https://www.youtube.com/embed/xS9XXy9kWdM" title="8 Sustainable Eating Habits For A Healthy Lifestyle (365 DAYS A YEAR)  | LiveLeanTV" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Sustainable Eating Practices</h5>
                        <p class="card-text">How your food choices impact the environment and what you can do about it.</p>
                    </div>
                    <div class="card-footer border-top-0">
                        <small class="text-muted"><i class="far fa-clock mr-1"></i> 18:30 minutes</small>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>


<!-- Infographics Section -->
<section class="infographics-section py-5 bg-primary">
    <div class="container">
        <h2 class="section-title mb-4 text-white">Infographics</h2>
        <p class="section-description mb-4 text-white">Visual guides to help you understand complex energy concepts.</p>
        
        <div class="row">
  <div class="col-md-6 mb-4">
    <div class="card infographic-card h-fit">
      <img src="assets/images/infographics/carbon-footprint.jpeg" class="card-img-top w-100" alt="Carbon Footprint of Foods" style="height: auto;">
      <div class="card-body">
        <h5 class="card-title">Carbon Footprint of Common Foods</h5>
        <p class="card-text">Compare the environmental impact of different food choices.</p>
        <a href="assets/images/infographics/carbon-footprint.jpeg" class="btn btn-outline-primary btn-sm">
          <i class="fas fa-download mr-1"></i> Download Infographic
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-6 mb-4">
    <div class="card infographic-card h-fit">
      <img src="assets/images/infographics/food-waste.jpeg" class="card-img-top w-100" alt="Reducing Food Waste" style="height: auto;">
      <div class="card-body">
        <h5 class="card-title">Reducing Food Waste</h5>
        <p class="card-text">Tips and strategies to minimize food waste in your kitchen.</p>
        <a href="assets/images/infographics/food-waste.jpeg" class="btn btn-outline-primary btn-sm">
          <i class="fas fa-download mr-1"></i> Download Infographic
        </a>
      </div>
    </div>
  </div>
</div>

    </div>
</section>

<!-- Sustainable Cooking Guides Section -->
<section class="guides-section py-5">
    <div class="container">
        <h2 class="section-title mb-4">Sustainable Cooking Guides</h2>
        <p class="section-description mb-4">Comprehensive resources for eco-friendly cooking practices.</p>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-leaf text-primary mr-2"></i> Zero-Waste Cooking Guide</h5>
                        <p class="card-text">Learn how to utilize every part of your ingredients and minimize kitchen waste.</p>
                        <a href="assets/ebooks/zerowaste_cookbook.pdf" class="btn btn-outline-primary btn-sm"><i class="fas fa-download mr-1"></i> Download Guide</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-bolt text-primary mr-2"></i> Energy-Saving Cooking Techniques</h5>
                        <p class="card-text">Methods and practices to reduce energy consumption while preparing meals.</p>
                        <a href="assets/ebooks/energy-efficient-cooking.pdf" class="btn btn-outline-primary btn-sm"><i class="fas fa-download mr-1"></i> Download Guide</a>
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