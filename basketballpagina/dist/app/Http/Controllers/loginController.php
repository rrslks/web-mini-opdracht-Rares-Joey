<?php
session_start();

// Debugging (remove in production)
//var_dump($_POST);

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    // Handle missing input, redirect or display error
    die("Error: username and password are required.");
}

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username = ?";

require_once '../../../config/conn.php';

$statement = $conn->prepare($query);
$statement->bindParam(1, $username);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Handle user not found
    die("Error: account does not exist.");
}

if (!password_verify($password, $user['password'])) {
    // Handle incorrect password
    die("Error: incorrect password.");
}

$_SESSION['user_id'] = $user['id'];

header("Location: ../../index.php");
exit();
?>