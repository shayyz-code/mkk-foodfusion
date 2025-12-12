<?php
// Include database connection
require_once 'config/db.php';

// Include header
include 'includes/header.php';
?>

<!-- Contact Us Hero Section -->
<section class="hero-section contact-hero">
    <div class="container text-center py-5">
        <h1 class="display-4">Contact Us</h1>
        <p class="lead">We'd love to hear from you! Reach out with questions, feedback, or recipe requests.</p>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-form-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>Get in Touch</h2>
                <p>Have a question about a recipe? Want to suggest a new feature? Or just want to say hello? Fill out the form and we'll get back to you as soon as possible.</p>
                
                <?php if (isset($_SESSION['contact_message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['contact_message_type']; ?> alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['contact_message']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php 
                    // Clear the message after displaying
                    unset($_SESSION['contact_message']);
                    unset($_SESSION['contact_message_type']);
                    ?>
                <?php endif; ?>
                
                <form id="contactForm" action="process_contact.php" method="POST">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select class="form-control" id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Recipe Request">Recipe Request</option>
                            <option value="Feedback">Feedback</option>
                            <option value="Technical Issue">Technical Issue</option>
                            <option value="Partnership">Partnership Opportunity</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
            <div class="col-lg-6">
                <div class="contact-info mt-5 mt-lg-0">
                    <h2>Contact Information</h2>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-map-marker-alt text-primary mr-2"></i> Our Location</h5>
                            <p class="card-text">Yaw Min Gyi Street, Dagon District<br>Yangon City, Myanmar</p>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-phone text-primary mr-2"></i> Phone</h5>
                            <p class="card-text">(959) 456-7890</p>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-envelope text-primary mr-2"></i> Email</h5>
                            <p class="card-text">info@foodfusion.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5 bg-primary">
    <div class="container">
        <h2 class="text-center mb-5 text-white">Frequently Asked Questions</h2>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="card">
                        <div class="card-header" id="faqOne">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left text-primary" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How can I submit my own recipe?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="faqOne" data-parent="#faqAccordion">
                            <div class="card-body">
                                You can submit your own recipe by visiting our "Submit Recipe" page. You'll need to be logged in to submit a recipe. Once submitted, our team will review it and publish it to the community cookbook.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="faqTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left collapsed text-primary" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How do I save my favorite recipes?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse show" aria-labelledby="faqTwo" data-parent="#faqAccordion">
                            <div class="card-body">
                                To save your favorite recipes, you need to create an account and log in. Once logged in, you can click the "Save" button on any recipe page to add it to your favorites. You can access your saved recipes from your profile page.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="faqThree">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left collapsed text-primary" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Can I request a specific recipe?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse show" aria-labelledby="faqThree" data-parent="#faqAccordion">
                            <div class="card-body">
                                Yes! You can request specific recipes by using the contact form on this page. Select "Recipe Request" as the subject and provide details about the recipe you're looking for. Our culinary team will try to create and share the requested recipe.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="faqFour">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left collapsed text-primary" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    How can I become a contributor?
                                </button>
                            </h2>
                        </div>
                        <div id="collapseFour" class="collapse show" aria-labelledby="faqFour" data-parent="#faqAccordion">
                            <div class="card-body">
                                If you're interested in becoming a regular contributor to FoodFusion, please contact us using the form on this page. Select "Partnership" as the subject and tell us about your culinary background and interests. We're always looking for passionate food enthusiasts to join our community!
                            </div>
                        </div>
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