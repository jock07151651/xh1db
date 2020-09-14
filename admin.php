<?php
@session_start();
$_SESSION['AdminLogin'] = 1;
header("Location:./index.php?m=Admin&c=public&a=login"); 
?>