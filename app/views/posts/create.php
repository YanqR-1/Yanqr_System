<!-- Kini ang view file para sa paghimo og bag-ong post. Apil diri sa usa ka porma 
diin ang mga tiggamit makasulod sa ilang sulud sa post, opsyonal nga makadugang usa ka
tag sa dula ug usa ka imahe. Ang nag post sa pamaagi sa paghimo sa PostController. -->
<?php require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\header.php'; ?>

<div class="create-post-container">
    <div class="create-post-card">
        <h2>Create New Post</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <!-- form para sa paghimo og post, nag gamit og POST method ug enctype para sa file upload -->
        <form action="/yanqr_system/public/post/create" method="POST" enctype="multipart/form-data" class="create-post-form">
            <div class="form-group">
                <label for="content">What's on your mind?</label>
                <textarea id="content" name="content" rows="5" required placeholder="Share your gaming moment..."></textarea>
            </div>
            <!-- optional nga field para sa game tag aron ma categorize ang post base sa dula nga gi post -->
            <div class="form-group">
                <label for="game_tag">Game Tag (Optional)</label>
                <input type="text" id="game_tag" name="game_tag" placeholder="e.g., Adventure Quest">
            </div>
            <!-- optional nga field para sa pag upload og image nga related sa post, sama sa screenshot sa dula -->
            <div class="form-group">
                <label for="image">Add Image (Optional)</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <!-- buttons para sa pag submit sa post o pag cancel ug balik sa newsfeed -->
            <div class="form-actions">
                <button type="submit" class="btn primary">Post</button>
                <a href="/yanqr_system/public/feed" class="btn secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<!-- ang quick post button nga makita ra sa ubos nga area sa screen kung naka log in ang user, para dali ra sila maka access sa paghimo og post bisan asa sila sa site -->
<?php require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\footer.php'; ?>