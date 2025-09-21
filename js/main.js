// Virtual Police Station - JavaScript Functionality

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeNavigation();
    initializeFormValidation();
    initializeInteractiveElements();
    initializeAnimations();
    initializeDashboard();
});

// Navigation
function initializeNavigation() {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
        
        // Close menu when clicking on links
        const navLinks = navMenu.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
            });
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('active');
            }
        });
    }
    
    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 1px 3px 0 rgba(0, 0, 0, 0.1)';
            }
        });
    }
}

// Form Validation
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    // Password confirmation validation
    const password = form.querySelector('input[name="password"]');
    const confirmPassword = form.querySelector('input[name="confirm_password"]');
    
    if (password && confirmPassword) {
        if (password.value !== confirmPassword.value) {
            showFieldError(confirmPassword, 'Passwords do not match');
            isValid = false;
        }
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        errorMessage = 'This field is required';
        isValid = false;
    }
    
    // Email validation
    else if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            errorMessage = 'Please enter a valid email address';
            isValid = false;
        }
    }
    
    // Phone validation
    else if (field.type === 'tel' && value) {
        const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
        if (!phoneRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
            errorMessage = 'Please enter a valid phone number';
            isValid = false;
        }
    }
    
    // Password validation
    else if (field.name === 'password' && value) {
        if (value.length < 6) {
            errorMessage = 'Password must be at least 6 characters long';
            isValid = false;
        }
    }
    
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
    }
    
    return isValid;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Interactive Elements
function initializeInteractiveElements() {
    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Button loading states
    const submitButtons = document.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.form && validateForm(this.form)) {
                this.classList.add('loading');
                this.disabled = true;
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    this.classList.remove('loading');
                    this.disabled = false;
                }, 5000);
            }
        });
    });
    
    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
    
    // Character counter for textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        if (maxLength) {
            const counter = document.createElement('div');
            counter.className = 'char-counter';
            counter.textContent = `0/${maxLength}`;
            textarea.parentNode.appendChild(counter);
            
            textarea.addEventListener('input', function() {
                const current = this.value.length;
                counter.textContent = `${current}/${maxLength}`;
                counter.style.color = current > maxLength * 0.9 ? 'var(--error-color)' : 'var(--dark-gray)';
            });
        }
    });
}

// Animations
function initializeAnimations() {
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.feature-card, .step-card, .stat-card');
    animateElements.forEach(el => {
        observer.observe(el);
    });
    
    // Stagger animations for grids
    const grids = document.querySelectorAll('.features-grid, .steps-grid, .stats-grid');
    grids.forEach(grid => {
        const items = grid.children;
        Array.from(items).forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
        });
    });
}

// Dashboard Functionality
function initializeDashboard() {
    if (!document.querySelector('.dashboard-container')) return;
    
    // Auto-refresh dashboard data every 30 seconds
    setInterval(refreshDashboardStats, 30000);
    
    // Initialize complaint status filters
    initializeStatusFilters();
    
    // Initialize search functionality
    initializeSearch();
}

function refreshDashboardStats() {
    // This would typically make an AJAX call to refresh stats
    // For now, we'll just add a visual indicator
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.style.transform = 'scale(1.02)';
        setTimeout(() => {
            card.style.transform = 'scale(1)';
        }, 200);
    });
}

function initializeStatusFilters() {
    const statusButtons = document.querySelectorAll('.status-filter');
    statusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.dataset.status;
            filterComplaintsByStatus(status);
            
            // Update active state
            statusButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

function filterComplaintsByStatus(status) {
    const rows = document.querySelectorAll('.table-body .table-row');
    rows.forEach(row => {
        const statusBadge = row.querySelector('.status-badge');
        if (!status || statusBadge.textContent.trim() === status) {
            row.style.display = 'grid';
        } else {
            row.style.display = 'none';
        }
    });
}

function initializeSearch() {
    const searchInput = document.querySelector('input[name="search"]');
    if (!searchInput) return;
    
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch(this.value);
        }, 300);
    });
}

function performSearch(query) {
    const rows = document.querySelectorAll('.table-body .table-row');
    const searchTerm = query.toLowerCase();
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (!searchTerm || text.includes(searchTerm)) {
            row.style.display = 'grid';
        } else {
            row.style.display = 'none';
        }
    });
}

// Utility Functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="notification-close">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showNotification('Copied to clipboard!', 'success');
    }).catch(() => {
        showNotification('Failed to copy to clipboard', 'error');
    });
}

// Export functions for global use
window.VPS = {
    showNotification,
    formatDate,
    copyToClipboard,
    validateForm,
    refreshDashboardStats
};

// Add CSS for dynamic elements
const dynamicStyles = `
    .field-error {
        color: var(--error-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .field-error::before {
        content: "⚠";
    }
    
    input.error,
    select.error,
    textarea.error {
        border-color: var(--error-color);
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .char-counter {
        text-align: right;
        font-size: 0.75rem;
        color: var(--dark-gray);
        margin-top: 0.25rem;
    }
    
    .notification {
        position: fixed;
        top: 2rem;
        right: 2rem;
        background: var(--white);
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-hover);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        z-index: 1000;
        animation: slideInRight 0.3s ease-out;
        max-width: 400px;
    }
    
    .notification-success {
        border-left: 4px solid var(--success-color);
        color: var(--success-color);
    }
    
    .notification-error {
        border-left: 4px solid var(--error-color);
        color: var(--error-color);
    }
    
    .notification-info {
        border-left: 4px solid var(--primary-color);
        color: var(--primary-color);
    }
    
    .notification-close {
        background: none;
        border: none;
        color: var(--dark-gray);
        cursor: pointer;
        padding: 0.25rem;
        margin-left: auto;
    }
    
    .notification-close:hover {
        color: var(--text-dark);
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .status-filter {
        padding: 0.5rem 1rem;
        border: 1px solid var(--medium-gray);
        background: var(--white);
        color: var(--dark-gray);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
    }
    
    .status-filter:hover,
    .status-filter.active {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }
`;

// Inject dynamic styles
const styleSheet = document.createElement('style');
styleSheet.textContent = dynamicStyles;
document.head.appendChild(styleSheet);
