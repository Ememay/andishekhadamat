<?php

/*db*/
include 'dbconfig.php';


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
    header('location:index.php');
}




/*get list from db*/
$recent_services_sql = "SELECT * FROM performers LIMIT 10";
$recent_services_result = $conn->prepare($recent_services_sql);
$recent_services_result->execute();
$recent_services = $recent_services_result->fetchAll(PDO::FETCH_ASSOC);


/*get list from db*/
$recent_calls_sql = "SELECT * FROM `calls` WHERE via = :adminid AND trash = 'no' ORDER BY date DESC , id DESC";
$recent_calls_result = $conn->prepare($recent_calls_sql);
$recent_calls_result->bindParam('adminid', $_SESSION['adminid'], PDO::PARAM_INT);
$recent_calls_result->execute();
$recent_calls = $recent_calls_result->fetchAll(PDO::FETCH_ASSOC);

/*number of call and performerce*/
$callNumber = 1;
$performersNumber = 1;



/*number of done*/
$done = 0;

/*number of canceled*/
$canceled = 0;

/*number of waiting*/
$waiting = 0;


?>
<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد</title>
    <?php include 'scripts/header.php'; ?>
    <!-----persian calendar---->
    <?php include 'assets/jdf.php'; ?>
</head>

<body class="dashboard">

    <div class="container-fluid">
        <div class="row">
            <?php include 'menu.php'; ?>


            <div class="whole-overview-container d-flex flex-column p-2 col-10">


                <div class="content my-5">
                    <a class="btn btn-dark pe-none">آخرین تماس ها</a>
                    <a href="<?php echo constant("SITE_URL"); ?>/calls/all.php" class="btn btn-primary">مشاهده همه تماس ها</a>
                    <a href="<?php echo constant("SITE_URL"); ?>/calls/add.php" class="btn btn-warning">افزودن تماس جدید</a>

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
                                            <td <?php if ($call['problem'] == 'yes') {
                                                    echo 'class="problem"';
                                                } ?>><?php echo $callNumber++ ?> </td>
                                            <td> <?php echo $call['name']; ?> </td>
                                            <td>
                                              <?php  echo $call['service']; ?>

                                            </td>
                                            <td><?php echo $call['number']; ?></td>
                                            <td><?php echo $call['address']; ?></td>
                                            <td> <?php foreach ($recent_services as $res) {
                                                        if ($res['id'] == $call['res']) {
                                                            echo $res['name'];
                                                        }
                                                    } ?> </td>
                                            <td><?php echo $call['description']; ?></td>
                                            <td class="time"><?php echo jdate('Y M d', $call['date']); ?> </td>
                                            <?php if ($call['status'] == 0) { ?> <td class="status"><button class="btn btn-secondary btn-sm"> <img src="assets/icons/hourglass.svg" alt=""> </button> </td> <?php  } elseif ($call['status'] == 1) { ?> <td class="status"><button class="btn btn-danger btn-sm"> <img src="assets/icons/x-lg.svg" alt=""> </button> </td> <?php      } elseif ($call['status'] == 2) {  ?> <td class="status"><button class="btn btn-success btn-sm"> <img src="assets/icons/check-square-fill.svg" alt=""></button> </td> <?php } ?>
                                            <td class="operation"> <a href="<?php echo constant("SITE_URL"); ?>/calls/bypass.php?id=<?php echo $call['id']; ?>" class="btn btn-danger btn-sm call-delete-button" data-name="<?php echo $call['name']; ?>" onclick="event.preventDefault()"> <img src="assets/icons/trash.svg" alt="" class="pe-none"> </a> <a href="<?php echo constant("SITE_URL"); ?>/calls/edit.php?id=<?php echo $call['id']; ?>" class="btn btn-warning btn-sm"> <img src="assets/icons/pencil-square.svg" alt=""> </a></td>
                                        </tr>


                                    <?php
                                        if ($callNumber == 11) {
                                            break;
                                        }
                                    }

                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="content my-5">
                    <a class="btn btn-dark pe-none">آخرین انجام دهندگان</a>
                    <a href="<?php echo constant("SITE_URL"); ?>/performers/all.php" class="btn btn-primary">مشاهده همه انجام دهندگان</a>
                    <a href="<?php echo constant("SITE_URL"); ?>/performers/add.php" class="btn btn-warning">افزودن انجام دهنده جدید</a>

                    <div class="container_fluid p-2">

                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">شماره</th>
                                        <th scope="col">نام</th>
                                        <th scope="col">خدمت</th>
                                        <th scope="col">تلفن</th>
                                        <th scope="col">آدرس</th>
                                        <th scope="col">✅ / ❌ / ⌛</th>
                                        <th scope="col">توضیحات</th>
                                        <th scope="col">عملیات</th>
                                    </tr>
                                </thead>

                                <tbody>



                                    <?php

                                    foreach ($recent_services as $service) { ?>

                                        <tr>
                                            <td><?php echo $performersNumber++ ?> </td>
                                            <td> <?php echo $service['name']; ?> </td>
                                            <td><?php echo $service['service']; ?></td>
                                            <td><?php echo $service['number']; ?></td>
                                            <td><?php echo $service['address']; ?></td>
                                            <td class="performerc-statistics">

                                                <?php
                                                foreach ($recent_calls as $call) {
                                                    if ($call['res'] == $service['id'] && $call['status'] == 2) {
                                                        $done++;
                                                    }
                                                }
                                                echo $done;
                                                $done = 0;

                                                ?>

                                                /

                                                <?php
                                                foreach ($recent_calls as $call) {
                                                    if ($call['res'] == $service['id'] && $call['status'] == 1) {
                                                        $waiting++;
                                                    }
                                                }
                                                echo $waiting;
                                                $waiting = 0;

                                                ?>

                                                /

                                                <?php
                                                foreach ($recent_calls as $call) {
                                                    if ($call['res'] == $service['id'] && $call['status'] == 0) {
                                                        $canceled++;
                                                    }
                                                }
                                                echo $canceled;
                                                $canceled = 0;

                                                ?>
                                            <td><?php echo $service['description']; ?></td>
                                            <td> <a href="<?php echo constant("SITE_URL"); ?>/performers/delete.php?id=<?php echo $service['id']; ?>" class="btn btn-danger btn-sm perfomer-delete-button" data-name="<?php echo $service['name']; ?>" onclick="event.preventDefault()"> <img src="assets/icons/trash.svg" alt="" class="pe-none"> </a> <a href="<?php echo constant("SITE_URL"); ?>/performers/edit.php?id=<?php echo $service['id']; ?>" class="btn btn-warning btn-sm"><img src="assets/icons/pencil-square.svg" alt=""> </a></td>


                                        <?php }

                                        ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <?php include 'scripts/footer.php'; ?>

</body>