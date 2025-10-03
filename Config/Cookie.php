<?php
/**
 * Cookie Management Class for Jhakaas Journal
 * Handles all cookie operations with security and best practices
 */

class CookieManager {
    
    // Cookie names constants
    const REMEMBER_ME = 'jhakaas_remember_me';
    const USER_PREFERENCES = 'jhakaas_user_prefs';
    const THEME_PREFERENCE = 'jhakaas_theme';
    const LANGUAGE_PREFERENCE = 'jhakaas_language';
    const RECENT_POSTS = 'jhakaas_recent_posts';
    const SEARCH_HISTORY = 'jhakaas_search_history';
    
    // Default cookie settings
    private static $default_options = [
        'expires' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => false,  // Set to true for HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
    ];
    
    /**
     * Set a cookie with enhanced security options
     */
    public static function set($name, $value, $options = []) {
        // Merge with default options
        $options = array_merge(self::$default_options, $options);
        
        // Set default expiry to 30 days if not specified
        if ($options['expires'] === 0) {
            $options['expires'] = time() + (30 * 24 * 60 * 60); // 30 days
        }
        
        // Encrypt sensitive data
        if (in_array($name, [self::REMEMBER_ME, self::USER_PREFERENCES])) {
            $value = self::encrypt($value);
        }
        
        // Set the cookie
        return setcookie($name, $value, $options);
    }
    
    /**
     * Get a cookie value with decryption if needed
     */
    public static function get($name, $default = null) {
        if (!isset($_COOKIE[$name])) {
            return $default;
        }
        
        $value = $_COOKIE[$name];
        
        // Decrypt sensitive data
        if (in_array($name, [self::REMEMBER_ME, self::USER_PREFERENCES])) {
            $value = self::decrypt($value);
        }
        
        return $value;
    }
    
    /**
     * Delete a cookie
     */
    public static function delete($name) {
        if (isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);
            return setcookie($name, '', [
                'expires' => time() - 3600,
                'path' => '/',
                'domain' => '',
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
        }
        return false;
    }
    
    /**
     * Check if a cookie exists
     */
    public static function exists($name) {
        return isset($_COOKIE[$name]);
    }
    
    /**
     * Set Remember Me cookie for user login
     */
    public static function setRememberMe($user_id, $username, $days = 30) {
        $remember_data = [
            'user_id' => $user_id,
            'username' => $username,
            'timestamp' => time(),
            'hash' => hash('sha256', $user_id . $username . $_SERVER['HTTP_USER_AGENT'])
        ];
        
        return self::set(self::REMEMBER_ME, json_encode($remember_data), [
            'expires' => time() + ($days * 24 * 60 * 60),
            'httponly' => true,
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
        ]);
    }
    
    /**
     * Get Remember Me data
     */
    public static function getRememberMe() {
        $data = self::get(self::REMEMBER_ME);
        if ($data) {
            $remember_data = json_decode($data, true);
            
            // Verify hash for security
            $expected_hash = hash('sha256', $remember_data['user_id'] . $remember_data['username'] . $_SERVER['HTTP_USER_AGENT']);
            
            if ($remember_data['hash'] === $expected_hash) {
                return $remember_data;
            }
        }
        
        return null;
    }
    
    /**
     * Set user preferences
     */
    public static function setUserPreferences($preferences) {
        return self::set(self::USER_PREFERENCES, json_encode($preferences), [
            'expires' => time() + (365 * 24 * 60 * 60) // 1 year
        ]);
    }
    
    /**
     * Get user preferences
     */
    public static function getUserPreferences() {
        $prefs = self::get(self::USER_PREFERENCES);
        return $prefs ? json_decode($prefs, true) : [];
    }
    
    /**
     * Set theme preference
     */
    public static function setTheme($theme) {
        return self::set(self::THEME_PREFERENCE, $theme, [
            'expires' => time() + (365 * 24 * 60 * 60) // 1 year
        ]);
    }
    
    /**
     * Get theme preference
     */
    public static function getTheme($default = 'light') {
        return self::get(self::THEME_PREFERENCE, $default);
    }
    
    /**
     * Track recent posts viewed by user
     */
    public static function addRecentPost($post_id, $post_title) {
        $recent_posts = self::getRecentPosts();
        
        // Remove if already exists to avoid duplicates
        $recent_posts = array_filter($recent_posts, function($post) use ($post_id) {
            return $post['id'] != $post_id;
        });
        
        // Add to beginning of array
        array_unshift($recent_posts, [
            'id' => $post_id,
            'title' => $post_title,
            'timestamp' => time()
        ]);
        
        // Keep only last 10 posts
        $recent_posts = array_slice($recent_posts, 0, 10);
        
        return self::set(self::RECENT_POSTS, json_encode($recent_posts), [
            'expires' => time() + (7 * 24 * 60 * 60) // 7 days
        ]);
    }
    
    /**
     * Get recent posts
     */
    public static function getRecentPosts() {
        $posts = self::get(self::RECENT_POSTS);
        return $posts ? json_decode($posts, true) : [];
    }
    
    /**
     * Add search term to history
     */
    public static function addSearchHistory($search_term) {
        $search_history = self::getSearchHistory();
        
        // Remove if already exists
        $search_history = array_diff($search_history, [$search_term]);
        
        // Add to beginning
        array_unshift($search_history, $search_term);
        
        // Keep only last 10 searches
        $search_history = array_slice($search_history, 0, 10);
        
        return self::set(self::SEARCH_HISTORY, json_encode($search_history), [
            'expires' => time() + (30 * 24 * 60 * 60) // 30 days
        ]);
    }
    
    /**
     * Get search history
     */
    public static function getSearchHistory() {
        $history = self::get(self::SEARCH_HISTORY);
        return $history ? json_decode($history, true) : [];
    }
    
    /**
     * Clear all cookies
     */
    public static function clearAll() {
        $cookies = [
            self::REMEMBER_ME,
            self::USER_PREFERENCES,
            self::THEME_PREFERENCE,
            self::LANGUAGE_PREFERENCE,
            self::RECENT_POSTS,
            self::SEARCH_HISTORY
        ];
        
        foreach ($cookies as $cookie) {
            self::delete($cookie);
        }
    }
    
    /**
     * Simple encryption for sensitive data
     */
    private static function encrypt($data) {
        $key = hash('sha256', 'jhakaas_journal_secret_key_2024');
        $iv = substr(hash('sha256', 'jhakaas_journal_iv'), 0, 16);
        return base64_encode(openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv));
    }
    
    /**
     * Simple decryption for sensitive data
     */
    private static function decrypt($data) {
        $key = hash('sha256', 'jhakaas_journal_secret_key_2024');
        $iv = substr(hash('sha256', 'jhakaas_journal_iv'), 0, 16);
        return openssl_decrypt(base64_decode($data), 'AES-256-CBC', $key, 0, $iv);
    }
    
    /**
     * Get all cookie statistics for admin
     */
    public static function getCookieStats() {
        return [
            'remember_me' => self::exists(self::REMEMBER_ME),
            'user_preferences' => self::exists(self::USER_PREFERENCES),
            'theme' => self::get(self::THEME_PREFERENCE, 'Not Set'),
            'recent_posts_count' => count(self::getRecentPosts()),
            'search_history_count' => count(self::getSearchHistory()),
        ];
    }
}
?>