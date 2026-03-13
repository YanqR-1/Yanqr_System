<?php
session_start();
require_once 'config/database.php';

$database = new Database();
$db = $database->connect();

// Get all users
$query = "SELECT id, username, profile_image FROM users";
$result = $db->query($query);

echo "<h1>User Profile Images</h1>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Username</th><th>Profile Image</th><th>File Exists?</th><th>Full Path</th></tr>";

while ($row = $result->fetch_assoc()) {
    $image_path = 'public/assets/uploads/profiles/' . $row['profile_image'];
    $full_path = 'C:/Xampp/htdocs/yanqr_system/' . $image_path;
    $file_exists = file_exists($full_path) ? 'Yes' : 'No';
    
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['profile_image'] . "</td>";
    echo "<td>" . $file_exists . "</td>";
    echo "<td>" . $full_path . "</td>";
    echo "</tr>";
}

echo "</table>";

// Show session data
echo "<h2>Session Data</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>