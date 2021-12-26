<?php 

/*db*/
include 'dbconfig.php'; 

/*log out*/
session_destroy();

/*remove cookie*/
unset($_COOKIE['username']); 
setcookie("username", "", time() - 3600);
unset($_COOKIE['password']); 
setcookie("password", "", time() - 3600);

header("location:$SITE_url/index.php");