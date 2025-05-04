<?php
require_once '../../php/includes/db_connect.php';
session_start();

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task_name'], $_POST['task_description'], $_POST['date_due'], $_POST['task_status'])) {

        //get data from POST
        $taskID = $_POST['task_id'];
        $title = $_POST['task_name'];
        $desc = $_POST['task_description'];
        $due_date = $_POST['date_due'];
        $is_completed = $_POST['task_status'];

        // updates where user id AND task id are the same (ensures the correct task and that it belons to the user)
        $stmt = $conn->prepare("UPDATE tasks SET title = ?, description=?, due_date=? , is_completed =? WHERE id =? AND user_id =? ");
        $stmt->bind_param("sssiii", $title, $desc, $due_date, $is_completed, $taskID, $user_id);
        if ($stmt->execute()) {
           /*
            this refreshes and redirects back to the task page
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
