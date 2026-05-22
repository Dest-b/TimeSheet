<?php
session_start();

// Prevent registration while already logged in
if (isset($_SESSION['user_id'])) {
    die('Error: je kunt niet registreren terwijl je bent ingelogd');
}

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$password_check = $_POST['password_check'] ?? null;

// Basic validation
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Error: ongeldig e-mailadres');
}

if (!$password) {
    die('Error: wachtwoord mag niet leeg zijn');
}

if ($password !== $password_check) {
    die('Error: wachtwoorden komen niet overeen');
}

// Include DB connection
require_once 'conn.php';

// Uniqueness check
$query = "SELECT * FROM users WHERE username = :email";
$stmt = $conn->prepare($query);
$stmt->execute([
    ':email' => $email
]);

if ($stmt->rowCount() > 0) {
    die('Error: account bestaat al');
}

// Hash the password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user
$nameCandidate = strstr($email, '@', true);
if ($nameCandidate === false || $nameCandidate === '') {
    $nameCandidate = $email;
}
$name = str_replace(['.', '_', '-'], ' ', $nameCandidate);
$name = ucwords($name);

$insertQuery = "INSERT INTO users (name, username, password) VALUES (:name, :email, :hash)";
$insertStmt = $conn->prepare($insertQuery);
$insertStmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':hash' => $hash
]);

// Redirect to login
header('Location: ../login.php');
exit;
