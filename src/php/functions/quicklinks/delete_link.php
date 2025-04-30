<?php
session_start();
require_once '../../../../config/config.php';
require_once '../../includes/db_connect.php';
$user_id = $_SESSION['user_id'] ?? null;
$link_id = $_POST['link_id'] ?? null;

if ($user_id && $link_id) {
    $stmt = $conn->prepare("DELETE FROM quick_links WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $link_id, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ../../../views/dashboard.php");
    exit();
} else {
    echo 'error';
}