// Like button AJAX
document.querySelectorAll('.like-form').forEach(form => {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(form);
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            const btn = form.querySelector('.like-btn');
            const icon = btn.querySelector('i');
            const likeText = btn.querySelector('.like-text');
            const countDisplay = form.closest('.post-card').querySelector('.like-count-display');
            
            if (data.action === 'liked') {
                btn.classList.add('liked');
                icon.classList.remove('far');
                icon.classList.add('fas');
                if (likeText) likeText.textContent = 'Liked';
            } else {
                btn.classList.remove('liked');
                icon.classList.remove('fas');
                icon.classList.add('far');
                if (likeText) likeText.textContent = 'Like';
            }
            
            if (countDisplay) {
                countDisplay.innerHTML = `<i class="fas fa-heart"></i> ${data.count}`;
            }
        }
    });
});

// Confirm delete for posts and comments
document.querySelectorAll('.delete-btn, .delete-comment-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        if (!confirm('Are you sure you want to delete this?')) {
            e.preventDefault();
        }
    });
});

// Auto-hide alerts after 5 seconds
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }, 5000);
});

// Show/hide comment form
window.toggleCommentForm = function(postId) {
    const form = document.getElementById('comment-form-' + postId);
    if (form) {
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'flex';
            form.querySelector('input').focus();
        } else {
            form.style.display = 'none';
        }
    }
};

// Preview avatar before upload
document.getElementById('avatar')?.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.profile-avatar');
            if (preview) preview.src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    }
});