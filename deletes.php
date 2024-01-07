<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "let";

$pdo = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
    $id = $_GET['id'];
    $sql = "DELETE FROM `yt_link` WHERE `id` = :id";     
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id); 
    $stmt->execute();
    $_SESSION['message'] = "Record Deleted successfully!";
    header("Location:home.php");
    exit();



} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


$pdo = null;
?>