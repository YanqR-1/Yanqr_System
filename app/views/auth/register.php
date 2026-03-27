<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h2>Join YanqR</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form action="/yanqr_system/public/auth/register" method="POST" class="auth-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <small>Minimum 4 characters</small>
            </div>
            
            <div class="form-group">
                <label for="bio">Bio (Optional)</label>
                <textarea id="bio" name="bio" rows="3"></textarea>
            </div>
            
            <button type="submit" class="btn primary">Register</button>
        </form>
        
        <p class="auth-link">
            Already have an account? <a href="/yanqr_system/public/auth/login">Login here</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>