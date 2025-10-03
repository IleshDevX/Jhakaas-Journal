<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Config/Database.php';

// Debug function
function debug_log($message) {
    error_log(date('Y-m-d H:i:s') . " - " . $message);
    echo "<p style='background: #f0f0f0; padding: 5px; margin: 5px 0;'><strong>DEBUG:</strong> " . htmlspecialchars($message) . "</p>";
}

echo "<h2>Add Post Debug</h2>";

debug_log("Session status: " . session_status());
debug_log("Session ID: " . session_id());

// Check if user is logged in
if(isset($_SESSION['user-id'])) {
    debug_log("User is logged in with ID: " . $_SESSION['user-id']);
} else {
    debug_log("User is NOT logged in");
    foreach($_SESSION as $key => $value) {
        debug_log("Session key: $key = " . (is_array($value) ? print_r($value, true) : $value));
    }
}

// Check POST data
if($_POST) {
    debug_log("POST data received:");
    foreach($_POST as $key => $value) {
        debug_log("POST $key = " . htmlspecialchars($value));
    }
} else {
    debug_log("No POST data");
}

// Check FILES data
if($_FILES) {
    debug_log("FILES data received:");
    foreach($_FILES as $key => $file) {
        debug_log("FILE $key: name=" . $file['name'] . ", size=" . $file['size'] . ", error=" . $file['error']);
    }
} else {
    debug_log("No FILES data");
}

// Test database connection
try {
    $result = $connection->query("SELECT COUNT(*) as count FROM posts");
    $count = $result->fetch_assoc()['count'];
    debug_log("Database connection OK. Posts count: " . $count);
} catch(Exception $e) {
    debug_log("Database error: " . $e->getMessage());
}

echo "<br><a href='Admin/Add-Post.php'>Go to Add Post Form</a>";
?>