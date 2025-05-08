<?php
require_once __DIR__ . '/../../php/includes/db_connect.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_note'])) {
        $stmt = $conn->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $_SESSION['user_id'], $_POST['title'], $_POST['content']);
        $stmt->execute();
        $_SESSION['note_message'] = "Note added successfully!";
    } elseif (isset($_POST['update_note'])) {
        $stmt = $conn->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $_POST['title'], $_POST['content'], $_POST['note_id'], $_SESSION['user_id']);
        $stmt->execute();
        $_SESSION['note_message'] = "Note updated successfully!";
    }

    // Redirect to avoid resubmission
  
}

// Handle deletion
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $_GET['delete'], $_SESSION['user_id']);
    $stmt->execute();
    $_SESSION['note_message'] = "Note deleted successfully!";
}

// Fetch notes
$stmt = $conn->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$notes = $result->fetch_all(MYSQLI_ASSOC);

// Edit mode
$editing_note = null;
if (isset($_GET['edit'])) {
    foreach ($notes as $note) {
        if ($note['id'] == $_GET['edit']) {
            $editing_note = $note;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes | Personal Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<div class="bg-white rounded-xl p-4 shadow w-full max-w-5xl mx-auto mt-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Your Notes</h1>
        <button onclick="document.getElementById('noteModal').classList.remove('hidden')" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
            + New Note
        </button>
    </div>

    <!-- Flash Message -->
    <?php if (isset($_SESSION['note_message'])): ?>
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <?= $_SESSION['note_message']; unset($_SESSION['note_message']); ?>
        </div>
    <?php endif; ?>

    <!-- Notes Display -->
    <?php if (empty($notes)): ?>
        <div class="bg-white rounded-lg shadow-xl p-8 text-center">
            <i class="fas fa-clipboard text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-600">No notes yet. Click "New Note" to add one!</p>
        </div>
    <?php else: ?>
        <div class="grid gap-4">
            <?php foreach ($notes as $note): ?>
                <div class="bg-white rounded-lg shadow p-4 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($note['title']) ?></h3>
                        <div class="flex space-x-3">
                            <a href="dashboard.php?delete=<?= $note['id'] ?>#notes"
                               class="text-red-500 hover:text-red-700"
                               title="Delete"
                               onclick="return confirm('Delete this note permanently?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    <p class="text-gray-600 whitespace-pre-wrap"><?= htmlspecialchars($note['content']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- MODAL -->
<div id="noteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg relative">
        <button onclick="document.getElementById('noteModal').classList.add('hidden')"
                class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-xl font-bold text-gray-800 mb-4">New Note</h2>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" id="title" name="title"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea id="content" name="content" rows="6"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                          required></textarea>
            </div>

            <button type="submit" name="add_note"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                Save Note
            </button>
        </form>
    </div>
</div>

</body>

</html>