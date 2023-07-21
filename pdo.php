<?php
// Database configuration
$host = $_ENV['DB_HOST'];        // Use the environment variable set in docker-compose.yml
$dbname = $_ENV['DB_DATABASE'];  // Use the environment variable set in docker-compose.yml
$user = $_ENV['DB_USER'];        // Use the environment variable set in docker-compose.yml
$pass = $_ENV['DB_PASSWORD'];    // Use the environment variable set in docker-compose.yml

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
