<?php
require_once __DIR__ . '/../../php/includes/db_connect.php';
$user_id = $_SESSION['user_id'] ?? null;
$tasks = [];

if ($user_id) {
    // 1. Get the soonest due date for incomplete tasks
    $stmt = $conn->prepare("SELECT MIN(due_date) AS closest_date FROM tasks WHERE user_id = ? AND is_completed = 0 AND due_date >= CURDATE()");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $closestDate = $row['closest_date'];

    // 2. Get all tasks due on that date and still incomplete
    if ($closestDate) {
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND due_date = ? AND is_completed = 0");
        $stmt->bind_param("is", $user_id, $closestDate);
        $stmt->execute();
        $tasks = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<div class="bg-white/80 backdrop-blur-md border border-slate-300 rounded-2xl p-4 shadow-xl transition hover:shadow-2xl hover:border-slate-400">
<div class="bg-white rounded-xl p-4 shadow-md w-full h-full">
<h3 class="text-lg font-bold mb-2">Next Task Countdown</h3>
    <?php if (!empty($tasks)): ?>
        <p class="mb-2">
            <strong><?= count($tasks) ?> task(s)</strong> due on <strong><?= htmlspecialchars($closestDate) ?></strong>
        </p>
        <ul class="list-disc pl-5 mb-2">
            <?php foreach ($tasks as $task): ?>
                <li><?= htmlspecialchars($task['title']) ?></li>
            <?php endforeach; ?>
        </ul>

        <div id="time-remaining" class="text-blue-600 text-xl font-semibold"></div>
        <script>
            const countdownDate = new Date("<?= $closestDate ?>T23:59:59").getTime();

            const countdownFunction = setInterval(() => {
                const now = new Date().getTime();
                const distance = countdownDate - now;

                if (distance <= 0) {
                    clearInterval(countdownFunction);
                    document.getElementById("time-remaining").innerHTML = "Due date reached!";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("time-remaining").innerHTML =
                    `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }, 1000);
        </script>
    <?php else: ?>
        <p>No upcoming tasks found.</p>
    <?php endif; ?>
</div>
</div>