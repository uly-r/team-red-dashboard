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
            <div class="flex space-x-2">
                <button onclick="document.getElementById('noteModal').classList.remove('hidden')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                    + New Note
                </button>
                <button onclick="toggleFullView()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                    Toggle View Mode
                </button>
            </div>
        </div>

        <!-- Flash Message -->
        <?php if (isset($_SESSION['note_message'])): ?>
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <?= $_SESSION['note_message'];
                unset($_SESSION['note_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Notes Display -->
        <div id="notesContainer" class="transition-all duration-300">
            <?php if (empty($notes)): ?>
                <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                    <i class="fas fa-clipboard text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-600">No notes yet. Click "New Note" to add one!</p>
                </div>
            <?php else: ?>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 card-view">
                    <?php foreach ($notes as $note): ?>
                        <?php
                        $content = htmlspecialchars($note['content']);
                        $max_length = 150;
                        $is_truncated = strlen($content) > $max_length;
                        $truncated_content = $is_truncated ? substr($content, 0, $max_length) . '...' : $content;
                        ?>
                        <div
                            class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-lg transition-transform transform hover:scale-[1.02] note-card">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-bold text-gray-800 truncate w-5/6">
                                    <?= htmlspecialchars($note['title']) ?>
                                </h3>
                                <a href="dashboard.php?delete=<?= $note['id'] ?>#notes" class="text-red-500 hover:text-red-700"
                                    title="Delete" onclick="return confirm('Delete this note permanently?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                            <div class="overflow-x-auto">
                                <p class="text-sm text-gray-700 whitespace-pre-wrap break-words leading-relaxed">
                                    <?= $truncated_content ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- FULL VIEW MODAL: Always included -->
        <div id="fullViewModal" class="fixed inset-0 bg-white overflow-auto z-50 hidden">
            <!-- Close Button -->
            <button onclick="toggleFullView()"
                class="fixed top-4 right-6 z-50 bg-gray-100 px-4 py-2 rounded shadow text-gray-700 hover:text-black font-semibold text-lg">
                × Close
            </button>

            <div class="max-w-5xl mx-auto p-6 mt-14">
                <?php if (empty($notes)): ?>
                    <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                        <i class="fas fa-clipboard text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-600">No notes yet. Click "New Note" to add one!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($notes as $note): ?>
                        <div class="bg-white rounded-lg shadow p-6 mb-4">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($note['title']) ?></h3>
                            <p class="text-gray-600">
                                <?= htmlspecialchars($note['content']) ?>
                            </p>
                            <div class="flex space-x-3 mt-4">
                                <a href="dashboard.php?delete=<?= $note['id'] ?>#notes" class="text-red-500 hover:text-red-700"
                                    title="Delete" onclick="return confirm('Delete this note permanently?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>


    </div>

    <!-- MODAL -->
    <div id="noteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg relative">
            <button onclick="document.getElementById('noteModal').classList.add('hidden')"
                class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 text-xl">×</button>
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

    <script>
        function toggleFullView() {
            const modal = document.getElementById("fullViewModal");
            modal.classList.toggle("hidden");
        }
    </script>

</html>