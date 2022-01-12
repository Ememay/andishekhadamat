<?php
include '../dbconfig.php';



//define total number of results you want per page  
$results_per_page = 10;



//find the total number of results stored in the database  
$number_sql = "SELECT COUNT(id) FROM calls WHERE via = :adminid AND trash = 'no'";
$number_result = $conn->prepare($number_sql);
$number_result->bindParam(':adminid', $_SESSION['adminid'], PDO::PARAM_INT);
$number_result->execute();
$number = $number_result->fetch(PDO::FETCH_NUM);
$number_of_result = $number[0];


//determine the total number of pages available  
$number_of_page = ceil($number_of_result / $results_per_page);



//determine which page number visitor is currently on  
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

//determine the sql LIMIT starting number for the results on the displaying page  
$page_first_result = ($page - 1) * $results_per_page;



/*get list from db*/
$recent_services_sql = "SELECT * FROM calls WHERE via = :adminid AND trash = 'no'  LIMIT :page_first_result , :results_per_page ";
$recent_services_result = $conn->prepare($recent_services_sql);
$recent_services_result->bindParam(':page_first_result', $page_first_result, PDO::PARAM_INT);
$recent_services_result->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
$recent_services_result->bindParam(':adminid', $_SESSION['adminid'], PDO::PARAM_INT);
$recent_services_result->execute();
$recent_calls = $recent_services_result->fetchAll(PDO::FETCH_ASSOC);





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


            <div class="content col-12 col-md-10 whole-overview-container">
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
                                            } ?>> <span><?php echo $number++ ?></span> </td>
                                        <td class="name"> <?php echo $call['name']; ?> </td>
                                        <td class="service"> <?php echo $call['service']; ?> </td>
                                        <td class="number"><?php echo $call['number']; ?></td>
                                        <td class="address"><?php echo $call['address']; ?></td>
                                        <td class="res"> <?php foreach ($recent_services as $res) {
                                                                if ($res['id'] == $call['res']) {
                                                                    echo $res['name'];
                                                                }
                                                            } ?> </td>
                                        <td class="description"><?php echo $call['description']; ?></td>
                                        <td class="time"><?php echo jdate('Y M d', $call['date']); ?> </td>
                                        <?php if ($call['status'] == 0) { ?> <td class="status"><button class="btn btn-secondary btn-sm"> <img src="../assets/icons/hourglass.svg" alt=""> </button> </td> <?php  } elseif ($call['status'] == 1) { ?> <td class="status"><button class="btn btn-danger btn-sm"> <img src="../assets/icons/x-lg.svg" alt=""> </button> </td> <?php      } elseif ($call['status'] == 2) {  ?> <td class="status"><button class="btn btn-success btn-sm"> <img src="../assets/icons/check-square-fill.svg" alt=""></button> </td> <?php } ?>
                                        <td class="operation"> <a href="<?php echo constant("SITE_URL"); ?>/calls/bypass.php?id=<?php echo $call['id']; ?>" class="btn btn-danger btn-sm call-delete-button" data-name="<?php echo $call['name']; ?>" onclick="event.preventDefault()"> <img src="../assets/icons/trash.svg" alt="" class="pe-none"> </a> <a href="<?php echo constant("SITE_URL"); ?>/calls/edit.php?id=<?php echo $call['id']; ?>" class="btn btn-warning btn-sm"> <img src="../assets/icons/pencil-square.svg" alt=""> </a></td>
                                    </tr>

                                <?php }

                                ?>

                            </tbody>

                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination d-flex justify-content-center">
                                <?php

                                //display the link of the pages in URL  

                                for ($page = 1; $page <= $number_of_page; $page++) {

                                ?>

                                    <li class="page-item "><a class="page-link text-dark" href="all.php?page=<?php echo $page; ?>"><?php echo $page; ?></a></li>

                                <?php

                                }

                                ?>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>


            <?php include '../scripts/footer.php'; ?>
</body>

</html>