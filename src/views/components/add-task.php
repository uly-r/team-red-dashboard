<?php
require_once '../../php/includes/db_connect.php';
session_start();

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

    //This gets the key of the array, so the left side of $fields
    $columns = array_keys($fields);
    
    //Creates an array of '?' for the size of $fields
    $placeholders = array_fill(0, count($fields), '?');

    //extracts the values of the array (right hand of $fields (information from _POST))
    $values = array_values($fields);

    //empty string, using for binding 
    $types = '';
    foreach ($values as $value) {
        $types .= is_numeric($value) ? 'i' : 's';   //May need to be changed if more types are added
    }

    //makes an SQL stmt with the column names, and the amount of placeholders from earlier
    $sql = "INSERT INTO tasks (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    //types is the expected type ex: isssii,  "..." unpacks the information from values
    $stmt->bind_param($types, ...$values);

   if ($stmt->execute()) {
    header("Location: ../dashboard.php");
    exit();
} else {
    echo "<script>alert('An error occurred. Please try again later.');</script>"; 
}
    $stmt->close();
}
?>
