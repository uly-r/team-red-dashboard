<?php
session_start();
session_unset();
session_destroy();
header("Location: /team-red/public/login.html");
exit();
?>