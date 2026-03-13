    </main>
    <!-- para ni sa pinaka ubos na area like sa log in sa SMCC Portal katong "22026 © SMCC" -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="quick-post">
        <button onclick="window.location.href='/yanqr_system/public/post/create'" class="quick-post-btn">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    <?php endif; ?>
    
    <script src="/yanqr_system/public/assets/js/app.js"></script>
</body>
</html>