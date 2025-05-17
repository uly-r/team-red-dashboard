<?php
// Make sure session is started and $conn exists before this code runs
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo "User not logged in.";
    return;
}

// Step 1: Get earliest due incomplete task (Task A)
$sqlA = "SELECT * FROM tasks WHERE user_id = ? AND is_completed = 0 ORDER BY due_date ASC, task_priority DESC LIMIT 1";
$stmtA = $conn->prepare($sqlA);
$stmtA->bind_param("i", $userId);
$stmtA->execute();
$resultA = $stmtA->get_result();
$taskA = $resultA->fetch_assoc();

if (!$taskA) {
    // No tasks found
    $task = null;
} else {
    // Step 2: Get any higher priority task due within 1 day after Task A
    $dueDateA = $taskA['due_date'];
    $priorityA = (int) $taskA['task_priority'];

    $sqlB = "SELECT * FROM tasks 
             WHERE user_id = ? 
               AND is_completed = 0
               AND task_priority > ? 
               AND due_date > ? 
               AND due_date <= DATE_ADD(?, INTERVAL 1 DAY)
             ORDER BY due_date ASC LIMIT 1";
    $stmtB = $conn->prepare($sqlB);
    $stmtB->bind_param("isss", $userId, $priorityA, $dueDateA, $dueDateA);
    $stmtB->execute();
    $resultB = $stmtB->get_result();
    $taskB = $resultB->fetch_assoc();

    // Step 3: Decide which to recommend
    if ($taskB) {
        $task = $taskB;
    } else {
        $task = $taskA;
    }
}
?>

<div class="bg-white rounded-xl p-4 shadow">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Recommended Task</h2>
    <?php if ($task): ?>
        <div class="p-3 rounded border-l-4 border-blue-500 bg-blue-50">
            <h3 class="font-semibold text-md text-gray-900"><?= htmlspecialchars($task['title']) ?></h3>
            <p class="text-sm text-gray-600"><?= date("F j, Y", strtotime($task['due_date'])) ?></p>
        </div>
    <?php else: ?>
        <p class="text-sm text-gray-500">No upcoming tasks found.</p>
    <?php endif; ?>
</div>


<!-- How it works now:
Step 1: Pick the earliest due incomplete task (Task A)
This ensures you always consider the task that’s due the soonest. This respects deadlines as your primary factor.

Step 2: Check if there is a higher priority task due shortly after Task A (within 1 day)
This step checks if you have a more urgent task coming up soon — but not immediately due — which deserves your attention first.

Step 3: Recommend either the higher priority task (Task B) or the earliest due task (Task A)
If there’s a higher priority task due within 1 day after Task A’s due date, you get recommended that higher priority
 task instead. Otherwise, you do the earliest due task. -->