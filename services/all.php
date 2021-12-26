<?php
include '../dbconfig.php';







/*get list from db*/
$recent_services_sql = "SELECT * FROM services";
$recent_services_result = $conn->prepare($recent_services_sql);
$recent_services_result->execute();
$recent_services = $recent_services_result->fetchAll(PDO::FETCH_ASSOC);


/*get list from db*/
$recent_calls_sql = "SELECT * FROM calls WHERE trash = 'no' ";
$recent_calls_result = $conn->prepare($recent_calls_sql);
$recent_calls_result->execute();
$recent_calls = $recent_calls_result->fetchAll(PDO::FETCH_ASSOC);




/*number of services*/
$number = 1;



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
    <title>همه انجام دهندگان</title>
    <?php include '../scripts/header.php'; ?>
</head>

<body class="services">

<div class="container-fluid">
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
                            <th scope="col">✅ / ❌ / ⌛</th>
                            <th scope="col">توضیحات</th>
                            <th scope="col">عملیات</th>
                        </tr>
                    </thead>

                    <tbody>



                        <?php

                        foreach ($recent_services as $service) { ?>

                            <tr>
                                <td><?php echo $number++ ?> </td>
                                <td> <?php echo $service['name']; ?> </td>
                              <td class="performerc-statistics">

                                            <?php
                                            foreach ($recent_calls as $call) {
                                                if ($call['service'] == $service['name'] && $call['status'] == 2) {
                                                    $done++;
                                                }
                                            }
                                            echo $done;
                                            $done = 0;

                                            ?>

                                            /

                                            <?php
                                            foreach ($recent_calls as $call) {
                                                if ($call['service'] == $service['name'] && $call['status'] == 1) {
                                                    $waiting++;
                                                }
                                            }
                                            echo $waiting;
                                            $waiting = 0;

                                            ?>

                                            /

                                            <?php
                                            foreach ($recent_calls as $call) {
                                                if ($call['service'] == $service['name'] && $call['status'] == 0) {
                                                    $canceled++;
                                                }
                                            }
                                            echo $canceled;
                                            $canceled = 0;

                                            ?>

                                        </td>
                                                            <td><?php echo $service['description']; ?></td>
                                <td> <a href="<?php echo constant("SITE_URL"); ?>/services/delete.php?id=<?php echo $service['id']; ?>" class="btn btn-danger btn-sm performer-delete-button" data-name="<?php echo $service['name']; ?>" onclick="event.preventDefault()"> <img src="../assets/icons/trash.svg" alt="" class="pe-none">  </a> <a href="<?php echo constant("SITE_URL"); ?>/services/edit.php?id=<?php echo $service['id']; ?>" class="btn btn-warning btn-sm"><img src="../assets/icons/pencil-square.svg" alt=""> </a></td>
                            </tr>


                        <?php }

                        ?>






                    </tbody>
                </table>
            </div>
        </div>
    </div>
        </div>
    </div>

    <?php include '../scripts/footer.php'; ?>

</body>

