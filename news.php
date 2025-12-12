<?php
// Include database connection
require_once 'config/db.php';

// Include header
include 'includes/header.php';
?>

<!-- News Hero Section -->
<section class="hero-section news-hero">
    <div class="container text-center py-5">
        <h1 class="display-4">News & Updates</h1>
        <p class="lead">Stay up to date with the latest from FoodFusion.</p>
    </div>
</section>

<?php
// Fetch news articles
$news_query = "SELECT id, title, content, image_path, created_at FROM news ORDER BY created_at DESC";
$news_result = mysqli_query($conn, $news_query);
?>

<section class="container py-5">
    <div class="row">
        <?php if ($news_result && mysqli_num_rows($news_result) > 0): ?>
            <?php while ($article = mysqli_fetch_assoc($news_result)): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($article['image_path'])): ?>
                            <img src="<?php echo $article['image_path']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($article['title']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                            <?php 
                                $snippet = strip_tags($article['content']);
                                $is_long = strlen($snippet) > 180;
                                $snippet = $is_long ? substr($snippet, 0, 180) . '...' : $snippet;
                            ?>
                            <p class="card-text"><?php echo htmlspecialchars($snippet); ?></p>
                        </div>
                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="far fa-clock mr-1"></i>
                                <?php echo date('M j, Y', strtotime($article['created_at'])); ?>
                            </small>
                            <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#newsModal<?php echo $article['id']; ?>">Read More</button>
                        </div>
                    </div>
                </div>

                <!-- News Modal -->
                <div class="modal fade" id="newsModal<?php echo $article['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="newsModalLabel<?php echo $article['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newsModalLabel<?php echo $article['id']; ?>"><?php echo htmlspecialchars($article['title']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php if (!empty($article['image_path'])): ?>
                                    <img src="<?php echo $article['image_path']; ?>" class="img-fluid rounded mb-3" alt="<?php echo htmlspecialchars($article['title']); ?>">
                                <?php endif; ?>
                                <p class="text-muted mb-2"><i class="far fa-clock mr-1"></i> <?php echo date('M j, Y', strtotime($article['created_at'])); ?></p>
                                <div>
                                    <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    No news articles yet. Check back soon!
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
// Include footer
include 'includes/footer.php';
?>