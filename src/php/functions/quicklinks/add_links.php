<?php
session_start();
require_once '../../../../config/config.php';

if($_SERVER['REQUEST_METHOD' == 'post']){
$url = filter_var($_POST['url'], FILTER_SANITIZE_URL); //this helps to prevent malicious input
$icon = htmlspecialchars($_POST['icon']);
$user_id = $_SESSION['user_id']; // assume user is logged in

if (!empty($url) && !empty($icon)) {
    // Prepare the statement without the is_custom field
    $stmt = $pdo->prepare("INSERT INTO quick_links (user_id, url, icon) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $url, $icon]);

    header("Location: ../../../views/dashboard.php"); //redirect the user to the dashboard
    exit();
}else{
    echo "Invalid input.";
}
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
    <a href="../../../views/dashboard.php">link</a>
    <a href="../../../../config/config.php">config</a>
    
</body>
</html>