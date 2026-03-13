<!-- Kini ang view file para sa search results page.
Nag display siya og search results para sa users ug posts base sa search query nga gi submit sa
SearchController. Ang mga results kay gipakita sa duha ka sections: Users ug Posts.
Kung walay results nga makita, mag display siya og message nga "No results found". -->
<?php require_once '../app/views/layouts/header.php'; ?>

<div class="search-container">
    <h2>Search Results for "<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"</h2>
    
    <?php if (!empty($users)): ?>
        <div class="search-section">
            <h3>Users</h3>
            <div class="users-grid">
                <?php foreach ($users as $user): ?>
                    <div class="user-card">
                        <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $user['profile_image'] ?? 'default-avatar.png'; ?>" 
                             alt="<?php echo $user['username']; ?>" class="user-avatar">
                        <div class="user-info">
                            <h4><?php echo htmlspecialchars($user['full_name']); ?></h4>
                            <p>@<?php echo htmlspecialchars($user['username']); ?></p>
                            <p>Level <?php echo $user['level'] ?? 1; ?></p>
                        </div>
                        <a href="/yanqr_system/public/profile/<?php echo $user['username']; ?>" class="btn small">View Profile</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($posts)): ?>
        <div class="search-section">
            <h3>Posts</h3>
            <div class="posts-list">
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <div class="post-header">
                            <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $post['profile_image'] ?? 'default-avatar.png'; ?>" 
                                 alt="<?php echo $post['username']; ?>" class="post-avatar">
                            <div class="post-info">
                                <h4><?php echo htmlspecialchars($post['full_name']); ?></h4>
                                <span>@<?php echo htmlspecialchars($post['username']); ?></span>
                            </div>
                            <span class="post-date"><?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                        </div>
                        <div class="post-content">
                            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        </div>
                        <a href="/yanqr_system/public/feed#post-<?php echo $post['id']; ?>" class="btn small">View Post</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (empty($users) && empty($posts)): ?>
        <div class="no-results">
            <i class="fas fa-search" style="font-size: 48px; color: var(--primary); margin-bottom: 20px;"></i>
            <h3>No results found</h3>
            <p>Try different keywords</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>