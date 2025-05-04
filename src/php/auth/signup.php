<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../../php/includes/db_connect.php';
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute()) {
        header("Location: ../../../public/login.html"); //must be modified if files are moved
    } else {
        echo "Signup failed: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>