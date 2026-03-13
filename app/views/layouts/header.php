<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YanqR - Social Network for Gamers</title>
    <link rel="stylesheet" href="/yanqr_system/public/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- navigation bar ni siya nga makita ra kung naka log in ang user -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="/yanqr_system/public/feed">YanqR</a>
            </div>
            <!-- search box para sa pag search sa posts or users -->
            <div class="search-box">
                <form action="/yanqr_system/public/post/search" method="GET">
                    <input type="text" name="q" placeholder="Search posts or users...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <!-- navigation links para sa home, profile, settings, logout -->
            <div class="nav-links">
                <a href="/yanqr_system/public/feed"><i class="fas fa-home"></i> Home</a>
                <a href="/yanqr_system/public/profile"><i class="fas fa-user"></i> Profile</a>
                <div class="dropdown">
                    <button class="dropbtn">
                        <!-- display sa profile image sa user like kanang profile nimo sa newsfeed sa facebook -->
                        <img src="/yanqr_system/public/assets/uploads/profiles/<?php echo $_SESSION['profile_image'] ?? 'default-avatar.png'; ?>" 
                             alt="Profile" class="nav-avatar">
                        <?php echo $_SESSION['username'] ?? 'User'; ?>
                    </button>
                    <!-- dropdown content para sa profile, settings, logout -->
                    <div class="dropdown-content">
                        <a href="/yanqr_system/public/profile">My Profile</a>
                        <a href="/yanqr_system/public/profile/edit">Settings</a>
                        <a href="/yanqr_system/public/auth/logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <?php endif; ?>
    <main class="container">