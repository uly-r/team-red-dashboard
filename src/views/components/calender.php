<?php
require_once __DIR__ . '/../../php/includes/db_connect.php';

$user_id = $_SESSION['user_id'];

// Fetch tasks and group by due date
$tasksByDate = [];
$sql = "SELECT title, due_date FROM tasks WHERE user_id = ? AND is_completed = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $date = date('j', strtotime($row['due_date'])); // just the day number
    $title = htmlspecialchars($row['title']);
    if (!isset($tasksByDate[$date])) {
        $tasksByDate[$date] = [];
    }
    $tasksByDate[$date][] = $title;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="bg-white/80 backdrop-blur-md border border-slate-300 rounded-2xl p-4 shadow-xl flex flex-col items-start transition hover:shadow-2xl hover:border-slate-400">
        <div class="calendar w-full">
            <h2 class="text-xl font-bold mb-2">Calendar</h2>
            <div class="flex justify-between items-center mb-4">
                <button onclick="prevMonth()" class="px-2 py-1 bg-gray-200 rounded">&lt;</button>
                <h3 id="current-month" class="font-medium"><?php echo date('F Y'); ?></h3>
                <button onclick="nextMonth()" class="px-2 py-1 bg-gray-200 rounded">&gt;</button>
            </div>
            <div class="grid grid-cols-7 gap-1 mb-2">
                <?php
                $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                foreach ($days as $day) {
                    echo '<div class="text-center font-bold text-sm">' . $day . '</div>';
                }
                ?>
            </div>
            <div class="grid grid-cols-7 gap-1" id="calendar-days">
                <?php
                $today = date('j');
                $currentMonth = date('n');
                $currentYear = date('Y');
                $firstDayOfWeek = date('w', mktime(0, 0, 0, $currentMonth, 1, $currentYear));
                for ($i = 0; $i < $firstDayOfWeek; $i++) {
                    echo '<div class="h-8"></div>';
                }
                $daysInMonth = date('t');
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $isToday = ($i == $today);
                    $hasTask = isset($tasksByDate[$i]);
                    $taskTitles = $hasTask ? implode(', ', $tasksByDate[$i]) : '';
                
                    echo '<div 
                        onclick="selectDate(this)" 
                        class="h-8 flex items-center justify-center rounded-full cursor-pointer ' .
                        ($isToday ? 'bg-blue-500 text-white ' : '') .
                        ($hasTask ? 'bg-yellow-300 hover:bg-yellow-400 ' : 'hover:bg-gray-100') .
                        '" title="' . htmlspecialchars($taskTitles) . '">' . $i . 
                        '</div>';
                }               
                ?>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function selectDate(el) {
        // Remove highlight from all dates
        document.querySelectorAll('#calendar-days div').forEach(div => {
            div.classList.remove('bg-blue-500', 'text-white');
        });

        // Highlight selected date
        el.classList.add('bg-blue-500', 'text-white');
    }

    function prevMonth() {
        alert("Previous month");
    }

    function nextMonth() {
        alert("Next month");
    }
</script>
