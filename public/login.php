<?php
session_start();
require_once '../src/php/includes/db_connect.php';
$error = ""; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: ../src/views/dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Personal Dashboard</title>
  <link href="../public/assets/styles.css" rel="stylesheet" />
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-800 via-zinc-700 to-neutral-700 text-white">

  <div class="backdrop-blur-md bg-white/10 p-8 rounded-xl shadow-xl max-w-md w-full text-center border border-white/10
            ring-1 ring-white/20 transition-transform duration-300 hover:scale-[1.01]">
    <h1 class="text-3xl font-bold mb-6">Welcome Back</h1>
    
    <form action="" method="POST" class="space-y-4 text-left">
      <!-- Username -->
      <div>
        <label for="username" class="block mb-1 text-sm font-medium text-gray-200">Username</label>
        <input type="text" id="username" name="username" required
               class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-300 border border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block mb-1 text-sm font-medium text-gray-200">Password</label>
        <input type="password" id="password" name="password" required
               class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-300 border border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
        <?php if (!empty($error)): ?>
            <p style="color: red !important; text-align: center; margin-top: 0.5rem;">
            <?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
      <!-- Submit Button -->
      <button type="submit"
              class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold transition duration-200">
        Login
      </button>
    </form>

    <p class="mt-4 text-sm text-gray-300">
      Don't have an account?
      <a href="signup.php" class="text-blue-400 hover:underline">Create one</a>
    </p>
  </div>

</body>
</html>
