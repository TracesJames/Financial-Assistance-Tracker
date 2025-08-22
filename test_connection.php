<?php
/**
 * Test Database Connection for Financial Assistance Disbursement Tracker
 */

require_once 'config/database.php';

echo "<h2>Financial Assistance Disbursement Tracker - Database Connection Test</h2>\n";

try {
    // Display configuration
    $config = DatabaseConfig::getConfig();
    echo "<h3>Database Configuration:</h3>\n";
    echo "<ul>\n";
    echo "<li><strong>Host:</strong> " . $config['host'] . "</li>\n";
    echo "<li><strong>Port:</strong> " . $config['port'] . "</li>\n";
    echo "<li><strong>Database:</strong> " . $config['database'] . "</li>\n";
    echo "<li><strong>Username:</strong> " . $config['username'] . "</li>\n";
    echo "<li><strong>Charset:</strong> " . $config['charset'] . "</li>\n";
    echo "</ul>\n";
    
    // Test connection
    echo "<h3>Connection Test:</h3>\n";
    
    if (DatabaseConfig::testConnection()) {
        echo "<p style='color: green;'><strong>✓ SUCCESS:</strong> Connected to financial-assistance-disbursement-tracker database!</p>\n";
        
        // Get additional database info
        $pdo = DatabaseConfig::getConnection();
        $stmt = $pdo->query('SELECT VERSION() as version');
        $version = $stmt->fetch();
        echo "<p><strong>MySQL Version:</strong> " . $version['version'] . "</p>\n";
        
        // Check if database exists, if not create it
        $stmt = $pdo->query("SHOW DATABASES LIKE 'financial_assistance_disbursement_tracker'");
        if ($stmt->rowCount() == 0) {
            echo "<p style='color: orange;'><strong>⚠ WARNING:</strong> Database 'financial_assistance_disbursement_tracker' does not exist.</p>\n";
            echo "<p>Creating database...</p>\n";
            
            $pdo->exec("CREATE DATABASE IF NOT EXISTS financial_assistance_disbursement_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "<p style='color: green;'><strong>✓ SUCCESS:</strong> Database 'financial_assistance_disbursement_tracker' created!</p>\n";
        } else {
            echo "<p style='color: green;'><strong>✓ SUCCESS:</strong> Database 'financial_assistance_disbursement_tracker' exists!</p>\n";
        }
        
    } else {
        echo "<p style='color: red;'><strong>✗ FAILED:</strong> Could not connect to database!</p>\n";
        echo "<p>Please check your XAMPP MySQL service and database configuration.</p>\n";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>✗ ERROR:</strong> " . $e->getMessage() . "</p>\n";
    
    // Provide troubleshooting steps
    echo "<h3>Troubleshooting Steps:</h3>\n";
    echo "<ol>\n";
    echo "<li>Ensure XAMPP MySQL service is running</li>\n";
    echo "<li>Check if the database 'financial_assistance_disbursement_tracker' exists in phpMyAdmin</li>\n";
    echo "<li>Verify database credentials in config/database.php</li>\n";
    echo "<li>Make sure port 3306 is not blocked</li>\n";
    echo "</ol>\n";
}

echo "<hr>\n";
echo "<p><strong>Next Steps:</strong></p>\n";
echo "<ul>\n";
echo "<li>Access phpMyAdmin at: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>\n";
echo "<li>View this application at: <a href='http://localhost/Financial-Assistance-Tracker/' target='_blank'>http://localhost/Financial-Assistance-Tracker/</a></li>\n";
echo "</ul>\n";
?>
