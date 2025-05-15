<?php
require_once '../../php/includes/db_connect.php';
require_once '../../php/classes/TaskManager.php';
session_start();
header('Content-Type: application/json');

$taskManager = new TaskManager($conn, $_SESSION['user_id']);

// sends a json response to let the JS script know if the task was deleted successfully or if there was an error
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    if ($taskManager->deleteTask($_POST['task_id'])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete task']);
    }
} else {
    http_response_code(400); // bad request
    echo json_encode(['success' => false, 'error' => 'Invalid']);
}
?>