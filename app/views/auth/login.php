<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h2>Login to YanqR</h2>
        
        <?php if (isset($_GET['registered'])): ?>
            <div class="alert success">Registration successful! Please login.</div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form action="/yanqr_system/public/auth/login" method="POST" class="auth-form">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn primary">Login</button>
        </form>
        
        <p class="auth-link">
            Don't have an account? <a href="/yanqr_system/public/auth/register">Register here</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>