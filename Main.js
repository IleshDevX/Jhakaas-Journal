const showAlert = (element, message, type = 'error') => {
    if (!element) return;
    element.textContent = message;
    element.className = `alert__message ${type}`; 
    element.style.display = 'block';
    setTimeout(() => {
        element.style.display = 'none';
    }, 4000);
};

const hideAlert = (element) => {
    if (element) {
        element.style.display = 'none';
    }
};

// Simple Navigation Handler - No Classes, Direct DOM Manipulation
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    
    // Get navigation elements
    const navItems = document.querySelector('.nav__items');
    const openBtn = document.querySelector('#open__nav-btn');
    const closeBtn = document.querySelector('#close__nav-btn');
    const navLinks = document.querySelectorAll('.nav__link');
    
    console.log('Nav elements found:', {
        navItems: !!navItems,
        openBtn: !!openBtn, 
        closeBtn: !!closeBtn,
        navLinks: navLinks.length
    });
    
    if (!navItems || !openBtn || !closeBtn) {
        console.log('Missing navigation elements!');
        return;
    }
    
    // Function to open navigation
    function openNavigation() {
        console.log('Opening nav...');
        navItems.classList.add('show');
        openBtn.style.display = 'none';
        closeBtn.style.display = 'inline-block';
        document.body.classList.add('nav-open'); // Add body class for CSS targeting
    }
    
    // Function to close navigation
    function closeNavigation() {
        console.log('Closing nav...');
        navItems.classList.remove('show');
        openBtn.style.display = 'inline-block';
        closeBtn.style.display = 'none';
        document.body.classList.remove('nav-open');
    }
    
    // Open button click
    openBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Open button clicked');
        openNavigation();
    });
    
    // Close button click
    closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Close button clicked');
        closeNavigation();
    });
    
    // Close when clicking nav links
    navLinks.forEach(function(link, index) {
        link.addEventListener('click', function() {
            console.log('Nav link ' + index + ' clicked');
            closeNavigation();
        });
    });
    
    // Close when clicking outside
    document.addEventListener('click', function(e) {
        const isNavOpen = navItems.classList.contains('show');
        if (!isNavOpen) return;
        
        // Check if click is outside navigation
        if (!navItems.contains(e.target) && 
            !openBtn.contains(e.target) && 
            !closeBtn.contains(e.target)) {
            console.log('Clicked outside - closing nav');
            closeNavigation();
        }
    });
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && navItems.classList.contains('show')) {
            console.log('Escape pressed - closing nav');
            closeNavigation();
        }
    });
    
    // Close on window resize (desktop)
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024 && navItems.classList.contains('show')) {
            console.log('Resized to desktop - closing nav');
            closeNavigation();
        }
    });
    
    // Force close function for debugging
    window.forceCloseNav = closeNavigation;
    window.forceOpenNav = openNavigation;
    
    // Initialize other managers
    initializeOtherManagers();
});

// Other managers
function initializeOtherManagers() {
    // Dashboard Manager
    const dashboard = document.querySelector('.dashboard');
    if (dashboard) {
        const sidebar = dashboard.querySelector('aside');
        const showSidebarBtn = dashboard.querySelector('#show_sidebar-btn');
        const hideSidebarBtn = dashboard.querySelector('#hide_sidebar-btn');
        
        if (sidebar && showSidebarBtn && hideSidebarBtn) {
            showSidebarBtn.addEventListener('click', function() {
                sidebar.classList.add('show');
                dashboard.classList.add('sidebar-open');
            });
            
            hideSidebarBtn.addEventListener('click', function() {
                sidebar.classList.remove('show');
                dashboard.classList.remove('sidebar-open');
            });
        }
    }
    
    // Search Manager
    const searchInput = document.querySelector('.search__bar input[type="search"]');
    const posts = document.querySelectorAll('.posts__container article');
    
    if (searchInput && posts.length > 0) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            posts.forEach(function(post) {
                const titleElement = post.querySelector('.post__title a');
                if (titleElement) {
                    const title = titleElement.textContent.toLowerCase();
                    if (title.includes(searchTerm)) {
                        post.style.display = 'grid';
                    } else {
                        post.style.display = 'none';
                    }
                }
            });
        });
    }
    
    // Contact Form Manager
    const contactForm = document.querySelector('.contact__form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const firstName = this.querySelector('input[name="first_name"]').value.trim();
            const lastName = this.querySelector('input[name="last_name"]').value.trim();
            const email = this.querySelector('input[name="email"]').value.trim();
            const message = this.querySelector('textarea[name="message"]').value.trim();
            
            if (!firstName || !lastName || !email || !message) {
                alert('Please fill out all fields.');
                return;
            }
            
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Please enter a valid email address.');
                return;
            }
            
            console.log('Form Submitted:', { firstName, lastName, email, message });
            alert('Thank you for your message! We will get back to you shortly.');
            this.reset();
        });
    }
    
    // Auth Forms Manager
    const alertMessage = document.querySelector('.alert__message');
    
    // Sign In Form
    if (window.location.pathname.includes('SignIn.html')) {
        const signInForm = document.querySelector('form[action=""]');
        if (signInForm) {
            hideAlert(alertMessage);
            signInForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const username = this.querySelector('input[name="username"]').value.trim();
                const password = this.querySelector('input[name="password"]').value.trim();
                
                if (!username || !password) {
                    showAlert(alertMessage, 'Please enter both username and password.', 'error');
                    return;
                }
                
                showAlert(alertMessage, 'Sign in successful! Redirecting...', 'success');
                setTimeout(function() {
                    window.location.href = 'Dashboard.html';
                }, 2000);
            });
        }
    }
    
    // Sign Up Form
    if (window.location.pathname.includes('SignUp.html')) {
        const signUpForm = document.querySelector('form[enctype="multipart/form-data"]');
        if (signUpForm) {
            hideAlert(alertMessage);
            signUpForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const firstName = this.querySelector('input[name="firstname"]').value.trim();
                const lastName = this.querySelector('input[name="lastname"]').value.trim();
                const username = this.querySelector('input[name="username"]').value.trim();
                const email = this.querySelector('input[name="email"]').value.trim();
                const password = this.querySelector('input[name="createpassword"]').value.trim();
                const confirmPassword = this.querySelector('input[name="confirmpassword"]').value.trim();
                
                if (!firstName || !lastName || !username || !email || !password || !confirmPassword) {
                    showAlert(alertMessage, 'Please fill out all fields.', 'error');
                    return;
                }
                
                if (password.length < 6) {
                    showAlert(alertMessage, 'Password must be at least 6 characters long.', 'error');
                    return;
                }
                
                if (password !== confirmPassword) {
                    showAlert(alertMessage, 'Passwords do not match.', 'error');
                    return;
                }
                
                showAlert(alertMessage, 'Account created successfully! Please sign in.', 'success');
                setTimeout(function() {
                    window.location.href = 'SignIn.html';
                }, 2000);
            });
        }
    }
}   