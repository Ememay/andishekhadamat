<?php
include '../dbconfig.php';



/*insert new calls to db*/
if (isset($_POST['submit'])) {

    /*collect informtion*/
    $name = $_POST['name'];
    $service = $_POST['service'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $res = $_POST['res'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $time = time();


    /*check if record have problem or not, if yes send info to db*/
    if (isset($_POST['problem'])) {
        $problem = $_POST['problem'];

        /*insert information to db*/
        $sql = "INSERT INTO calls(name,service,number,address,res,description,status,date,via,problem) VALUE(:name,:service,:number,:address,:res,:description,:status,:date,:via,:problem)";
        $query =  $conn->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':service', $service, PDO::PARAM_STR);
        $query->bindParam(':number', $number, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':res', $res, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':date', $time, PDO::PARAM_STR);
        $query->bindParam(':via', $adminId, PDO::PARAM_INT);
        $query->bindParam(':problem', $problem, PDO::PARAM_STR);
        $query->execute();
        header('location:all.php');
        exit();

    }


    /*insert information to db*/
    $sql = "INSERT INTO calls(name,service,number,address,res,description,status,date,via) VALUE(:name,:service,:number,:address,:res,:description,:status,:date,:via)";
    $query =  $conn->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':service', $service, PDO::PARAM_STR);
    $query->bindParam(':number', $number, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':res', $res, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':date', $time, PDO::PARAM_STR);
    $query->bindParam(':via', $adminId, PDO::PARAM_INT);
    $query->execute();
    header('location:all.php');
}




/*get performers list from db*/
$recent_performers_sql = "SELECT name,id,service FROM performers";
$recent_performers_result = $conn->prepare($recent_performers_sql);
$recent_performers_result->execute();
$recent_performers = $recent_performers_result->fetchAll(PDO::FETCH_ASSOC);

/*get performers list from db*/
$recent_services_sql = "SELECT name,id FROM services";
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
    <title>تماس جدید</title>
    <?php include '../scripts/header.php'; ?>
    <style>
        td {
            font-size: 15px;
            max-width: 320px !important;
            max-width: 200px;
            overflow-y: hidden;

        }

        .table>tbody {
            vertical-align: middle !important;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php include '../menu.php'; ?>


            <!---main--->
            <div class="col-10 my-3">
                <div class="container">
                    <form method="POST">
                        <div class="my-3">
                            <label for="exampleInputEmail1" class="form-label">نام مشتری</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">نوع خدمت</label>
                            <select id="disabledSelect" class="form-select" name="service">
                                <?php foreach ($recent_services as $service) { ?>
                                    <option value="<?php echo $service['name']; ?>"><?php echo $service['name']; ?></option>
                                <?php     } ?>
                            </select>
                        </div>
                        <div class="my-3">
                            <label for="exampleInputPassword1" class="form-label">تلفن</label>
                            <input type="text" class="form-control" name="number" required>
                        </div>
                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">آدرس</label>
                            <input type="text" class="form-control" name="address" required>

                        </div>

                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">مسئول</label>
                            <select id="disabledSelect" class="form-select" name="res">
                                <?php foreach ($recent_performers as $performer) { ?>
                                    <option value="<?php echo $performer['id']; ?>"><?php echo $performer['name']; ?></option>
                                <?php     } ?>

                            </select>
                        </div>

                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">توضیحات</label>
                            <input type="text" class="form-control" name="description">
                        </div>

                        <div>
                            <input class="form-check-input" type="checkbox" value="yes" id="flexCheckDefault" name="problem" >
                            <label class="form-check-label" for="flexCheckDefault">
                                مورد دار
                            </label>
                        </div>


                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">وضعیت</label>
                            <select id="disabledSelect" class="form-select" name="status">
                                <option value="0">در انتظار</option>
                                <option value="2">انجام شده</option>
                                <option value="1">انجام نشده</option>
                            </select>
                        </div>

                        <input type="submit" class="btn btn-primary d-inline-block my-4" name="submit" value="افزودن تماس">
                        <a href="<?php echo constant("SITE_URL"); ?>/dashboard.php" class=" btn btn-warning d-inline mx-1" type="submit" name="submit">بازگشت به پیشخوان</a>
                    </form>
                </div>
            </div>



        </div>
    </div>





    <?php include '../scripts/footer.php'; ?>
</body>

</html>