<!-- Kini ang view file para sa edit profile page. 
Nag display siya og form para sa pag edit sa profile information sa user, sama sa full name,
bio, location, favorite game, ug profile picture. Ang form mag submit sa POST request ngadto
sa ProfileController para i update ang user's profile. -->
<?php require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\header.php'; ?>

<div class="edit-profile-container">
    <div class="edit-profile-card">
        <h2><i class="fas fa-user-edit"></i> Edit Profile</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form action="/yanqr_system/public/profile/edit" method="POST" enctype="multipart/form-data" class="edit-profile-form">
            <div class="avatar-upload-section">
                <label>Profile Picture</label>
                <div class="current-avatar">
                    <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $user['profile_image'] ?? 'default-avatar.png'; ?>" 
                         alt="Current Avatar" id="avatarPreview" class="avatar-preview">
                    <div class="avatar-overlay">
                        <i class="fas fa-camera"></i>
                        <span>Change Photo</span>
                    </div>
                </div>
                <input type="file" id="profile_image" name="profile_image" accept="image/*" style="display: none;">
            </div>
            
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4"><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($user['location'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="favorite_game">Favorite Game</label>
                <input type="text" id="favorite_game" name="favorite_game" value="<?php echo htmlspecialchars($user['favorite_game'] ?? ''); ?>">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="/yanqr_system/public/profile" class="btn secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelector('.current-avatar').addEventListener('click', function() {
    document.getElementById('profile_image').click();
});

document.getElementById('profile_image').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    }
});
</script>

<?php require_once 'C:\\Xampp\\htdocs\\yanqr_system\\app\\views\\layouts\\footer.php'; ?>