<?php
require_once '../../php/includes/db_connect.php';
session_start();

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['task_id'])) {

        echo "<script>alert('Invalid Task ID.');</script>";
        exit;
    }

    $taskID = $_POST['task_id'];

    //Add or remove fields more easily
    $fields = [
        //Left is the actual name of the column, middle is the values from _POST, right is default values (error case) 
        'user_id'      => $user_id,
        'title'        => $_POST['task_name'] ?? 'dflt',
        'description'  => $_POST['task_description'] ?? 'dflt',
        'due_date'     => $_POST['date_due'] ?? 'dflt',
        'is_completed' => $_POST['task_status'] ?? 0,
        'task_priority'=> $_POST['taskPriority'] ?? 1
    ];

    $set_clause = [];
    $values = [];
    $types = '';

    foreach ($fields as $column => $value) {
        //save left side of $fields
        $set_clause[] = "$column = ?";

        //the information from $_POST
        $values[] = $value;

        // save the type, used to bind the expected type
        $types .= is_numeric($value) ? 'i' : 's';
    }

    // Add the WHERE condition values
    $values[] = $taskID;
    $values[] = $user_id;
    $types .= 'ii';

    //makes an SQL stmt with the column names ex:  title = ?, description = ?, due_date = ?, is_completed = ?, task_priority = ?
    $sql = "UPDATE tasks SET " . implode(', ', $set_clause) . " WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>alert('An error occurred. Please try again.');</script>";
        exit;
    }

    //types is the expected type ex: isssii,  "..." unpacks the information from values
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "<script>alert('An error occurred.');</script>";
    }

    $stmt->close();
}
?>
