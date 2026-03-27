<div class="feed-container">
    <div class="feed-main">
        <!-- Create Post Form -->
        <div class="create-post-card">
            <form action="/yanqr_system/public/post/create" method="POST">
                <textarea name="content" placeholder="What's on your mind? 🎮" rows="3" required></textarea>
                <button type="submit" class="btn primary">Post</button>
            </form>
        </div>
        
        <!-- Posts Feed -->
        <?php if (empty($posts)): ?>
            <div class="no-posts">
                <i class="fas fa-newspaper"></i>
                <h3>No posts yet</h3>
                <p>Be the first to share something!</p>
            </div>
        <?php endif; ?>
        
        <?php foreach ($posts as $post): ?>
            <div class="post-card" id="post-<?php echo $post['id']; ?>">
                <div class="post-header">
                    <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $post['avatar'] ?? 'default-avatar.png'; ?>" 
                         alt="<?php echo $post['username']; ?>" class="post-avatar">
                    <div class="post-info">
                        <h3><?php echo htmlspecialchars($post['username']); ?></h3>
                        <span class="post-date"><?php echo date('M d, Y h:i A', strtotime($post['created_at'])); ?></span>
                    </div>
                    <?php if ($post['user_id'] == $_SESSION['user_id']): ?>
                        <div class="post-actions-buttons">
                            <a href="/yanqr_system/public/post/edit/<?php echo $post['id']; ?>" class="edit-post-btn" title="Edit Post">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/yanqr_system/public/post/delete/<?php echo $post['id']; ?>" method="POST" class="delete-post-form">
                                <button type="submit" class="delete-btn" onclick="return confirm('Delete this post?')" title="Delete Post">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="post-content">
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                </div>
                
                <div class="post-stats">
                    <span class="like-count-display">
                        <i class="fas fa-heart"></i> <?php echo $post['likes_count'] ?? 0; ?>
                    </span>
                    <span class="comment-count-display">
                        <i class="fas fa-comment"></i> <?php echo $post['comments_count'] ?? 0; ?>
                    </span>
                </div>
                
                <div class="post-actions">
                    <form action="/yanqr_system/public/like/toggle" method="POST" class="like-form">
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                        <button type="submit" class="like-btn <?php echo isset($post['user_liked']) && $post['user_liked'] ? 'liked' : ''; ?>">
                            <i class="<?php echo isset($post['user_liked']) && $post['user_liked'] ? 'fas' : 'far'; ?> fa-heart"></i>
                            <span class="like-text"><?php echo isset($post['user_liked']) && $post['user_liked'] ? 'Liked' : 'Like'; ?></span>
                        </button>
                    </form>
                    
                    <button onclick="toggleCommentForm(<?php echo $post['id']; ?>)" class="comment-btn">
                        <i class="far fa-comment"></i> Comment
                    </button>
                </div>
                
                <!-- Comments Section -->
                <div class="comments-section" id="comments-section-<?php echo $post['id']; ?>">
                    <div class="comments-list" id="comments-list-<?php echo $post['id']; ?>">
                        <?php if (!empty($post['comments'])): ?>
                            <?php foreach ($post['comments'] as $comment): ?>
                                <div class="comment" id="comment-<?php echo $comment['id']; ?>">
                                    <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $comment['avatar'] ?? 'default-avatar.png'; ?>" 
                                         alt="<?php echo $comment['username']; ?>" class="comment-avatar">
                                    <div class="comment-content">
                                        <div class="comment-header">
                                            <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                                            <span class="comment-date"><?php echo date('M d, h:i A', strtotime($comment['created_at'])); ?></span>
                                        </div>
                                        <p><?php echo htmlspecialchars($comment['content']); ?></p>
                                        <?php if ($comment['user_id'] == $_SESSION['user_id']): ?>
                                            <form action="/yanqr_system/public/comment/delete/<?php echo $comment['id']; ?>" 
                                                  method="POST" class="delete-comment-form">
                                                <button type="submit" class="delete-comment-btn" onclick="return confirm('Delete this comment?')">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Add Comment Form -->
                    <form action="/yanqr_system/public/comment/create" method="POST" class="comment-form" 
                          id="comment-form-<?php echo $post['id']; ?>" style="display: none;">
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                        <input type="text" name="content" placeholder="Write a comment..." required>
                        <button type="submit" class="btn small">Post</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Sidebar -->
    <div class="feed-sidebar">
        <div class="sidebar-card">
            <h3>Your Stats</h3>
            <div class="stats">
                <div class="stat">
                    <span class="stat-value"><?php echo count($posts); ?></span>
                    <span class="stat-label">Posts</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCommentForm(postId) {
    const form = document.getElementById('comment-form-' + postId);
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'flex';
    } else {
        form.style.display = 'none';
    }
}
</script>

<style>
.post-actions-buttons {
    display: flex;
    gap: 10px;
    margin-left: auto;
}

.edit-post-btn {
    background: none;
    border: none;
    color: var(--gray);
    cursor: pointer;
    padding: 5px;
    transition: color 0.3s;
    text-decoration: none;
    font-size: 16px;
}

.edit-post-btn:hover {
    color: var(--primary);
}
</style>