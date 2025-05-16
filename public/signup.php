<?php
session_start();

$formError = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
require_once __DIR__ . '/../src/php/includes/db_connect.php';
require_once __DIR__ . '/../src/php/classes/signUpManager.php';

    $signup = new signUpManager($conn);

    if (!$signup->createAccount($_POST)) {
        $formError = $signup->getError();
    } else {
        header("Location: login.html"); // adjust path if needed
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up - Personal Dashboard</title>
    <link href="../public/assets/styles.css" rel="stylesheet" />
    <link href="../public/assets/login.css" rel="stylesheet" />

</head>

<body
    class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-800 via-zinc-700 to-neutral-700 text-white">

    <div class="backdrop-blur-md bg-white/10 p-8 rounded-xl shadow-xl max-w-md w-full text-center border border-white/10
            ring-1 ring-white/20 transition-transform duration-300 hover:scale-[1.01]">

        <h2 class="text-3xl font-bold mb-6">Create an Account</h2>

        <form id = "form" form action="" method="POST" class="space-y-4 text-left">
            <!-- Username -->
            <div class="form-control">
                <label for="username" class="block mb-1 text-sm font-medium text-gray-200">Username</label>
                <input type="text" id="username" name="username" required
                    class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-300 border border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <small class="error"></small>
            </div>

            <!-- Email -->
            <div class="form-control">
                <label for="email" class="block mb-1 text-sm font-medium text-gray-200">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-300 border border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <small class="error"></small>
            </div>

            <!-- Password -->
            <div class="form-control">
                <label for="password" class="block mb-1 text-sm font-medium text-gray-200">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-300 border border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <small class="error"></small>  
            </div>

            <!-- Confirm Password -->
            <div class="form-control">
                <label for="confirm_password" class="block mb-1 text-sm font-medium text-gray-200">Confirm
                    Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required
                    class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-gray-300 border border-white/20 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <small class="error"></small>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold transition duration-200">
                Sign Up
            </button>
        <?php if (!empty($formError)): ?>
            <p style="color: red !important; text-align: center; margin-top: 0.5rem;">
            <?= htmlspecialchars($formError) ?></p>
        <?php endif; ?>

        </form>

        <p class="mt-4 text-sm text-gray-300">
            Already have an account?
            <a href="login.html" class="text-blue-400 hover:underline">Login</a>
        </p>
    </div>
</body>

</html>