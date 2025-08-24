// Enhanced Navigation and Dashboard Toggle Functionality - FIXED VERSION
// ===================================================================================

// Navigation Elements
const navItems = document.querySelector('.nav__items'); 
const navToggleBtn = document.querySelector('#open__nav-btn');
const closeNavBtn = document.querySelector('#close__nav-btn');

// Dashboard Elements - FIXED: Correct selectors
const sidebar = document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show_sidebar-btn');
const hideSidebarBtn = document.querySelector('#hide_sidebar-btn');

// State Management
let isNavOpen = false;
let isSidebarOpen = false;
let currentBreakpoint = null;

// Utility Functions
const getBreakpoint = () => {
    const width = window.innerWidth;
    if (width <= 600) return 'mobile';
    if (width <= 1080) return 'tablet';
    return 'desktop';
};

const preventBodyScroll = (prevent) => {
    document.body.style.overflow = prevent ? 'hidden' : 'auto';
};

// Performance optimization - use requestAnimationFrame for DOM updates
const performDOMUpdates = (updates) => {
    if (!updates || typeof updates !== 'function') return;
    
    requestAnimationFrame(() => {
        updates();
    });
};

// ===================================================================================
//                              NAVIGATION FUNCTIONALITY
// ===================================================================================

const initNavigation = () => {
    if (!navItems || !navToggleBtn) return;
    
    // Hide close button permanently
    if (closeNavBtn) closeNavBtn.style.display = 'none';
    
    const breakpoint = getBreakpoint();
    
    performDOMUpdates(() => {
        if (breakpoint === 'desktop') {
            navItems.classList.remove('show');
            navToggleBtn.style.display = 'none';
            isNavOpen = false;
            preventBodyScroll(false);
        } else {
            navToggleBtn.style.display = 'inline-block';
            if (!isNavOpen) navItems.classList.remove('show');
        }
    });
};

const toggleNav = () => {
    if (getBreakpoint() === 'desktop') return;
    
    isNavOpen = !isNavOpen;
    
    performDOMUpdates(() => {
        if (isNavOpen) {
            navItems.classList.add('show');
            preventBodyScroll(true);
        } else {
            navItems.classList.remove('show');
            preventBodyScroll(false);
        }
    });
};

const closeNav = () => {
    if (isNavOpen) {
        performDOMUpdates(() => {
            navItems.classList.remove('show');
            isNavOpen = false;
            preventBodyScroll(false);
        });
    }
};

// Navigation Event Listeners
if (navToggleBtn) {
    navToggleBtn.addEventListener('click', (e) => {
        e.preventDefault();
        toggleNav();
    });
}

// Close nav when clicking on links (mobile only)
const navLinks = document.querySelectorAll('.nav__items a');
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        if (getBreakpoint() !== 'desktop') {
            setTimeout(() => closeNav(), 150);
        }
    });
});

// Close nav on backdrop click
if (navItems) {
    navItems.addEventListener('click', (e) => {
        if (e.target === navItems && isNavOpen) {
            closeNav();
        }
    });
}

// ===================================================================================
//                              DASHBOARD FUNCTIONALITY - FIXED
// ===================================================================================

const initDashboard = () => {
    if (!sidebar) return;
    
    const breakpoint = getBreakpoint();
    currentBreakpoint = breakpoint;
    
    // Reset sidebar state
    performDOMUpdates(() => {
        sidebar.classList.remove('show');
        isSidebarOpen = false;
        preventBodyScroll(false);
        
        // FIXED: Proper button visibility management
        switch (breakpoint) {
            case 'desktop':
                // Desktop - sidebar always visible, hide all toggle buttons
                sidebar.style.position = 'static';
                sidebar.style.left = 'auto';
                sidebar.style.transform = 'none';
                sidebar.style.zIndex = 'auto';
                if (showSidebarBtn) showSidebarBtn.style.display = 'none';
                if (hideSidebarBtn) hideSidebarBtn.style.display = 'none';
                break;
                
            case 'tablet':
                // Tablet - sidebar visible, but can be toggled with icon-only buttons
                sidebar.style.position = 'static';
                sidebar.style.left = 'auto';
                sidebar.style.transform = 'none';
                sidebar.style.zIndex = 'auto';
                if (showSidebarBtn) showSidebarBtn.style.display = 'none';
                if (hideSidebarBtn) hideSidebarBtn.style.display = 'none';
                break;
                
            case 'mobile':
                // Mobile - sidebar hidden, show toggle button
                sidebar.style.position = 'fixed';
                sidebar.style.left = '-100%';
                sidebar.style.transform = 'translateX(0)';
                sidebar.style.top = '0';
                sidebar.style.width = '16rem';
                sidebar.style.height = '100vh';
                sidebar.style.zIndex = '1000';
                sidebar.setAttribute('aria-expanded', 'false');
                
                if (showSidebarBtn) {
                    showSidebarBtn.style.display = 'inline-flex';
                    showSidebarBtn.setAttribute('aria-label', 'Show sidebar');
                    showSidebarBtn.setAttribute('aria-controls', 'sidebar');
                }
                if (hideSidebarBtn) {
                    hideSidebarBtn.style.display = 'none';
                }
                break;
        }
    });
};

