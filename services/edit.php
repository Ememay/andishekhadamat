<?php
include '../dbconfig.php';



if (isset($_GET['id'])) {
    $id = $_GET['id'];
    /*get list from db*/
    $pre_services_sql = "SELECT * FROM services WHERE id = $id";
    $pre_services_result = $conn->prepare($pre_services_sql);
    $pre_services_result->execute();
    $pre_services = $pre_services_result->fetch(PDO::FETCH_ASSOC);
}



/*insert new services to db*/
if (isset($_POST['submit'])) {
    /*collect informtion*/
    $id = $_GET['id'];
    $name = $_POST['name'];

    $description = $_POST['description'];



    /*insert information to db*/
    $sql = "UPDATE services set name=:name,description=:description WHERE id = :id";
    $query =  $conn->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->execute();
    header("location:$SITE_url/services/all.php");
}

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
                    <label for="exampleInputEmail1" class="form-label">نوع خدمت</label>
                    <input type="text" class="form-control" name="name" required value="<?php echo $pre_services['name'] ?>">
                </div>
                <div class="my-3">
                    <label for="disabledSelect" class="form-label">توضیحات</label>
                    <input type="text" class="form-control" name="description"   value="<?php echo $pre_services['description'] ?>">
                </div>

                <input type="submit" class="btn btn-primary d-inline-block my-4" name="submit" value="ویراش کردن">
                <a href="<?php echo constant("SITE_URL"); ?>/services/all.php" class=" btn btn-warning d-inline mx-1" type="submit" name="submit">بازگشت</a>
            </form>
        </div>
    </div>
        </div>
    </div>

    <?php include '../scripts/footer.php'; ?>   
</body>

</html>