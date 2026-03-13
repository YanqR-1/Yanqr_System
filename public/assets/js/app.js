// Kini ang JavaScript file para sa application.
// Nag handle siya sa mga interactive features sama sa like button, 
// delete confirmation, ug auto-hide sa alerts.
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
            const countSpan = form.closest('.post-card').querySelector('.post-stats span:first-child');
            
            if (data.action === 'liked') {
                btn.classList.add('liked');
                icon.classList.remove('far');
                icon.classList.add('fas');
            } else {
                btn.classList.remove('liked');
                icon.classList.remove('fas');
                icon.classList.add('far');
            }
            
            countSpan.innerHTML = `<i class="fas fa-heart"></i> ${data.count}`;
        }
    });
});

// Confirm delete
document.querySelectorAll('.delete-btn, .delete-comment-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        if (!confirm('Are you sure?')) {
            e.preventDefault();
        }
    });
});

// Auto-hide alerts
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }, 5000);
});