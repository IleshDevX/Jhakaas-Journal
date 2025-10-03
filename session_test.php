<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Config/Database.php';

echo "<h2>Session and Database Test</h2>";

// Check session
if(isset($_SESSION['user-id'])) {
    echo "<p style='color: green;'>✓ User is logged in with ID: " . $_SESSION['user-id'] . "</p>";
    
    // Get user details
    $user_id = $_SESSION['user-id'];
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if($user) {
        echo "<p>User: " . $user['first_name'] . " " . $user['last_name'] . "</p>";
        echo "<p>Username: " . $user['username'] . "</p>";
        echo "<p>Admin: " . ($user['is_admin'] ? 'Yes' : 'No') . "</p>";
    }
    
} else {
    echo "<p style='color: red;'>✗ User is not logged in</p>";
}

// Check if posts table exists and show structure
echo "<h3>Posts Table Structure:</h3>";
$result = $connection->query("DESCRIBE posts");
if($result) {
    while($row = $result->fetch_assoc()) {
        echo "<p>- " . $row['Field'] . " (" . $row['Type'] . ")</p>";
    }
}

// Check categories
echo "<h3>Available Categories:</h3>";
$result = $connection->query("SELECT * FROM categories");
if($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>- ID: " . $row['id'] . ", Title: " . $row['title'] . "</p>";
    }
}

echo "<br><a href='Admin/Add-Post.php'>Add Post</a> | <a href='SignIn.php'>Sign In</a>";
?>