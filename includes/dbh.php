<?php 

$host = 'localhost';
$dbname = 'col_miau';
$dbusername = 'root';
$dbpassword = '123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", 
    $dbusername, $dbpassword);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e -> getMessage();
    exit;
}
