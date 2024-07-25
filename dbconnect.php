<?php
 //database connection variables for your UOS webspace database
 $servername = "localhost";
 $username = "cet138a2";
 $password = "#cet138a2#";
 $database = "bi51hf"; 

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    error_log($e->getMessage());
    exit('Database connection failed');
}
?>