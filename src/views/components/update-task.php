<?php
require_once '../../php/includes/db_connect.php';
require_once '../../php/classes/TaskManager.php';
session_start();

$taskManager = new TaskManager($conn, $_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($taskManager->updateTask($_POST)) {
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "<script>alert('An error occurred while updating.');</script>";
    }
}
?>
