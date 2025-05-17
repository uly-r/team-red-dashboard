<?php
session_start();
session_unset();
session_destroy();
header("Location: ../../../public/landpage.html"); //must be modified if files are moved
exit();
?>