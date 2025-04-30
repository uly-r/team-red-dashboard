<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../php/functions/quicklinks/get_links.php';

$user_id = $_SESSION['user_id'] ?? null;
$links = [];

if ($user_id) {
    $links = getUserQuickLinks($user_id);
}