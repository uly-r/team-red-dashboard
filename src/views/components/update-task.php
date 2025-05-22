<?php
require_once '../../php/includes/db_connect.php';
require_once '../../php/classes/TaskManager.php';
require_once '../../php/classes/Validate.php';
session_start();
header('Content-Type: application/json');

$taskManager = new TaskManager($conn, $_SESSION['user_id']);
$validator = new Validate();

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {

    if (!$validator->validateTask($_POST)) {
        echo json_encode(['success' => false, 'validationErrors' => $validator->getErrors()]);
        exit;
    }
//sends a json response to let the JS script know if the task was added successfully or if there was an error
    if ($taskManager->addTask($_POST)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update task']);
    }
} else {
    http_response_code(400);    // bad request
    echo json_encode(['success' => false, 'error' => 'Invalid']);
}

?>