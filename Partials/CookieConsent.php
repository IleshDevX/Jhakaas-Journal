<?php
/**
 * Cookie Consent Banner
 * GDPR compliant cookie consent system
 */

// Check if user has already given consent
$consent_given = isset($_COOKIE['jhakaas_cookie_consent']) && $_COOKIE['jhakaas_cookie_consent'] === 'accepted';

if (!$consent_given): ?>
<div id="cookieConsent" style="
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem;
    z-index: 10000;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.3);
    transform: translateY(100%);
    transition: transform 0.3s ease-in-out;
">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div style="flex: 1; min-width: 300px;">
            <h4 style="margin: 0 0 0.5rem 0; font-size: 1.1rem;">🍪 We use cookies</h4>
            <p style="margin: 0; font-size: 0.9rem; line-height: 1.4; opacity: 0.9;">
                We use cookies to enhance your browsing experience, remember your preferences, and provide personalized content. 
                By continuing to use our site, you consent to our use of cookies.
            </p>
        </div>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <button onclick="acceptCookies()" style="
                background: #28a745;
                color: white;
                border: none;
                padding: 0.7rem 1.5rem;
                border-radius: 25px;
                cursor: pointer;
                font-weight: 500;
                transition: background 0.3s;
            " onmouseover="this.style.background='#218838'" onmouseout="this.style.background='#28a745'">
                Accept All Cookies
            </button>
            <button onclick="showCookieSettings()" style="
                background: transparent;
                color: white;
                border: 2px solid white;
                padding: 0.7rem 1.5rem;
                border-radius: 25px;
                cursor: pointer;
                font-weight: 500;
                transition: all 0.3s;
            " onmouseover="this.style.background='white'; this.style.color='#667eea'" 
               onmouseout="this.style.background='transparent'; this.style.color='white'">
                Manage Cookies
            </button>
            <button onclick="declineCookies()" style="
                background: transparent;
                color: rgba(255,255,255,0.8);
                border: none;
                padding: 0.7rem 1rem;
                cursor: pointer;
                text-decoration: underline;
                font-size: 0.9rem;
            ">
                Decline
            </button>
        </div>
    </div>
</div>

<script>
// Show the consent banner after page load
window.addEventListener('load', function() {
    setTimeout(function() {
        document.getElementById('cookieConsent').style.transform = 'translateY(0)';
    }, 1000);
});

function acceptCookies() {
    // Set consent cookie for 1 year
    setCookie('jhakaas_cookie_consent', 'accepted', 365);
    
    // Set default preferences
    setCookie('jhakaas_theme', 'light', 365);
    
    // Hide banner
    hideCookieBanner();
    
    // Show success message
    showMessage('Cookies accepted! Your preferences have been saved.', 'success');
}

function declineCookies() {
    // Set decline cookie
    setCookie('jhakaas_cookie_consent', 'declined', 365);
    
    // Clear any existing cookies except essential ones
    clearNonEssentialCookies();
    
    // Hide banner
    hideCookieBanner();
    
    // Show info message
    showMessage('Cookie preferences saved. Some features may be limited.', 'info');
}

function showCookieSettings() {
    // Redirect to cookie settings page
    window.location.href = '<?= ROOT_URL ?>CookieSettings.php';
}

function hideCookieBanner() {
    const banner = document.getElementById('cookieConsent');
    banner.style.transform = 'translateY(100%)';
    setTimeout(() => {
        banner.style.display = 'none';
    }, 300);
}

function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/;SameSite=Lax';
}

function clearNonEssentialCookies() {
    // List of non-essential cookies to clear
    const nonEssentialCookies = [
        'jhakaas_recent_posts',
        'jhakaas_search_history',
        'jhakaas_theme',
        'jhakaas_user_prefs'
    ];
    
    nonEssentialCookies.forEach(cookieName => {
        document.cookie = cookieName + '=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;';
    });
}

function showMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 10001;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
        max-width: 300px;
    `;
    
    // Set color based on type
    switch(type) {
        case 'success':
            messageDiv.style.background = '#28a745';
            break;
        case 'info':
            messageDiv.style.background = '#17a2b8';
            break;
        default:
            messageDiv.style.background = '#6c757d';
    }
    
    messageDiv.textContent = message;
    document.body.appendChild(messageDiv);
    
    // Animate in
    setTimeout(() => {
        messageDiv.style.opacity = '1';
        messageDiv.style.transform = 'translateX(0)';
    }, 100);
    
    // Animate out and remove
    setTimeout(() => {
        messageDiv.style.opacity = '0';
        messageDiv.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(messageDiv);
        }, 300);
    }, 3000);
}
</script>

<?php endif; ?>