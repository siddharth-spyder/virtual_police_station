<footer>
        <div class="container">
            <p>&copy; 2025 Virtual Police Station - Government of Tamil Nadu. All rights reserved.</p>
            <p>सत्यमेव जयते | Truth Alone Triumphs</p>
        </div>
    </footer>

    <script>
        // Simple form validation and UX improvements
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading states to buttons
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML += ' <span class="loading"></span>';
                    }
                });
            });

            // Add hover effects to cards
            const cards = document.querySelectorAll('.dashboard-card, .form-container');
            cards.forEach(card => {
                card.classList.add('hover-lift');
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>