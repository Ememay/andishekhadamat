<?php
include '../dbconfig.php';


/*get list from db*/
$recent_calls_sql = "SELECT * FROM calls WHERE via = :adminid AND trash = 'no'";
$recent_calls_result = $conn->prepare($recent_calls_sql);
$recent_calls_result->bindParam('adminid',$_SESSION['adminid'],PDO::PARAM_INT);
$recent_calls_result->execute();
$recent_calls = $recent_calls_result->fetchAll(PDO::FETCH_ASSOC);


/*number of calls*/
$number = 1;


/*get list from db*/
$recent_services_sql = "SELECT name,id,service FROM performers";
$recent_services_result = $conn->prepare($recent_services_sql);
$recent_services_result->execute();
$recent_services = $recent_services_result->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>همه تماس ها</title>
    <?php include '../scripts/header.php'; ?>
    <!-----persian calendar---->
    <?php include '../assets/jdf.php'; ?>
</head>

<body class="calls">
<div class="container-fluid ">
    <div class="row">
    <?php include '../menu.php'; ?>


    <div class="content col-10 whole-overview-container">
        <div class="container_fluid p-1">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th scope="col">شماره</th>
                            <th scope="col">نام</th>
                            <th scope="col">خدمت</th>
                            <th scope="col">تلفن</th>
                            <th scope="col">آدرس</th>
                            <th scope="col">مسئول</th>
                            <th scope="col">توضیحات</th>
                            <th scope="col">تاریخ</th>

                            <th scope="col">وضعیت</th>
                            <th scope="col">عملیات</th>
                        </tr>
                    </thead>

                    <tbody>



                        <?php

                        foreach ($recent_calls as $call) { ?>

                            <tr>
                                <td <?php if($call['problem'] == 'yes'){echo 'class="problem"';} ?>> <span><?php echo $number++ ?></span> </td>
                                <td> <?php echo $call['name']; ?> </td>
                                <td> <?php echo $call['service']; ?> </td>
                                <td><?php echo $call['number']; ?></td>
                                <td><?php echo $call['address']; ?></td>
                                <td> <?php foreach ($recent_services as $res) {
                                            if ($res['id'] == $call['res']) {
                                                echo $res['name'];
                                            }
                                        } ?> </td>
                                <td><?php echo $call['description']; ?></td>
                                <td class="time"><?php echo jdate('Y M d', $call['date']); ?> </td>
                               <?php if ($call['status'] == 0) { ?> <td class="status"><button class="btn btn-secondary btn-sm">  <img src="../assets/icons/hourglass.svg" alt=""> </button> </td> <?php  } elseif ($call['status'] == 1) { ?> <td class="status"><button class="btn btn-danger btn-sm">  <img src="../assets/icons/x-lg.svg" alt=""> </button> </td> <?php      } elseif ($call['status'] == 2) {  ?> <td class="status"><button class="btn btn-success btn-sm"> <img src="../assets/icons/check-square-fill.svg" alt=""></button> </td> <?php } ?>
                                            <td class="operation"> <a href="<?php echo constant("SITE_URL"); ?>/calls/bypass.php?id=<?php echo $call['id']; ?>" class="btn btn-danger btn-sm call-delete-button" data-name="<?php echo $call['name']; ?>" onclick="event.preventDefault()">  <img src="../assets/icons/trash.svg" alt=""  class="pe-none"> </a> <a href="<?php echo constant("SITE_URL"); ?>/calls/edit.php?id=<?php echo $call['id']; ?>" class="btn btn-warning btn-sm">  <img src="../assets/icons/pencil-square.svg" alt=""> </a></td>
</tr>

                        <?php }

                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <?php include '../scripts/footer.php'; ?>   
</body>

</html>