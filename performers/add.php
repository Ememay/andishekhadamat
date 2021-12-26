<?php
include '../dbconfig.php';



/*insert new calls to db*/
if (isset($_POST['submit'])) {
    /*collect informtion*/
    $name = $_POST['name'];
    $serviceList = $_POST['services'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $description = $_POST['description'];

    $services = '';
    foreach($serviceList as $service){
        $services .= $service.'، ';
    }


    /*insert information to db*/
    $sql = "INSERT INTO performers(name,service,number,address,description) VALUE(:name,:service,:number,:address,:description)";
    $query =  $conn->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':service', $services, PDO::PARAM_STR);
    $query->bindParam(':number', $number, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);


    $query->execute();
    header('location:all.php');
}


/*get service list from db*/
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
    <title>انجام دهنده جدید</title>
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
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <h5 class="mt-5">خدمت مورد نظر را انتخاب کنید</h5>

                        <div class="my-3 mb-5 d-flex flex-wrap justify-content-start service-checkbox-container">
                            <?php foreach ($recent_services as $name) { ?>

                             
                                <div class="form-check mx-2 w-25 add-performers-checkbox">
                                    <input class="form-check-input" type="checkbox" value="<?php echo $name['name']; ?>" name="services[]">
                                    <label class="form-check-label" for="flexCheckDefault">
                                    <?php echo $name['name']; ?>
                                    </label>
                                </div>
                            <?php     } ?>

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
                            <label for="disabledSelect" class="form-label">توضیحات</label>
                            <input type="text" class="form-control" name="description">
                        </div>

                        <input type="submit" class="btn btn-primary d-inline my-4" name="submit" value="افزودن انجام دهنده">
                        <a href="<?php echo constant("SITE_URL"); ?>/dashboard.php" class="btn btn-warning d-inline mx-0 " type="submit" name="submit">بازگشت</a>
                    </form>
                </div>
            </div>


        </div>
    </div>






    <?php include '../scripts/footer.php'; ?>
</body>

</html>