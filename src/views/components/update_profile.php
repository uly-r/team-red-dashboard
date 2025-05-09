<?php
session_start();
require_once __DIR__ . '/../../php/includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../public/login.html?error=Please+log+in");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current user
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

// Handle main form submission (update_all)
if (isset($_POST['update_all']) && $_POST['update_all'] === '1') {
    $username = filter_var(trim($_POST['username'] ?? ''), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $new_password = trim($_POST['new_password'] ?? '');
    $current_password = trim($_POST['current_password'] ?? '');

    $errors = [];
    if (!$username) {
        $errors[] = "Username is required";
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    if ($new_password && !$current_password) {
        $errors[] = "Current password is required for password change";
    }
    if ($new_password && $current_password && !password_verify($current_password, $user['password'])) {
        $errors[] = "Current password is incorrect";
    }

    if (!empty($errors)) {
        header("Location: ../editprofile.php?error=" . urlencode(implode(", ", $errors)));
        exit();
    }

    $updates = false;

    // Update username
    if ($username !== $user['username']) {
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $username, $user_id);
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $updates = true;
        } else {
            $errors[] = "Failed to update username";
        }
    }

    // Update email
    if ($email !== $user['email']) {
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $email, $user_id);
        if ($stmt->execute()) {
            $updates = true;
        } else {
            $errors[] = "Failed to update email";
        }
    }

    // Update password
    if ($new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $user_id);
        if ($stmt->execute()) {
            $updates = true;
        } else {
            $errors[] = "Failed to update password";
        }
    }

    if (!empty($errors)) {
        header("Location: ../editprofile.php?error=" . urlencode(implode(", ", $errors)));
        exit();
    }

    $message = $updates ? "Profile updated successfully" : "No changes made";
    header("Location: ../dashboard.php?success=" . urlencode($message));
    exit();
}

// Handle modal form submission (single field)
$field = filter_var(trim($_POST['field_name'] ?? ''), FILTER_SANITIZE_STRING);
$new_value = trim($_POST['new_value'] ?? '');
$current_password = trim($_POST['current_password'] ?? '');

if (!$field || $new_value === '') {
    header("Location: ../editprofile.php?error=Invalid+request");
    exit();
}

// Allowed fields to be updated
$allowed_fields = ['username', 'email', 'password'];
if (!in_array($field, $allowed_fields)) {
    header("Location: ../editprofile.php?error=Unauthorized+field");
    exit();
}

// If updating password, verify current password
if ($field === 'password') {
    if (!$current_password || !password_verify($current_password, $user['password'])) {
        header("Location: ../editprofile.php?error=Current+password+is+incorrect");
        exit();
    }
    $new_value = password_hash($new_value, PASSWORD_DEFAULT);
}

// Prepare dynamic query
$query = "UPDATE users SET $field = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $new_value, $user_id);

if ($stmt->execute()) {
    if ($field === 'username') {
        $_SESSION['username'] = $new_value;
    }
    header("Location: ../dashboard.php?success=Profile+updated+successfully");
    exit();
} else {
    header("Location: ../editprofile.php?error=Failed+to+update+profile");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="../dashboard.php"></a>
    <a href="../editprofile.php"></a>

    <a href="../../../public//login.html"></a>
</body>
</html>