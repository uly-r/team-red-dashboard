<?php
session_start();
require_once __DIR__ . '/../../php/includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../public/login.html?error=Please+log+in");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get current user data
$stmt = $conn->prepare("SELECT username, email, password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    session_destroy();
    header("Location: ../../../public/login.html?error=User+not+found");
    exit();
}

// Flag to track whether any data was successfully updated
$updated = false;

// Check if a new username was submitted and it's different from the current one
if (!empty($_POST['username']) && $_POST['username'] !== $user['username']) {
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    if (!empty($username)) {
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $username, $user_id);
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $updated = true;
        }
    }
}

// Check if a new email was submitted and it's different
if (!empty($_POST['email']) && $_POST['email'] !== $user['email']) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $email, $user_id);
        if ($stmt->execute()) {
            $updated = true;
        }
    }
}
// Check if the user submitted a new password
if (!empty($_POST['new_password'])) {
    // Check if current password is set
    if (empty($_POST['current_password'])) {
        header("Location: ../editprofile.php?error=Current+password+required");
        exit();
    }

    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    // Verify current password
    if (!password_verify($current_password, $user['password'])) {
        header("Location: ../editprofile.php?error=Incorrect+current+password");
        exit();
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);
    if ($stmt->execute()) {
        header("Location: ../../views/dashboard.php?success=Password+updated");
        exit();
    }
}


// Redirect to dashboard after all updates
if ($updated) {
    header("Location: ../dashboard.php?success=Profile+updated");
} else {
    header("Location: ../editprofile.php?error=No+changes+made+or+invalid+input");
}
exit();
