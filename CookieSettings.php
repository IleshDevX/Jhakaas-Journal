<?php
require_once 'Config/Cookie.php';
include 'Partials/Header.php';

// Handle cookie management actions
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'clear_all':
            CookieManager::clearAll();
            $_SESSION['cookie_message'] = "All cookies have been cleared successfully.";
            break;
            
        case 'clear_recent_posts':
            CookieManager::delete(CookieManager::RECENT_POSTS);
            $_SESSION['cookie_message'] = "Recent posts history cleared.";
            break;
            
        case 'clear_search_history':
            CookieManager::delete(CookieManager::SEARCH_HISTORY);
            $_SESSION['cookie_message'] = "Search history cleared.";
            break;
            
        case 'set_theme':
            if (isset($_POST['theme'])) {
                CookieManager::setTheme($_POST['theme']);
                $_SESSION['cookie_message'] = "Theme preference saved.";
            }
            break;
    }
    
    // Redirect to avoid form resubmission
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

$cookie_stats = CookieManager::getCookieStats();
$recent_posts = CookieManager::getRecentPosts();
$search_history = CookieManager::getSearchHistory();
$user_prefs = CookieManager::getUserPreferences();
?>

<style>
.cookie-settings {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: #f9f9f9;
    border-radius: 8px;
}

