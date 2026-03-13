<!-- Kini ang view file para sa profile page.
Nag display siya og profile information sa user, sama sa profile picture, full name, username,
bio, location, favorite game, ug level. Kung ang profile kay sa naka log in nga user, makita pud
niya ang edit button para i edit ang iyang profile. Sa ubos sa profile information, makita pud
niya ang listahan sa iyang mga posts. Ang mga posts nga makita diri kay gikan sa 
ProfileController nga nag fetch sa user's posts base sa iyang user ID. -->
<?php require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\header.php'; ?>

<div class="profile-container">
    <div class="profile-cover">
        <?php if ($is_owner): ?>
            <a href="/yanqr_system/public/profile/edit" class="edit-cover-btn">
                <i class="fas fa-camera"></i> Edit Cover
            </a>
        <?php endif; ?>
    </div>
    
    <div class="profile-info">
        <div class="profile-avatar-wrapper">
            <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $user['profile_image'] ?? 'default-avatar.png'; ?>" 
                 alt="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" class="profile-avatar-large">
            <?php if ($is_owner): ?>
                <a href="/yanqr_system/public/profile/edit" class="edit-avatar-btn">
                    <i class="fas fa-camera"></i>
                </a>
            <?php endif; ?>
        </div>
        
        <div class="profile-details">
            <h1><?php echo htmlspecialchars($user['full_name'] ?? 'Unknown User'); ?></h1>
            <p class="profile-username">@<?php echo htmlspecialchars($user['username'] ?? 'unknown'); ?></p>
            
            <?php if (!empty($user['bio'])): ?>
                <p class="profile-bio"><?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
            <?php endif; ?>
            
            <div class="profile-meta">
                <?php if (!empty($user['location'])): ?>
                    <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($user['location']); ?></span>
                <?php endif; ?>
                
                <?php if (!empty($user['favorite_game'])): ?>
                    <span><i class="fas fa-gamepad"></i> <?php echo htmlspecialchars($user['favorite_game']); ?></span>
                <?php endif; ?>
                
                <span><i class="fas fa-calendar"></i> Joined <?php echo isset($user['created_at']) ? date('F Y', strtotime($user['created_at'])) : 'Recently'; ?></span>
            </div>
            
            <div class="profile-level">
                <span class="level-badge">Level <?php echo $user['level'] ?? 1; ?></span>
            </div>
        </div>
        
        <div class="profile-stats">
            <div class="stat-item">
                <span class="stat-value"><?php echo count($posts); ?></span>
                <span class="stat-label">Posts</span>
            </div>
        </div>
        
        <?php if (!$is_owner): ?>
            <div class="profile-actions">
                <button class="btn primary" onclick="window.location.href='/yanqr_system/public/message/<?php echo $user['username']; ?>'">
                    <i class="fas fa-envelope"></i> Message
                </button>
            </div>
        <?php else: ?>
            <div class="profile-actions">
                <a href="/yanqr_system/public/profile/edit" class="btn primary">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="profile-tabs">
        <button class="tab-btn active" onclick="showTab('posts')">Posts</button>
    </div>
    
    <div class="tab-content">
        <div id="posts-tab" class="tab-pane active">
            <?php if (empty($posts)): ?>
                <div class="no-posts">
                    <i class="fas fa-newspaper"></i>
                    <h3>No posts yet</h3>
                    <?php if ($is_owner): ?>
                        <p>Share your first gaming moment!</p>
                        <a href="/yanqr_system/public/post/create" class="btn primary">Create Post</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <div class="post-header">
                            <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $user['profile_image'] ?? 'default-avatar.png'; ?>" 
                                 alt="" class="post-avatar">
                            <div class="post-info">
                                <h3><?php echo htmlspecialchars($user['full_name'] ?? ''); ?></h3>
                                <span class="post-date"><?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                            </div>
                        </div>
                        
                        <div class="post-content">
                            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                            <?php if (!empty($post['game_tag'])): ?>
                                <span class="game-tag"><i class="fas fa-tag"></i> <?php echo htmlspecialchars($post['game_tag']); ?></span>
                            <?php endif; ?>
                            
                            <?php if (!empty($post['image'])): ?>
                                <img src="/yanqr_system/public/assets/uploads/posts/<?php echo $post['image']; ?>" 
                                     alt="Post image" class="post-image">
                            <?php endif; ?>
                        </div>
                        
                        <div class="post-stats">
                            <span><i class="fas fa-heart"></i> <?php echo $post['like_count'] ?? 0; ?></span>
                            <span><i class="fas fa-comment"></i> <?php echo $post['comment_count'] ?? 0; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    document.querySelectorAll('.tab-pane').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.getElementById(tabName + '-tab').classList.add('active');
    event.target.classList.add('active');
}
</script>

<?php require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\footer.php'; ?>