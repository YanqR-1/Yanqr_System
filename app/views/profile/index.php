<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="profile-header">
    <!-- Circle Avatar - FIXED -->
    <div class="avatar-section">
        <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $user['avatar'] ?? 'default-avatar.png'; ?>" 
             class="profile-avatar-circle" 
             alt="Profile Avatar">
        <?php if ($is_owner): ?>
        <form action="/yanqr_system/public/profile/avatar" method="POST" enctype="multipart/form-data" class="avatar-upload-form">
            <label for="avatar-upload" class="avatar-edit-btn">
                <i class="fas fa-camera"></i>
            </label>
            <input type="file" name="avatar" id="avatar-upload" accept="image/*" style="display: none;" onchange="this.form.submit()">
        </form>
        <?php endif; ?>
    </div>
    
    <!-- Profile Info -->
    <div class="profile-info">
        <h2><?php echo htmlspecialchars($user['username']); ?></h2>
        <p class="profile-fullname"><?php echo htmlspecialchars($user['full_name'] ?? 'FORD'); ?></p>
        
        <?php if (!empty($user['bio'])): ?>
            <div class="profile-bio">
                <?php echo nl2br(htmlspecialchars($user['bio'])); ?>
            </div>
        <?php endif; ?>
        
        <div class="profile-stats">
            <div class="stat-item">
                <span class="stat-number"><?php echo count($posts); ?></span>
                <span class="stat-label">Posts</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">0</span>
                <span class="stat-label">Followers</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">0</span>
                <span class="stat-label">Following</span>
            </div>
        </div>
        
        <div class="member-badge">
            <i class="fas fa-calendar-alt"></i> Member since <?php echo date('M Y', strtotime($user['created_at'])); ?>
        </div>
    </div>
</div>

<div class="profile-posts">
    <h3>My Posts</h3>
    <?php if (empty($posts)): ?>
        <div class="no-posts">No posts yet. Create your first post!</div>
    <?php endif; ?>
    
    <?php foreach ($posts as $post): ?>
        <div class="post-card">
            <div class="post-content">
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            </div>
            <div class="post-stats">
                <span><i class="fas fa-heart"></i> <?php echo $post['likes_count'] ?? 0; ?></span>
                <span><i class="fas fa-comment"></i> <?php echo $post['comments_count'] ?? 0; ?></span>
            </div>
            <div class="post-date"><?php echo date('M d, Y', strtotime($post['created_at'])); ?></div>
        </div>
    <?php endforeach; ?>
</div>

<style>
.profile-header {
    display: flex;
    gap: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    flex-wrap: wrap;
    align-items: center;
}

.avatar-section {
    position: relative;
    flex-shrink: 0;
}

.profile-avatar-circle {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #FFD700;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    background: #1a1a2e;
}

.avatar-edit-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: #FFD700;
    color: #1a1a2e;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    border: 2px solid #1a1a2e;
    font-size: 16px;
}

.avatar-edit-btn:hover {
    transform: scale(1.1);
    background: #CCB000;
}

.profile-info {
    flex: 1;
}

.profile-info h2 {
    color: #FFD700;
    font-size: 28px;
    margin-bottom: 5px;
}

.profile-fullname {
    color: #ccc;
    font-size: 16px;
    margin-bottom: 10px;
}

.profile-bio {
    background: rgba(0, 0, 0, 0.3);
    padding: 12px 15px;
    border-radius: 10px;
    margin: 15px 0;
    line-height: 1.5;
}

.profile-stats {
    display: flex;
    gap: 30px;
    margin: 15px 0;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 24px;
    font-weight: bold;
    color: #FFD700;
}

.stat-label {
    color: #888;
    font-size: 12px;
}

.member-badge {
    display: inline-block;
    background: rgba(255, 215, 0, 0.1);
    border: 1px solid #FFD700;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    color: #FFD700;
}

@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-avatar-circle {
        width: 120px;
        height: 120px;
    }
    
    .avatar-edit-btn {
        width: 35px;
        height: 35px;
        bottom: 5px;
        right: 5px;
        font-size: 14px;
    }
    
    .profile-stats {
        justify-content: center;
    }
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>