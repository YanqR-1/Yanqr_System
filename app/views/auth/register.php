<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - YanqR</title>
    <link rel="stylesheet" href="/yanqr_system/public/assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h2>Join YanqR</h2>
            <!--error message kung naay error sa registration-->
            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <!--error message kung naay mali sa registration form-->
            <?php if (!empty($errors)): ?>
                <div class="alert error">
                    <?php foreach ($errors as $err): ?>
                        <p><?php echo htmlspecialchars($err); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <!--registration form ni siya-->
            <form action="/yanqr_system/public/auth/register" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <small>Minimum 6 characters</small>
                </div>
                
                <div class="form-group">
                    <label for="bio">Bio (Optional)</label>
                    <textarea id="bio" name="bio" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="location">Location (Optional)</label>
                    <input type="text" id="location" name="location">
                </div>
                <div class="form-group">
                    <label for="favorite_game">Favorite Game (Optional)</label>
                    <input type="text" id="favorite_game" name="favorite_game">
                </div>
                <!--register button-->
                <button type="submit" class="btn primary">Register</button>
            </form>
            <!--linked file for login area/button ni-->
            <p class="auth-link">
                Already have an account? <a href="/yanqr_system/public/auth/login">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>