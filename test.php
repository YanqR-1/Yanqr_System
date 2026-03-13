<?php
echo "<h1>YanqR System Test</h1>";

// Check if models folder exists
$models_path = __DIR__ . '/app/models';
if (file_exists($models_path)) {
    echo "<p style='color:green'>✓ Models folder exists</p>";
    
    // Check if UserModel.php exists
    if (file_exists($models_path . '/UserModel.php')) {
        echo "<p style='color:green'>✓ UserModel.php exists</p>";
    } else {
        echo "<p style='color:red'>✗ UserModel.php not found</p>";
    }
} else {
    echo "<p style='color:red'>✗ Models folder not found</p>";
}

// Check controllers folder
$controllers_path = __DIR__ . '/app/controllers';
if (file_exists($controllers_path)) {
    echo "<p style='color:green'>✓ Controllers folder exists</p>";
    
    // Check if AuthController.php exists
    if (file_exists($controllers_path . '/AuthController.php')) {
        echo "<p style='color:green'>✓ AuthController.php exists</p>";
    } else {
        echo "<p style='color:red'>✗ AuthController.php not found</p>";
    }
} else {
    echo "<p style='color:red'>✗ Controllers folder not found</p>";
}

echo "<h2>Next Steps:</h2>";
echo "<ol>";
echo "<li>Make sure all files are created in the correct locations</li>";
echo "<li>Access: <a href='/yanqr_system/public/'>http://localhost/yanqr_system/public/</a></li>";
echo "</ol>";
?>