// FIXED: Proper sidebar toggle function
const toggleSidebar = (forceClose = false) => {
    const breakpoint = getBreakpoint();
    
    if (breakpoint !== 'mobile') return;
    
    if (forceClose) {
        isSidebarOpen = false;
    } else {
        isSidebarOpen = !isSidebarOpen;
    }
    
    performDOMUpdates(() => {
        if (isSidebarOpen && !forceClose) {
            // Open sidebar
            sidebar.classList.add('show');
            sidebar.style.left = '0';
            sidebar.setAttribute('aria-expanded', 'true');
            preventBodyScroll(true);
            
            // Update button visibility
            if (showSidebarBtn) showSidebarBtn.style.display = 'none';
            if (hideSidebarBtn) hideSidebarBtn.style.display = 'inline-flex';
            
            createOverlay();
            document.addEventListener('keydown', handleEscapeKey);
        } else {
            // Close sidebar
            closeSidebar();
        }
    });
};

// FIXED: Simplified close function
const closeSidebar = () => {
    if (!isSidebarOpen && getBreakpoint() !== 'mobile') return;
    
    performDOMUpdates(() => {
        sidebar.classList.remove('show');
        sidebar.style.left = '-100%';
        sidebar.setAttribute('aria-expanded', 'false');
        isSidebarOpen = false;
        preventBodyScroll(false);
        
        // Update button visibility
        if (showSidebarBtn) showSidebarBtn.style.display = 'inline-flex';
        if (hideSidebarBtn) hideSidebarBtn.style.display = 'none';
        
        removeOverlay();
        document.removeEventListener('keydown', handleEscapeKey);
    });
};

// Overlay Management
let overlay = null;

const createOverlay = () => {
    if (overlay) return;
    
    overlay = document.createElement('div');
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        opacity: 0;
        transition: opacity 0.3s ease;
        will-change: opacity;
        pointer-events: auto;
    `;
    
    document.body.appendChild(overlay);
    
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            overlay.style.opacity = '1';
        });
    });
    
    overlay.addEventListener('click', closeSidebar);
};

const removeOverlay = () => {
    if (overlay) {
        overlay.style.opacity = '0';
        overlay.style.pointerEvents = 'none';
        
        setTimeout(() => {
            if (overlay && overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
            overlay = null;
        }, 300);
    }
};

// Event Handlers
const handleEscapeKey = (e) => {
    if (e.key === 'Escape') closeSidebar();
};

// FIXED: Dashboard Event Listeners
if (showSidebarBtn) {
    showSidebarBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        console.log('Show sidebar clicked');
        toggleSidebar(false); // Open sidebar
    });
}

// FIXED: Hide sidebar button event listener
if (hideSidebarBtn) {
    hideSidebarBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        console.log('Hide sidebar clicked');
        closeSidebar(); // Close sidebar
    });
}

// Close sidebar when clicking on sidebar links (mobile only)
const sidebarLinks = sidebar?.querySelectorAll('a');
sidebarLinks?.forEach(link => {
    link.addEventListener('click', () => {
        if (getBreakpoint() === 'mobile' && isSidebarOpen) {
            setTimeout(() => closeSidebar(), 150);
        }
    });
});

// ===================================================================================
//                              WINDOW RESIZE HANDLER
// ===================================================================================

let resizeTimeout;
let lastWidth = window.innerWidth;

const handleResize = () => {
    clearTimeout(resizeTimeout);
    
    const newWidth = window.innerWidth;
    const widthDifference = Math.abs(newWidth - lastWidth);
    
    if (widthDifference < 10) return;
    
    lastWidth = newWidth;
    
    resizeTimeout = setTimeout(() => {
        const oldBreakpoint = currentBreakpoint;
        const newBreakpoint = getBreakpoint();
        
        if (oldBreakpoint !== newBreakpoint) {
            // Close sidebar when switching breakpoints
            if (isSidebarOpen) {
                closeSidebar();
            }
            initNavigation();
            initDashboard();
        }
    }, 150);
};

window.addEventListener('resize', handleResize, { passive: true });

// ===================================================================================
//                              FORM HANDLING
// ===================================================================================

const showAlert = (message, type = 'error') => {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert__message ${type}`;
    alertDiv.innerHTML = `
        <p>${message}</p>
        <button onclick="this.parentElement.remove()">×</button>
    `;
    
    const formContainer = document.querySelector('.form__section-container');
    if (formContainer) {
        const form = formContainer.querySelector('form');
        formContainer.insertBefore(alertDiv, form);
        setTimeout(() => alertDiv.remove(), 5000);
    }
};

// Form Validation
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const inputs = form.querySelectorAll('input[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderColor = 'var(--color-red)';
            } else {
                input.style.borderColor = '';
            }
        });
        
        if (!isValid) {
            showAlert('Please fill in all required fields.');
            return;
        }
        
        showAlert('Operation completed successfully!', 'success');
    });
});

// ===================================================================================
//                              INITIALIZATION
// ===================================================================================

const initialize = () => {
    console.log('Initializing enhanced functionality...');
    
    // Debug: Check if elements exist
    console.log('Show sidebar button:', showSidebarBtn);
    console.log('Hide sidebar button:', hideSidebarBtn);
    console.log('Sidebar element:', sidebar);
    
    initNavigation();
    initDashboard();
    console.log('Initialization complete');
};

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initialize);
} else {
    initialize();
}

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    removeOverlay();
    preventBodyScroll(false);
});

// Export functions for debugging
window.debugFunctions = {
    toggleNav,
    toggleSidebar,
    closeSidebar,
    getBreakpoint,
    initialize,
    showSidebarBtn,
    hideSidebarBtn,
    sidebar
};