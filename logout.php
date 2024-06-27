<?php
session_start();
echo "logging you out. Please wait a sec!";
session_destroy();
header("Location:/forum/index.php?logout=true")


?>
