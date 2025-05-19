<?php
require_once __DIR__ . '/../../php/includes/db_connect.php';
session_start();
$user_id = $_SESSION['user_id'] ?? 1; 


$tasksByDate = [];
$sql = "SELECT title, due_date FROM tasks WHERE user_id = ? AND is_completed = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $date = $row['due_date'];
    $title = htmlspecialchars($row['title']);
    $day = date('j', strtotime($date));
    $month = date('n', strtotime($date));
    $year = date('Y', strtotime($date));

    $key = "$year-$month-$day";
    if (!isset($tasksByDate[$key])) {
        $tasksByDate[$key] = [];
    }
    $tasksByDate[$key][] = $title;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dynamic Calendar</title>
  <link href="../assets/styles.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 text-gray-800 p-6">
  <div class="bg-white/80 backdrop-blur-md border border-slate-300 rounded-2xl p-4 shadow-xl max-w-xl mx-auto">
    <h2 class="text-xl font-bold mb-4">📅 Dynamic Calendar</h2>
    <div class="flex justify-between items-center mb-4">
      <button onclick="changeMonth(-1)" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">&lt;</button>
      <h3 id="month-year" class="text-lg font-semibold"></h3>
      <button onclick="changeMonth(1)" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">&gt;</button>
    </div>
    <div class="grid grid-cols-7 gap-1 text-center font-bold mb-2">
      <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
    </div>
    <div class="grid grid-cols-7 gap-1" id="calendar-days"></div>
  </div>

  <script>
    const tasks = <?php echo json_encode($tasksByDate); ?>;

    let currentMonth = new Date().getMonth(); 
    let currentYear = new Date().getFullYear();

    function changeMonth(delta) {
      currentMonth += delta;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      } else if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
      }
      renderCalendar();
    }

    function renderCalendar() {
      const daysContainer = document.getElementById('calendar-days');
      daysContainer.innerHTML = '';

      const date = new Date(currentYear, currentMonth, 1);
      const firstDay = date.getDay(); // 星期几
      const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
      const today = new Date();

      document.getElementById('month-year').textContent = date.toLocaleString('default', {
        month: 'long', year: 'numeric'
      });

      for (let i = 0; i < firstDay; i++) {
        daysContainer.innerHTML += '<div></div>';
      }

      for (let day = 1; day <= daysInMonth; day++) {
        const key = `${currentYear}-${currentMonth + 1}-${day}`;
        const hasTask = tasks[key] !== undefined;
        const taskTitles = hasTask ? tasks[key].join(', ') : '';
        const isToday =
          currentYear === today.getFullYear() &&
          currentMonth === today.getMonth() &&
          day === today.getDate();

        daysContainer.innerHTML += `
          <div 
            class="h-8 flex items-center justify-center rounded-full cursor-pointer 
              ${isToday ? 'bg-blue-500 text-white' : ''} 
              ${hasTask ? 'bg-yellow-300 hover:bg-yellow-400' : 'hover:bg-blue-700 hover:text-white'}"
            title="${taskTitles}">
            ${day}
          </div>
        `;
      }
    }

    renderCalendar();
  </script>
</body>
</html>