.cookie-card {
    background: white;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-radius: 6px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.cookie-card h3 {
    color: #333;
    margin-bottom: 1rem;
}

.cookie-info {
    background: #e8f4fd;
    padding: 1rem;
    border-left: 4px solid #2196F3;
    margin-bottom: 1rem;
}

.btn-group {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 0.9rem;
}

.btn-primary { background: #6f6af8; color: white; }
.btn-danger { background: #dc3545; color: white; }
.btn-warning { background: #ffc107; color: #333; }
.btn-success { background: #28a745; color: white; }

.data-list {
    max-height: 200px;
    overflow-y: auto;
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
    font-size: 0.9rem;
}
</style>

<section class="cookie-settings">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 2rem;">Cookie Settings & Privacy</h2>
        
        <?php if (isset($_SESSION['cookie_message'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                <?= $_SESSION['cookie_message']; unset($_SESSION['cookie_message']); ?>
            </div>
        <?php endif; ?>
        
        <!-- Cookie Overview -->
        <div class="cookie-card">
            <h3>🍪 Cookie Overview</h3>
            <div class="cookie-info">
                <p><strong>What are cookies?</strong> Cookies are small text files stored on your device to enhance your browsing experience. We use them to remember your preferences, login status, and recently viewed content.</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div>
                    <strong>Remember Me:</strong> <?= $cookie_stats['remember_me'] ? '✅ Active' : '❌ Inactive' ?>
                </div>
                <div>
                    <strong>Theme:</strong> <?= ucfirst($cookie_stats['theme']) ?>
                </div>
                <div>
                    <strong>Recent Posts:</strong> <?= $cookie_stats['recent_posts_count'] ?> tracked
                </div>
                <div>
                    <strong>Search History:</strong> <?= $cookie_stats['search_history_count'] ?> searches
                </div>
            </div>
        </div>
        
        <!-- Theme Preferences -->
        <div class="cookie-card">
            <h3>🎨 Theme Preferences</h3>
            <form method="POST" style="display: flex; align-items: center; gap: 1rem;">
                <input type="hidden" name="action" value="set_theme">
                <label>Choose your theme:</label>
                <select name="theme" style="padding: 0.5rem;">
                    <option value="light" <?= CookieManager::getTheme() === 'light' ? 'selected' : '' ?>>Light Mode</option>
                    <option value="dark" <?= CookieManager::getTheme() === 'dark' ? 'selected' : '' ?>>Dark Mode</option>
                    <option value="auto" <?= CookieManager::getTheme() === 'auto' ? 'selected' : '' ?>>Auto (System)</option>
                </select>
                <button type="submit" class="btn btn-primary">Save Theme</button>
            </form>
        </div>
        
        <!-- Recent Posts -->
        <div class="cookie-card">
            <h3>📖 Recent Posts History</h3>
            <p>We track the posts you view to show you a personalized "Recently Viewed" list.</p>
            
            <?php if (!empty($recent_posts)): ?>
                <div class="data-list">
                    <?php foreach ($recent_posts as $post): ?>
                        <div style="margin-bottom: 0.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid #ddd;">
                            <strong><?= htmlspecialchars($post['title']) ?></strong><br>
                            <small>Viewed: <?= date('M d, Y g:i A', $post['timestamp']) ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <form method="POST" style="margin-top: 1rem;">
                    <input type="hidden" name="action" value="clear_recent_posts">
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Clear recent posts history?')">
                        Clear Recent Posts
                    </button>
                </form>
            <?php else: ?>
                <p>No recent posts tracked yet. Start reading posts to see them here!</p>
            <?php endif; ?>
        </div>
        
        <!-- Search History -->
        <div class="cookie-card">
            <h3>🔍 Search History</h3>
            <p>We remember your search terms to provide quick access to your recent searches.</p>
            
            <?php if (!empty($search_history)): ?>
                <div class="data-list">
                    <?php foreach ($search_history as $index => $search): ?>
                        <div style="margin-bottom: 0.3rem;">
                            <span style="background: #e9ecef; padding: 0.2rem 0.5rem; border-radius: 3px;">
                                <?= htmlspecialchars($search) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <form method="POST" style="margin-top: 1rem;">
                    <input type="hidden" name="action" value="clear_search_history">
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Clear search history?')">
                        Clear Search History
                    </button>
                </form>
            <?php else: ?>
                <p>No search history yet. Use the search feature to see your searches here!</p>
            <?php endif; ?>
        </div>
        
        <!-- User Preferences -->
        <?php if (!empty($user_prefs)): ?>
        <div class="cookie-card">
            <h3>👤 User Preferences</h3>
            <div>
                <strong>Username:</strong> <?= htmlspecialchars($user_prefs['username']) ?><br>
                <strong>Account Type:</strong> <?= $user_prefs['is_admin'] ? 'Admin' : 'Regular User' ?><br>
                <strong>Last Login:</strong> <?= date('M d, Y g:i A', $user_prefs['last_login']) ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Privacy Controls -->
        <div class="cookie-card">
            <h3>🔒 Privacy Controls</h3>
            <p>Manage your privacy by controlling what data we store in cookies.</p>
            
            <div class="btn-group">
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="clear_all">
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('This will clear ALL cookies including login status. Continue?')">
                        🗑️ Clear All Cookies
                    </button>
                </form>
                
                <a href="<?= ROOT_URL ?>Blog.php" class="btn btn-primary">
                    📚 Back to Blog
                </a>
                
                <a href="<?= ROOT_URL ?>Index.php" class="btn btn-success">
                    🏠 Home
                </a>
            </div>
        </div>
        
        <!-- Cookie Information -->
        <div class="cookie-card">
            <h3>ℹ️ Cookie Information</h3>
            <div style="font-size: 0.9rem; line-height: 1.6;">
                <p><strong>Essential Cookies:</strong> These cookies are necessary for the website to function and cannot be switched off.</p>
                <p><strong>Preference Cookies:</strong> These cookies allow us to remember your choices and provide enhanced features.</p>
                <p><strong>Analytics Cookies:</strong> These cookies help us understand how you use our website (currently not implemented).</p>
                
                <h4 style="margin-top: 1.5rem;">Cookie Types We Use:</h4>
                <ul>
                    <li><strong>jhakaas_remember_me:</strong> Keeps you logged in (encrypted, 30 days)</li>
                    <li><strong>jhakaas_user_prefs:</strong> Stores user preferences (encrypted, 1 year)</li>
                    <li><strong>jhakaas_theme:</strong> Remembers your theme choice (1 year)</li>
                    <li><strong>jhakaas_recent_posts:</strong> Tracks recently viewed posts (7 days)</li>
                    <li><strong>jhakaas_search_history:</strong> Stores recent searches (30 days)</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php include 'Partials/Footer.php'; ?>