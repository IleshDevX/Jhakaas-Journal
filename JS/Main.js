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
    const toggleBtn = document.querySelector('#open__nav-btn'); // Use as toggle button
    const navLinks = document.querySelectorAll('.nav__items a'); // Select all links within nav items
    
    console.log('Nav elements found:', {
        navItems: !!navItems,
        toggleBtn: !!toggleBtn,
        navLinks: navLinks.length,
        windowWidth: window.innerWidth
    });
    
    if (!navItems || !toggleBtn) {
        console.log('Missing navigation elements!');
        console.log('navItems:', navItems);
        console.log('toggleBtn:', toggleBtn);
        return;
    }
    
    // Function to toggle navigation
    function toggleNavigation() {
        const isOpen = navItems.classList.contains('show');
        
        if (isOpen) {
            console.log('Closing nav...');
            navItems.classList.remove('show');
            document.body.classList.remove('nav-open');
        } else {
            console.log('Opening nav...');
            navItems.classList.add('show');
            document.body.classList.add('nav-open');
        }
    }
    
    // Function to close navigation (used by other events)
    function closeNavigation() {
        console.log('Closing nav...');
        navItems.classList.remove('show');
        document.body.classList.remove('nav-open');
    }
    
    // Toggle button click
    toggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Toggle button clicked');
        toggleNavigation();
    });

    // Add touch support for mobile
    toggleBtn.addEventListener('touchstart', function(e) {
        e.preventDefault();
        console.log('Toggle button touched');
        toggleNavigation();
    });
    
    // Close when clicking nav links
    navLinks.forEach(function(link, index) {
        link.addEventListener('click', function(e) {
            console.log('Nav link ' + index + ' clicked');
            // Add a small delay to allow navigation to process
            setTimeout(function() {
                closeNavigation();
            }, 100);
        });
    });
    
    // Close when clicking outside
    document.addEventListener('click', function(e) {
        const isNavOpen = navItems.classList.contains('show');
        if (!isNavOpen) return;
        
        // Check if click is outside navigation
        if (!navItems.contains(e.target) && 
            !toggleBtn.contains(e.target)) {
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
        if (window.innerWidth > 1080 && navItems.classList.contains('show')) {
            console.log('Resized to desktop - closing nav');
            closeNavigation();
        }
    });
    
    // Force close function for debugging
    window.forceCloseNav = closeNavigation;
    window.forceToggleNav = toggleNavigation;
    
    // Ensure navigation is closed on page load
    closeNavigation();
    
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
    
    // Category Buttons: navigate to category page with query param
    const categoryButtons = document.querySelectorAll('.category__button');
    if (categoryButtons && categoryButtons.length > 0) {
        categoryButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const label = (this.textContent || '').trim();
                if (!label) return;
                window.location.href = 'Category-Post.html?category=' + encodeURIComponent(label);
            });
        });
    }
    
    // Apply category filter on Category-Post.html if ?category= is present
    (function applyCategoryFromUrl() {
        if (!/Category-Post\.html$/i.test(window.location.pathname)) return;
        const params = new URLSearchParams(window.location.search);
        const selected = (params.get('category') || '').trim();
        if (!selected) return;
        
        const header = document.querySelector('.category__title h2');
        if (header) header.textContent = selected;
        
        const postsContainer = document.querySelector('.posts__container');
        const articles = postsContainer ? postsContainer.querySelectorAll('article') : [];
        if (!articles || articles.length === 0) return;
        
        const selectedLc = selected.toLowerCase();
        let anyShown = false;
        articles.forEach(function(article) {
            const badge = (article.querySelector('.post_button')?.textContent || '').toLowerCase();
            const match = badge.includes(selectedLc);
            article.style.display = match ? 'grid' : 'none';
            if (match) anyShown = true;
        });
        // Show all if no matches to avoid empty page
        if (!anyShown) {
            articles.forEach(function(article) { article.style.display = 'grid'; });
        }
    })();

    // Posts Navigation Manager: open clicked post with its content
    (function setupPostOpenHandlers() {
        const articleLinks = document.querySelectorAll('.posts__container article .post__title a');
        if (!articleLinks || articleLinks.length === 0) return;
        
        articleLinks.forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                // Capture the article's content and navigate client-side
                e.preventDefault();
                const article = this.closest('article');
                if (!article) return (window.location.href = this.href || 'Post.html');
                
                const data = {
                    title: (article.querySelector('.post__title a')?.textContent || '').trim(),
                    image: article.querySelector('.post__thumbnail img')?.getAttribute('src') || '',
                    category: (article.querySelector('.post_button')?.textContent || '').trim(),
                    body: (article.querySelector('.post__body')?.textContent || '').trim(),
                    authorName: (article.querySelector('.post__author-info h5')?.textContent || '').trim(),
                    authorAvatar: article.querySelector('.post__author-avatar img')?.getAttribute('src') || '',
                    date: (article.querySelector('.post__author-info small')?.textContent || '').trim()
                };
                try {
                    sessionStorage.setItem('currentPost', JSON.stringify(data));
                } catch (_) {}
                window.location.href = 'Post.html';
            });
        });
    })();

    // Post page renderer: read from sessionStorage and render
    (function renderSinglePost() {
        if (!/Post\.html$/i.test(window.location.pathname)) return;
        let raw;
        try {
            raw = sessionStorage.getItem('currentPost');
        } catch (_) { raw = null; }
        if (!raw) return; // keep default content
        let post;
        try {
            post = JSON.parse(raw);
        } catch (_) { return; }
        if (!post) return;
        
        const titleAnchor = document.querySelector('.singlepost__header h2 a');
        if (titleAnchor && post.title) {
            titleAnchor.textContent = post.title;
        }
        const heroImg = document.querySelector('.singlepost__thumbnail img');
        if (heroImg && post.image) {
            heroImg.setAttribute('src', post.image);
        }
        const authorName = document.querySelector('.post__author-info h5');
        if (authorName && post.authorName) {
            authorName.textContent = post.authorName;
        }
        const authorAvatar = document.querySelector('.post__author-avatar img');
        if (authorAvatar && post.authorAvatar) {
            authorAvatar.setAttribute('src', post.authorAvatar);
        }
        const dateEl = document.querySelector('.post__author-info small');
        if (dateEl && post.date) {
            dateEl.textContent = post.date;
        }
        const content = document.querySelector('.singlepost__content');
        if (content && post.body) {
            content.innerHTML = '';
            const p = document.createElement('p');
            p.className = 'post__body';
            p.textContent = post.body;
            content.appendChild(p);
        }
    })();
    
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