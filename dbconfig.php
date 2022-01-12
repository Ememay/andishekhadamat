<?php
header('Content-Type: text/html; charset=utf-8');
/*start session*/
session_start();


$servername = "localhost";
$username = "khadamat_andishe";
$password = "Andishekhadamat.ir7";
$dbname = "khadamat_andishe";


/*
 * get the HOST NAME 
 * check if WEBSITE has HTTPS
 * define domain full url
 * check if host in localhost or real host then set setting
*/

$localHostIp = array(
    '127.0.0.1',
    '::1'
);
$domainName = $_SERVER['SERVER_NAME'];


if (!in_array($_SERVER['REMOTE_ADDR'], $localHostIp)) {
    if (isset($_SERVER['HTTPS'])) {
        define("SITE_URL", "https://$domainName");
    } else {
        define("SITE_URL", "http://$domainName");
    }
} else {
    $localHostKey = "Andishekhadamat";
    if (isset($_SERVER['HTTPS'])) {
        define("SITE_URL", "https://$domainName/$localHostKey");
    } else {
        define("SITE_URL", "http://$domainName/$localHostKey");
    }
}
$SITE_url = constant('SITE_URL');




// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e;
}

$persianSetting = $conn->prepare("SET NAMES utf8");
$persianSetting->execute();


/*check if cookie set or not*/
if (isset($_COOKIE['username'])) {
    $admin_username = $_COOKIE['username'];
    $admin_password = $_COOKIE['password'];

    /*log in*/
    $login_sql = "SELECT * FROM admin WHERE username = :username AND password = :password ;";
    $login_query = $conn->prepare($login_sql);
    $login_query->bindParam(':username', $admin_username, PDO::PARAM_STR);
    $login_query->bindParam(':password', $admin_password, PDO::PARAM_STR);
    $login_query->execute();

    /*session*/
    if ($login_query->rowCount() >= 1) {
        $admin = $login_query->fetch(PDO::FETCH_ASSOC);
        $_SESSION['login'] = true;
        $_SESSION['name'] = $admin['name'];
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['adminid'] = $admin['id'];
        $adminId = $admin['id'];

    } else {
        header("location:$SITE_url/");
    }
}


/*get session*/
if ($_SESSION['login'] == true) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    /*get admin info*/
    $adminInfoSql = "SELECT * FROM admin WHERE username= :username AND password = :password";
    $adminInfoQuery = $conn->prepare($adminInfoSql);
    $adminInfoQuery->bindParam(':username', $username, PDO::PARAM_STR);
    $adminInfoQuery->bindParam(':password', $password, PDO::PARAM_STR);
    $adminInfoQuery->execute();
    if ($adminInfoQuery->rowCount() == 1) {
        $adminInfo = $adminInfoQuery->fetch(PDO::FETCH_ASSOC);
        $adminId = $adminInfo['id'];
    }
} else {
    // $url= $_SERVER['REQUEST_URI'];    
    // echo $url;
    // exit();
    header("location:$SITE_url/");
}
