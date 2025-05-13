<?php
require_once '../../php/includes/db_connect.php';
require_once '../../php/classes/TaskManager.php';
session_start();

$taskManager = new TaskManager($conn, $_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $taskManager->deleteTask($_POST['task_id']);
    header("Location: ../dashboard.php");
} else {
        echo "<script>alert('An error occurred while updating.');</script>";
}
?>
