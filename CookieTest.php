<?php
require_once 'Config/Cookie.php';
include 'Partials/Header.php';

// Test cookie operations
if (isset($_POST['test_action'])) {
    switch ($_POST['test_action']) {
        case 'set_test_cookie':
            CookieManager::set('test_cookie', 'Hello from Cookie Test!', ['expires' => time() + 3600]);
            $message = "Test cookie set successfully!";
            break;
            
        case 'add_fake_recent_post':
            CookieManager::addRecentPost(rand(1, 100), 'Sample Post Title ' . rand(1, 50));
            $message = "Added fake recent post!";
            break;
            
        case 'add_fake_search':
            $searches = ['PHP tutorials', 'Web development', 'JavaScript tips', 'Cookie management', 'GDPR compliance'];
            CookieManager::addSearchHistory($searches[array_rand($searches)]);
            $message = "Added fake search term!";
            break;
            
        case 'set_dark_theme':
            CookieManager::setTheme('dark');
            $message = "Theme set to dark!";
            break;
            
        case 'clear_all_test':
            CookieManager::clearAll();
            $message = "All cookies cleared!";
            break;
    }
}
?>

<style>
.test-container {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 2rem;
}

.test-card {
    background: white;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-radius: 8px;
    border-left: 4px solid #6f6af8;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.btn-test {
    background: #6f6af8;
    color: white;
    border: none;
    padding: 0.7rem 1.2rem;
    border-radius: 5px;
    cursor: pointer;
    margin: 0.3rem;
    font-size: 0.9rem;
}

.btn-test:hover {
    background: #5a55e0;
}

.cookie-data {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 5px;
    margin-top: 1rem;
    font-family: monospace;
    font-size: 0.9rem;
    max-height: 300px;
    overflow-y: auto;
}
</style>

<section class="test-container">
    <h2 style="text-align: center; color: #333; margin-bottom: 2rem;">🍪 Cookie System Test Page</h2>
    
    <?php if (isset($message)): ?>
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem;">
            ✅ <?= $message ?>
        </div>
    <?php endif; ?>
    
    <!-- Test Actions -->
    <div class="test-card">
        <h3>🧪 Test Cookie Operations</h3>
        <p>Use these buttons to test various cookie functionalities:</p>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="test_action" value="set_test_cookie">
            <button type="submit" class="btn-test">Set Test Cookie</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="test_action" value="add_fake_recent_post">
            <button type="submit" class="btn-test">Add Fake Recent Post</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="test_action" value="add_fake_search">
            <button type="submit" class="btn-test">Add Fake Search</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="test_action" value="set_dark_theme">
            <button type="submit" class="btn-test">Set Dark Theme</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="test_action" value="clear_all_test">
            <button type="submit" class="btn-test" style="background: #dc3545;" 
                    onclick="return confirm('Clear all cookies?')">Clear All Cookies</button>
        </form>
    </div>
    
    <!-- Cookie Statistics -->
    <div class="test-card">
        <h3>📊 Cookie Statistics</h3>
        <?php 
        $stats = CookieManager::getCookieStats();
        ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <strong>Remember Me:</strong> <?= $stats['remember_me'] ? '✅ Active' : '❌ Inactive' ?>
            </div>
            <div>
                <strong>User Preferences:</strong> <?= $stats['user_preferences'] ? '✅ Set' : '❌ Not Set' ?>
            </div>
            <div>
                <strong>Theme:</strong> <?= $stats['theme'] ?>
            </div>
            <div>
                <strong>Recent Posts:</strong> <?= $stats['recent_posts_count'] ?> posts
            </div>
            <div>
                <strong>Search History:</strong> <?= $stats['search_history_count'] ?> searches
            </div>
        </div>
    </div>
    
    <!-- Recent Posts -->
    <div class="test-card">
        <h3>📖 Recent Posts Data</h3>
        <div class="cookie-data">
            <?php 
            $recent_posts = CookieManager::getRecentPosts();
            if (!empty($recent_posts)) {
                foreach ($recent_posts as $post) {
                    echo "ID: {$post['id']} | Title: {$post['title']} | Viewed: " . date('Y-m-d H:i:s', $post['timestamp']) . "\n";
                }
            } else {
                echo "No recent posts data found.";
            }
            ?>
        </div>
    </div>
    
    <!-- Search History -->
    <div class="test-card">
        <h3>🔍 Search History Data</h3>
        <div class="cookie-data">
            <?php 
            $search_history = CookieManager::getSearchHistory();
            if (!empty($search_history)) {
                foreach ($search_history as $index => $search) {
                    echo ($index + 1) . ". " . htmlspecialchars($search) . "\n";
                }
            } else {
                echo "No search history data found.";
            }
            ?>
        </div>
    </div>
    
    <!-- User Preferences -->
    <div class="test-card">
        <h3>👤 User Preferences Data</h3>
        <div class="cookie-data">
            <?php 
            $user_prefs = CookieManager::getUserPreferences();
            if (!empty($user_prefs)) {
                echo json_encode($user_prefs, JSON_PRETTY_PRINT);
            } else {
                echo "No user preferences data found.";
            }
            ?>
        </div>
    </div>
    
    <!-- Raw Cookie Data -->
    <div class="test-card">
        <h3>🔍 Raw Cookie Data</h3>
        <div class="cookie-data">
            <?php 
            echo "All Cookies:\n";
            foreach ($_COOKIE as $name => $value) {
                if (strpos($name, 'jhakaas_') === 0) {
                    echo "$name: " . substr($value, 0, 100) . (strlen($value) > 100 ? '...' : '') . "\n";
                }
            }
            ?>
        </div>
    </div>
    
    <!-- Navigation -->
    <div class="test-card">
        <h3>🔗 Quick Navigation</h3>
        <a href="<?= ROOT_URL ?>CookieSettings.php" class="btn-test">Cookie Settings</a>
        <a href="<?= ROOT_URL ?>Blog.php" class="btn-test">Blog with Widgets</a>
        <a href="<?= ROOT_URL ?>Index.php" class="btn-test">Home Page</a>
        <a href="<?= ROOT_URL ?>SignIn.php" class="btn-test">Test Remember Me</a>
    </div>
</section>

<?php include 'Partials/Footer.php'; ?>