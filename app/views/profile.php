<div class="profile">
    <div class="profile-header">
        <div class="avatar-section">
            <img src="/yanqr_lite/public/assets/uploads/avatars/<?php echo $user['avatar'] ?? 'default.png'; ?>" class="avatar-large">
            <form action="/yanqr_lite/public/profile/avatar" method="POST" enctype="multipart/form-data" class="avatar-form">
                <label for="avatar" class="avatar-btn">Change Avatar</label>
                <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;" onchange="this.form.submit()">
            </form>
        </div>
        <div class="profile-info">
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>
            <p>Member since <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
            <p><strong><?php echo count($posts); ?></strong> posts</p>
        </div>
    </div>
    
    <div class="profile-posts">
        <h3>My Posts</h3>
        <?php if (empty($posts)): ?>
            <div class="no-posts">No posts yet. Create your first post!</div>
        <?php endif; ?>
        
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <div class="post-content">
                    <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                </div>
                <small><?php echo date('M d, Y', strtotime($post['created_at'])); ?></small>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.profile-header {
    display: flex;
    gap: 30px;
    align-items: center;
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}
.avatar-section {
    text-align: center;
}
.avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 3px solid #FFD700;
    margin-bottom: 10px;
}
.avatar-btn {
    display: inline-block;
    padding: 6px 12px;
    background: #FFD700;
    color: #1a1a2e;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    font-weight: bold;
}
.avatar-btn:hover {
    background: #CCB000;
}
.profile-info h2 {
    color: #FFD700;
    margin-bottom: 5px;
}
.profile-info p {
    margin: 5px 0;
    color: #ccc;
}
.profile-posts h3 {
    margin-bottom: 20px;
    color: #FFD700;
}
.profile-posts .post {
    margin-bottom: 15px;
}
.profile-posts .post-content {
    margin-bottom: 8px;
}
.profile-posts small {
    color: #888;
    font-size: 12px;
}
</style>