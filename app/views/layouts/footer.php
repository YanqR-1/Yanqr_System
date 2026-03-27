    </main>
    
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="quick-post">
        <button onclick="window.location.href='/yanqr_system/public/post/create'" class="quick-post-btn">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    <?php endif; ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/yanqr_system/public/assets/js/app.js"></script>
</body>
</html>