<?php
include '../dbconfig.php';



/*insert new calls to db*/
if (isset($_POST['submit'])) {
    /*collect informtion*/
    $name = $_POST['name'];
    $service = $_POST['service'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $description = $_POST['description'];




    /*insert information to db*/
    $sql = "INSERT INTO services(name,description) VALUE(:name,:description)";
    $query =  $conn->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);


    $query->execute();
    header('location:all.php');
    
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انجام دهنده جدید</title>
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
                    <label for="exampleInputEmail1" class="form-label">نوع خدمت</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="my-3">
                    <label for="disabledSelect" class="form-label">توضیحات</label>
                    <input type="text" class="form-control" name="description" >
                </div>

                <input type="submit" class="btn btn-primary d-inline-block my-4" name="submit" value="افزودن خدمت ">
                <a href="<?php echo constant("SITE_URL"); ?>/dashboard.php" class=" btn btn-warning d-inline mx-1" type="submit" name="submit">بازگشت به پیشخوان</a>
            </form>
        </div>
    </div>


       </div>
    </div>






    <?php include '../scripts/footer.php'; ?>   
</body>

</html>