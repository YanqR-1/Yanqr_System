<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - YanqR</title>
    <link rel="stylesheet" href="/yanqr_system/public/assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h2>Login to YanqR</h2>
            <!--success message kung successful ang registration-->
            <?php if (isset($_GET['registered'])): ?>
                <div class="alert success">Registration successful! Please login.</div>
            <?php endif; ?>
            <!--error message kung mali ang username or password-->
            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <!--login form ni siya-->
            <form action="/yanqr_system/public/auth/login" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="username">Username or Email</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <!--butangan ug password-->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <!--login button-->
                <button type="submit" class="btn primary">Login</button>
            </form>
            <!--linked file for registration area/button ni-->
            <p class="auth-link">
                Don't have an account? <a href="/yanqr_system/public/auth/register">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>