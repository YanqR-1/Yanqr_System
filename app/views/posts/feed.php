<!-- Kini ang view file para sa newsfeed o feed sa mga posts.-->
<div class="feed-container">
    <div class="feed-main">
        <?php if (empty($posts)): ?>
            <div class="no-posts">
                <i class="fas fa-newspaper"></i>
                <h3>No posts yet</h3>
                <a href="/yanqr_system/public/post/create" class="btn primary">Create Post</a>
            </div>
        <?php endif; ?>
        <!-- loop sa mga posts nga gikan sa PostController, nag display sa profile image, name, username, content, game tag, image, likes, comments, ug actions para sa like, comment, delete -->
        <?php foreach ($posts as $post): ?>
        <div class="post-card">
            <div class="post-header">
                <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $post['profile_image'] ?? 'default-avatar.png'; ?>" 
                     alt="<?php echo $post['username']; ?>" class="post-avatar">
                <div class="post-info">
                    <h3><?php echo htmlspecialchars($post['full_name']); ?></h3>
                    <span class="username">@<?php echo htmlspecialchars($post['username']); ?></span>
                    <span class="post-date"><?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                </div>
            </div>
        
        <div class="post-content">
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <?php if (!empty($post['game_tag'])): ?>
                    <span class="game-tag"><i class="fas fa-tag"></i> <?php echo htmlspecialchars($post['game_tag']); ?></span>
                    <?php endif; ?>
                    <!-- optional nga section para sa pag display sa image nga gi upload sa post, makita ra siya kung naay image ang post -->
                    <?php if (!empty($post['image'])): ?>
                        <img src="/yanqr_system/public/assets/uploads/posts/<?php echo $post['image']; ?>" 
                             alt="Post image" class="post-image">
                    <?php endif; ?>
                </div>
                <!-- post stats nga nag show sa number of likes ug comments sa post, gamit ang mga icons para mas visually appealing -->
                <div class="post-stats">
                    <span><i class="fas fa-heart"></i> <?php echo $post['like_count'] ?? 0; ?></span>
                    <span><i class="fas fa-comment"></i> <?php echo $post['comment_count'] ?? 0; ?></span>
                </div>
                <!-- post actions para sa pag like, comment, ug delete sa post. Ang delete button makita ra siya kung ang nag post kay mao pud ang naka log in nga user -->
                <div class="post-actions">
                    <form action="/yanqr_system/public/like/toggle" method="POST" class="like-form">
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                        <button type="submit" class="like-btn <?php echo isset($post['user_liked']) && $post['user_liked'] ? 'liked' : ''; ?>">
                            <i class="<?php echo isset($post['user_liked']) && $post['user_liked'] ? 'fas' : 'far'; ?> fa-heart"></i> Like
                        </button>
                    </form>
                    
                    <button onclick="showCommentForm(<?php echo $post['id']; ?>)" class="comment-btn">
                        <i class="far fa-comment"></i> Comment
                    </button>
                    
                    <?php if ($post['user_id'] == $_SESSION['user_id']): ?>
                        <form action="/yanqr_system/public/post/delete/<?php echo $post['id']; ?>" method="POST" 
                              onsubmit="return confirm('Delete this post?');">
                            <button type="submit" class="delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
                <!-- comments section nga makita ra kung i click ang comment button, nag loop sa mga comments sa post ug nag display sa commenter's profile image, name, content, ug date. Ang delete button para sa comment makita ra siya kung ang nag comment kay mao pud ang naka log in nga user -->
                <div class="comments-section">
                    <?php if (!empty($post['comments'])): ?>
                        <?php foreach ($post['comments'] as $comment): ?>
                            <div class="comment">
                                <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $comment['profile_image'] ?? 'default-avatar.png'; ?>" 
                                     alt="<?php echo $comment['username']; ?>" class="comment-avatar">
                                <div class="comment-content">
                                    <div class="comment-header">
                                        <strong><?php echo htmlspecialchars($comment['full_name']); ?></strong>
                                        <span class="comment-date"><?php echo date('M d', strtotime($comment['created_at'])); ?></span>
                                    </div>
                                    <p><?php echo htmlspecialchars($comment['content']); ?></p>
                                    <?php if ($comment['user_id'] == $_SESSION['user_id']): ?>
                                        <form action="/yanqr_system/public/comment/delete/<?php echo $comment['id']; ?>" 
                                              method="POST" class="delete-comment-form">
                                            <button type="submit" class="delete-comment-btn">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- comment form nga makita ra kung i click ang comment button, para dali ra sa user mag comment sa post -->
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
    <!-- sidebar sa newsfeed nga nag show sa suggested players nga pwede nimo i follow, makita 
    ra ni siya sa right side sa screen kung naka log in ang user -->
    <div class="feed-sidebar">
        <div class="sidebar-card">
            <h3>Suggested Players</h3>
            <?php if (!empty($suggested_users)): ?>
                <?php foreach ($suggested_users as $user): ?>
                    <div class="suggested-user">
                        <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $user['profile_image'] ?? 'default-avatar.png'; ?>" 
                             alt="<?php echo $user['username']; ?>" class="suggested-avatar">
                        <div class="suggested-info">
                            <h4><?php echo htmlspecialchars($user['full_name']); ?></h4>
                            <span>@<?php echo htmlspecialchars($user['username']); ?></span>
                        </div>
                        <a href="/yanqr_system/public/profile/<?php echo $user['username']; ?>" class="btn small">View</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function showCommentForm(postId) {
    const form = document.getElementById('comment-form-' + postId);
    form.style.display = form.style.display === 'none' ? 'flex' : 'none';
}
</script>