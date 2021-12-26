<?php
include '../dbconfig.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    /*get list from db*/
    $pre_services_sql = "SELECT * FROM performers WHERE id = $id";
    $pre_services_result = $conn->prepare($pre_services_sql);
    $pre_services_result->execute();
    $pre_services = $pre_services_result->fetch(PDO::FETCH_ASSOC);
}



/*insert new services to db*/
if (isset($_POST['submit'])) {
    /*collect informtion*/
    $id = $_GET['id'];
    $name = $_POST['name'];
    $serviceList = $_POST['services'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $description = $_POST['description'];


    $services = '';
    foreach ($serviceList as $service) {
        $services .= $service . '، ';
    }


    /*insert information to db*/
    $sql = "UPDATE performers set name=:name ,service=:service , number=:number , description=:description , address= :address WHERE id = :id";
    $query =  $conn->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':service', $services, PDO::PARAM_STR);
    $query->bindParam(':number', $number, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->execute();
    header("location:$SITE_url/performers/all.php");
}


/*get list from db*/
$recent_services_sql = "SELECT * FROM services";
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
    <title>ویرایش انجام دهنده</title>
    <?php include '../scripts/header.php'; ?>
</head>

<body>


    <div class="container-fluid">
        <div class="row">

            <?php include '../menu.php'; ?>


            <!---main--->
            <div class="col-12 col-md-10 my-3">
                <div class="container">
                    <form method="POST">
                        <div class="my-3">
                            <label for="exampleInputEmail1" class="form-label">نام مشتری</label>
                            <input type="text" class="form-control" name="name" required value="<?php echo $pre_services['name'] ?>">
                        </div>



                        <h5 class="mt-5">خدمت مورد نظر را انتخاب کنید</h5>
                        <div class="my-3 mb-5 d-flex flex-wrap justify-content-start service-checkbox-container">
                            <?php foreach ($recent_services as $name) { ?>


                                <div class="form-check mx-2 w-25 add-performers-checkbox">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $name['name']; ?>" name="services[]" <?php if (strpos($pre_services['service'], $name['name']) !== false) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        <?php echo $name['name']; ?>
                                    </label>
                                </div>
                            <?php     } ?>

                        </div>



                        <div class="my-3">
                            <label for="exampleInputPassword1" class="form-label">تلفن</label>
                            <input type="text" class="form-control" name="number" required value="<?php echo $pre_services['number'] ?>">
                        </div>
                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">آدرس</label>
                            <input type="text" class="form-control" name="address" required value="<?php echo $pre_services['address'] ?>">

                        </div>
                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">توضیحات</label>
                            <input type="text" class="form-control" name="description" value="<?php echo $pre_services['description'] ?>">
                        </div>

                        <input type="submit" class="btn btn-primary d-inline-block my-4" name="submit" value="ویراش کردن">
                        <a href="<?php echo constant("SITE_URL"); ?>/performers/all.php" class=" btn btn-warning d-inline mx-1" type="submit" name="submit">بازگشت</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../scripts/footer.php'; ?>
</body>

</html>