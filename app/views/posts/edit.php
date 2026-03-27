<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="edit-post-container">
    <div class="edit-post-card">
        <h2><i class="fas fa-edit"></i> Edit Post</h2>
        
        <form action="/yanqr_system/public/post/update/<?php echo $post['id']; ?>" method="POST" class="edit-post-form">
            <div class="form-group">
                <label for="content">Edit your post</label>
                <textarea id="content" name="content" rows="5" required class="form-control"><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn primary">
                    <i class="fas fa-save"></i> Update Post
                </button>
                <a href="/yanqr_system/public/feed" class="btn secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.edit-post-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 200px);
    padding: 20px;
}

.edit-post-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 2px solid var(--primary);
    border-radius: 15px;
    padding: 30px;
    width: 100%;
    max-width: 600px;
}

.edit-post-card h2 {
    color: var(--primary);
    text-align: center;
    margin-bottom: 30px;
}

.edit-post-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.form-group label {
    font-weight: bold;
    color: var(--light);
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid var(--gray);
    border-radius: 8px;
    background: rgba(0, 0, 0, 0.3);
    color: var(--light);
    font-family: inherit;
    resize: vertical;
    font-size: 16px;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.form-actions .btn {
    flex: 1;
    padding: 12px;
    text-align: center;
    text-decoration: none;
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>