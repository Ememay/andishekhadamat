<?php
include '../dbconfig.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    /*get list from db*/
$recent_calls_sql = "DELETE FROM services WHERE id = $id";
$recent_calls_result = $conn->prepare($recent_calls_sql);
$recent_calls_result->execute();
header("location:$SITE_url/services/all.php");


}
