<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../public/login.html"); // adjust path if needed
    exit();
}
require_once '../php/includes/db_connect.php';
$user_id = $_SESSION['user_id'];

function renderDeleteButton($taskID)
{
    /*
     this shows the delete button which when clicked, pops up an alert
     which then the user confirms to delete their task
     the request is then sent to delete-task.php
*/
    return '
        <form action="components/delete-task.php" method="POST">
            <input type="hidden" name="task_id" value="' . htmlspecialchars($taskID) . '">
            <button type="submit" onclick="return confirm(\'Delete this task?\');">Delete</button>
        </form>
    ';
}

function getTaskStatusLabel($taskStatus)
{
    //convert 0 or 1 to completed or not completed status
    return $taskStatus == 1 ? 'Completed' : 'Not Completed';
}

function renderEditButton($task) {
    // Grabs the values of the current row(array) and passes them to the form
     return '
         <button onclick="openForm(' .
             htmlspecialchars($task['id']) . ', \'' .
             htmlspecialchars($task['title']) . '\', \'' .
             htmlspecialchars($task['description']) . '\', \'' .
             $task['is_completed'] . '\', \'' .
             htmlspecialchars($task['due_date']) . '\')">Edit</button>';
 }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../public/assets/task-form.css" rel="stylesheet">
    <title>Task page</title>
</head>

<body>

    <div class="bg-white rounded-xl p-4 shadow flex flex-col items-start">
        <div>
            <h2>Task Tracker</h2> 
        </div>
            <button type="button" onclick="openFormAdd()" style="all: revert;">Add A Task</button>
        <div>
            <!--Start of table-->
            <table class="table table-striped table-hover" id="taskTable"> <!--Add later-->
                <thead>
                    <tr>
                        <th scope="col">Task Name</th>
                        <th scope="col">Task Description</th>
                        <th scope="col">Date Due</th>
                        <th scope="col">Task Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //get the users tasks using their user_id
                    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    //prints out tasks
                    while ($row = $result->fetch_assoc()) {
                        $taskID = $row['id'];
                        $taskName = $row['title'];
                        $taskDesc = $row['description'];
                        $dateDue = $row['due_date'];
                        $taskStatus = $row['is_completed'];
                    ?>
                        <!-- This is the row that is printed for each task-->
                        <tr>
                            <td id="taskName-<?= $taskID ?>"><?= htmlspecialchars($taskName) ?></td>
                            <td id="taskDesc-<?= $taskID ?>"><?= htmlspecialchars($taskDesc) ?></td>
                            <td id="dateDue-<?= $taskID ?>"><?= htmlspecialchars($dateDue) ?></td>
                            <td id="taskStatus-<?= $taskID ?>"><?= getTaskStatusLabel($taskStatus); ?> </td>
                            <td><?= renderEditButton($row);?></td> <!-- Will add this later-->
                            <td><?= renderDeleteButton($taskID); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>  <!--End of table-->
        </div>

        <!-- Add Task Form -->
        <div class ="form-popup" id = "addTaskForm">
            <form action="components/add-task.php" method="POST" class ="form-container">
                <div>
                    <label for="taskName">Task Name:</label>
                    <input type="text" class="form-control" id="taskName" name="task_name" required>
                </div>

                <div>
                    <label for="taskDesc">Task Description:</label>
                    <input type="text" class="form-control" id="taskDesc" name="task_description" required>
                </div>

                <div>
                    <label for="taskStatus">Task Status:</label>
                    <select class="form-control" name="task_status" id="taskStatus" required>
                        <option value="">-select-</option>
                        <option value="False">Not Completed</option>
                        <option value="True">Completed</option>
                    </select>
                </div>

                <div>
                    <label for="shootdate">Desired Date:</label>
                    <input required type="date" name="date_due" id="shootdate" title="Choose your desired date" min="<?php echo date('Y-m-d'); ?>" />
                </div>

                <div style="margin-top:10px;">
                <button type="submit" class="btn">Save Task</button>
                <button type="button" onclick="closeFormAdd()" class="btn cancel">Close</button>
                </div>
            </form>
        </div>

     <!-- Edit Task Form -->
     <div class="form-popup"  id = "updateTaskForm">
     <form action="components/update-task.php" method="POST"  class="form-container">
        <!-- Hidden task ID -->
        <input type="hidden" id="updateTaskID" name="task_id">

        <div>
            <label for="updateTaskName">Task Name:</label>
            <input type="text" id="updateTaskName" name="task_name" required>
        </div>

        <div>
            <label for="updateTaskDesc">Task Description:</label>
            <input type="text" id="updateTaskDesc" name="task_description" required>
        </div>

        <div>
            <label for="updateTaskStatus">Task Status:</label>
            <select name="task_status" id="updateTaskStatus" required>
                <option value="">-select-</option>
                <option value="0">Not Completed</option>
                <option value="1">Completed</option>
            </select>
        </div>

        <div>
            <label for="updateShootdate">Desired Date:</label>
            <input required type="date" name="date_due" id="updadatedate_due" min="<?php echo date('Y-m-d'); ?>" />
        </div>
        <button type="submit" class="btn">Update Task</button>
        <button type="button" onclick="closeForm()" class="btn cancel">Close</button>
        </form>
        </div>


        

<!--This may be moved in the future for better organization -->
<script>

function openFormAdd( title, desc, status, date) {
  // show the form (if it's hidden)
  document.getElementById("addTaskForm").style.display = "block";
}

function closeFormAdd() {
  document.getElementById("addTaskForm").style.display = "none";
}

function openForm(id, title, desc, status, date) {
  // show the form (if it's hidden)
  document.getElementById("updateTaskForm").style.display = "block";

  /* Pre fill the form with the current row's values
    This allows the user to see their previously entered fields
    and they can adjust accordingly
  */
  document.getElementById("updateTaskID").value = id;
  document.getElementById("updateTaskName").value = title;
  document.getElementById("updateTaskDesc").value = desc;
  document.getElementById("updateTaskStatus").value = status;
  document.getElementById("updadatedate_due").value = date;
}

function closeForm() {
  document.getElementById("updateTaskForm").style.display = "none";
}
</script>

</body>

</html>