<?php
session_start();
var_dump($_SESSION); // Debug: check session contents
require_once '../../../../config/config.php';
require_once '../../includes/db_connect.php';

// Check if the request method is POST (i.e., form was submitted)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and assign POST data
    $title = htmlspecialchars($_POST['title'] ?? '');
    $url = filter_var($_POST['url'] ?? '', FILTER_SANITIZE_URL);
    $icon_class = htmlspecialchars($_POST['icon'] ?? '');
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id && !empty($title) && !empty($url) && !empty($icon_class)) {
        $stmt = $conn->prepare("INSERT INTO quick_links (user_id, title, url, icon_class) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $title, $url, $icon_class);
        $stmt->execute();
        $stmt->close();

        header("Location: ../../../views/dashboard.php");
        exit();
    } else {
        echo "Invalid input.";
    }
}