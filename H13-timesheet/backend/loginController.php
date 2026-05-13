<?php 
session_start();
require_once 'config.php';
require_once 'conn.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if (!$username || !$password) {
	die('Error: ontbrekende inloggegevens');
}

$query = "SELECT * FROM users WHERE username = :username";
$statement = $conn->prepare($query);
$statement->execute([":username" => $username]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

// if ($statement->rowCount() < 1) {  #onbetrouwbaar na fetch(), 
if ($user === false) { 
	die("Error: account bestaat niet");
}

if (!password_verify($password, $user['password'])) {
	die("Error: wachtwoord niet juist!");
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];

header("Location: {$base_url}/logs/index.php");
exit;