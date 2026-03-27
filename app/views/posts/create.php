<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="create-post-container">
    <div class="create-post-card">
        <h2>Create New Post</h2>
        
        <form action="/yanqr_system/public/post/create" method="POST" class="create-post-form">
            <div class="form-group">
                <label for="content">What's on your mind?</label>
                <textarea id="content" name="content" rows="5" required placeholder="Share your gaming moment..."></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn primary">Post</button>
                <a href="/yanqr_system/public/feed" class="btn secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>