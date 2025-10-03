<?php
require_once 'Config/Database.php';

echo "<h2>Database Connection Test</h2>";

// Test the connection
if ($connection) {
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Test if tables exist
    $tables = ['categories', 'users', 'posts'];
    
    foreach($tables as $table) {
        $result = $connection->query("SHOW TABLES LIKE '$table'");
        if($result->num_rows > 0) {
            echo "<p style='color: green;'>✓ Table '$table' exists</p>";
            
            // Count records
            $count_result = $connection->query("SELECT COUNT(*) as count FROM $table");
            $count = $count_result->fetch_assoc()['count'];
            echo "<p style='margin-left: 20px;'>Records in $table: $count</p>";
            
        } else {
            echo "<p style='color: red;'>✗ Table '$table' does not exist</p>";
        }
    }
    
    // Test categories
    echo "<h3>Categories:</h3>";
    $result = $connection->query("SELECT * FROM categories");
    if($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<p>- " . $row['title'] . "</p>";
        }
    } else {
        echo "<p>No categories found</p>";
    }
    
} else {
    echo "<p style='color: red;'>✗ Database connection failed!</p>";
}

echo "<br><a href='Index.php'>Go to Home Page</a>";
?>