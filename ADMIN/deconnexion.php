<!-- deconnexion.php -->
<?php
session_start();
session_destroy();
header("Location: ../Signin.php");
exit();exit();
?>
