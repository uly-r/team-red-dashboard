<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session (for message flashing)
session_start();

// Dummy data to simulate database records
$notes = [
    [
        'id' => 1,
        'title' => 'Welcome to your Notes',
        'content' => 'This is your first note. Edit or delete it to get started!',
        'user_id' => 1
    ],
    [
        'id' => 2,
        'title' => 'Sample Meeting Notes',
        'content' => 'Discuss project timeline with team\nPrepare presentation',
        'user_id' => 1
    ]
];

// Simulate editing if edit parameter is present
$editing_note = null;
if (isset($_GET['edit'])) {
    foreach ($notes as $note) {
        if ($note['id'] == $_GET['edit']) {
            $editing_note = $note;
            break;
        }
    }
}

// Simulate form submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_note'])) {
        // Simulate adding a new note
        $newId = count($notes) + 1;
        $notes[] = [
            'id' => $newId,
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'user_id' => 1
        ];
        $_SESSION['note_message'] = "Note added successfully! (Simulated)";
    }
    elseif (isset($_POST['update_note'])) {
        // Simulate updating a note
        foreach ($notes as &$note) {
            if ($note['id'] == $_POST['note_id']) {
                $note['title'] = $_POST['title'];
                $note['content'] = $_POST['content'];
                break;
            }
        }
        $_SESSION['note_message'] = "Note updated successfully! (Simulated)";
    }
    
    // Prevent form resubmission
    header("Location: notes.php");
    exit;
}

// Simulate note deletion
if (isset($_GET['delete'])) {
    foreach ($notes as $key => $note) {
        if ($note['id'] == $_GET['delete']) {
            unset($notes[$key]);
            break;
        }
    }
    $_SESSION['note_message'] = "Note deleted successfully! (Simulated)";
    header("Location: notes.php");
    exit;
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
<body class="bg-gray-50 min-h-screen">
    <!-- Simple header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4">
            <h1 class="text-xl font-bold text-gray-800">Personal Dashboard (Demo Mode)</h1>
        </div>
    </header>
    
    <main class="container mx-auto px-4 py-8">
        <!-- Flash Messages -->
        <?php if (isset($_SESSION['note_message'])): ?>
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <?= $_SESSION['note_message']; unset($_SESSION['note_message']); ?>
            </div>
        <?php endif; ?>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Note Form -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <?= $editing_note ? 'Edit Note' : 'New Note' ?>
                    </h2>
                    <form action="notes.php" method="POST">
                        <?php if ($editing_note): ?>
                            <input type="hidden" name="note_id" value="<?= $editing_note['id'] ?>">
                        <?php endif; ?>
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" id="title" name="title" 
                                   value="<?= htmlspecialchars($editing_note['title'] ?? '') ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                            <textarea id="content" name="content" rows="8"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                      required><?= htmlspecialchars($editing_note['content'] ?? '') ?></textarea>
                        </div>
                        
                        <button type="submit" name="<?= $editing_note ? 'update_note' : 'add_note' ?>"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                            <?= $editing_note ? 'Update' : 'Save' ?>
                        </button>
                        
                        <?php if ($editing_note): ?>
                            <a href="notes.php" class="block mt-2 text-center text-sm text-gray-600 hover:text-gray-800">
                                Cancel
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            
            <!-- Notes List -->
            <div class="lg:w-2/3">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Your Notes (Demo)</h1>
                    <span class="text-sm text-gray-600"><?= count($notes) ?> note(s)</span>
                </div>
                
                <?php if (empty($notes)): ?>
                    <div class="bg-white rounded-lg shadow p-8 text-center">
                        <i class="fas fa-clipboard text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-600">No notes yet. Create your first one!</p>
                    </div>
                <?php else: ?>
                    <div class="grid gap-4">
                        <?php foreach ($notes as $note): ?>
                            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition">
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            <?= htmlspecialchars($note['title']) ?>
                                        </h3>
                                        <div class="flex space-x-3">
                                            <a href="notes.php?edit=<?= $note['id'] ?>" 
                                               class="text-blue-500 hover:text-blue-700"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="notes.php?delete=<?= $note['id'] ?>" 
                                               class="text-red-500 hover:text-red-700"
                                               title="Delete"
                                               onclick="return confirm('Delete this note permanently?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 whitespace-pre-wrap"><?= htmlspecialchars($note['content']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>

<!-- When you're ready to connect to an actual database, here's what you'll need to modify, and yes - with this self-contained version you don't need notes_actions.php anymore.

1. Database Transition Guide
What to Remove
Delete the dummy data array:

php
$notes = [
    [
        'id' => 1,
        'title' => 'Welcome to your Notes',
        // ...
    ],
    // ...
];
Remove the simulated form handling:

php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete this entire block
}

if (isset($_GET['delete'])) {
    // Delete this entire block
}
What to Add
Database connection (at the top):

php
require_once '../db.php'; // Your database connection file
Real database queries:

php
// Fetch notes from database
$stmt = $pdo->prepare("SELECT * FROM notes WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$_SESSION['user_id']]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission (add/edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_note'])) {
        $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $_POST['title'], $_POST['content']]);
    } 
    elseif (isset($_POST['update_note'])) {
        $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$_POST['title'], $_POST['content'], $_POST['note_id'], $_SESSION['user_id']]);
    }
    header("Location: notes.php");
    exit;
}

// Handle deletion
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['delete'], $_SESSION['user_id']]);
    header("Location: notes.php");
    exit;
} -->