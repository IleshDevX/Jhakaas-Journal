<?php
/**
 * Recent Posts Widget using Cookies
 * Shows recently viewed posts by the user
 */

require_once 'Config/Cookie.php';

function displayRecentPosts($limit = 5) {
    $recent_posts = CookieManager::getRecentPosts();
    
    if (empty($recent_posts)) {
        return '<p>No recent posts viewed.</p>';
    }
    
    $html = '<div class="recent-posts-widget">';
    $html .= '<h4 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">Recently Viewed</h4>';
    $html .= '<ul style="list-style: none; padding: 0; margin: 0;">';
    
    $count = 0;
    foreach ($recent_posts as $post) {
        if ($count >= $limit) break;
        
        $time_ago = timeAgo($post['timestamp']);
        
        $html .= '<li style="margin-bottom: 0.8rem; padding-bottom: 0.8rem; border-bottom: 1px solid #eee;">';
        $html .= '<a href="' . ROOT_URL . 'Post.php?id=' . $post['id'] . '" ';
        $html .= 'style="text-decoration: none; color: #333; font-size: 0.9rem; line-height: 1.4;">';
        $html .= htmlspecialchars($post['title']);
        $html .= '</a>';
        $html .= '<br><small style="color: #888; font-size: 0.8rem;">Viewed ' . $time_ago . '</small>';
        $html .= '</li>';
        
        $count++;
    }
    
    $html .= '</ul>';
    
    // Clear recent posts button
    $html .= '<div style="margin-top: 1rem;">';
    $html .= '<a href="#" onclick="clearRecentPosts(); return false;" ';
    $html .= 'style="font-size: 0.8rem; color: #999; text-decoration: none;">Clear History</a>';
    $html .= '</div>';
    
    $html .= '</div>';
    
    // Add JavaScript for clearing
    $html .= '<script>
    function clearRecentPosts() {
        if(confirm("Clear recent posts history?")) {
            document.cookie = "jhakaas_recent_posts=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            location.reload();
        }
    }
    </script>';
    
    return $html;
}

function displaySearchHistory($limit = 5) {
    $search_history = CookieManager::getSearchHistory();
    
    if (empty($search_history)) {
        return '<p>No recent searches.</p>';
    }
    
    $html = '<div class="search-history-widget">';
    $html .= '<h4 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">Recent Searches</h4>';
    $html .= '<ul style="list-style: none; padding: 0; margin: 0;">';
    
    $count = 0;
    foreach ($search_history as $search_term) {
        if ($count >= $limit) break;
        
        $html .= '<li style="margin-bottom: 0.5rem;">';
        $html .= '<a href="' . ROOT_URL . 'Blog.php?search=' . urlencode($search_term) . '" ';
        $html .= 'style="text-decoration: none; color: #666; font-size: 0.9rem;">';
        $html .= '🔍 ' . htmlspecialchars($search_term);
        $html .= '</a>';
        $html .= '</li>';
        
        $count++;
    }
    
    $html .= '</ul>';
    $html .= '</div>';
    
    return $html;
}

function timeAgo($timestamp) {
    $time_ago = time() - $timestamp;
    
    if ($time_ago < 60) {
        return 'just now';
    } elseif ($time_ago < 3600) {
        return floor($time_ago / 60) . ' minutes ago';
    } elseif ($time_ago < 86400) {
        return floor($time_ago / 3600) . ' hours ago';
    } else {
        return floor($time_ago / 86400) . ' days ago';
    }
}

function getUserPreferencesWidget() {
    $preferences = CookieManager::getUserPreferences();
    $theme = CookieManager::getTheme();
    
    $html = '<div class="user-preferences-widget">';
    $html .= '<h4 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">Your Preferences</h4>';
    
    if (!empty($preferences)) {
        $html .= '<p style="font-size: 0.9rem; color: #666;">Welcome back, ' . htmlspecialchars($preferences['username']) . '!</p>';
        $html .= '<p style="font-size: 0.8rem; color: #888;">Last login: ' . date('M d, Y', $preferences['last_login']) . '</p>';
    }
    
    $html .= '<div style="margin-top: 1rem;">';
    $html .= '<label style="font-size: 0.9rem; color: #666;">Theme: </label>';
    $html .= '<select onchange="changeTheme(this.value)" style="margin-left: 0.5rem; padding: 0.2rem;">';
    $html .= '<option value="light"' . ($theme === 'light' ? ' selected' : '') . '>Light</option>';
    $html .= '<option value="dark"' . ($theme === 'dark' ? ' selected' : '') . '>Dark</option>';
    $html .= '</select>';
    $html .= '</div>';
    
    $html .= '</div>';
    
    // Add JavaScript for theme change
    $html .= '<script>
    function changeTheme(theme) {
        document.cookie = "jhakaas_theme=" + theme + "; expires=" + new Date(Date.now() + 365*24*60*60*1000).toUTCString() + "; path=/";
        // You can add theme switching logic here
        console.log("Theme changed to: " + theme);
    }
    </script>';
    
    return $html;
}
?>