<?php
// Database credentials
$host = '127.0.0.1';
$dbname = 'ita';
$username = 'root';
$password = 'Atharv1107';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    // Handle connection error
    echo "Connection failed: " . $e->getMessage();
}

// Example query
$sql = "SELECT * FROM admin";
foreach ($pdo->query($sql) as $row) {
    print_r($row);
}
?>
