<?php
require_once '../../php/includes/db_connect.php';
session_start();

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['task_name'], $_POST['task_description'], $_POST['date_due'], $_POST['task_status'])
    ) {
        $title = $_POST['task_name'];
        $desc = $_POST['task_description'];
        $due_date = $_POST['date_due'];
        $is_completed = $_POST['task_status'] === 'True' ? 1 : 0;

        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, is_completed) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $user_id, $title, $desc, $due_date, $is_completed);

        if ($stmt->execute()) {

           /*
            this refreshes and redirects back to the task page, this may be changed since its hard coded
           */

           header("Location: ../dashboard.php");
           exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "<script>
                alert('An Error occurred.');
              </script>";
    }
}
?>
