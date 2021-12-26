<?php
include '../dbconfig.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    /*get list from db*/
    $pre_calls_sql = "SELECT * FROM calls WHERE id = $id";
    $pre_calls_result = $conn->prepare($pre_calls_sql);
    $pre_calls_result->execute();
    $pre_calls = $pre_calls_result->fetch(PDO::FETCH_ASSOC);
}



/*insert new calls to db*/
if (isset($_POST['submit'])) {
    /*collect informtion*/
    $id = $_GET['id'];
    $name = $_POST['name'];
    $service = $_POST['service'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $res = $_POST['res'];
    $description = $_POST['description'];
    $status = $_POST['status'];


    /*check if record have problem or not, if yes send info to db*/
    if (isset($_POST['problem'])) {
        $problem = $_POST['problem'];

        /*insert information to db*/
        $sql = "UPDATE calls set name=:name ,service=:service , number=:number ,  res =:res , description=:description , status=:status ,address= :address ,problem = :problem WHERE id = :id";
        $query =  $conn->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':service', $service, PDO::PARAM_STR);
        $query->bindParam(':number', $number, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':res', $res, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':problem', $problem, PDO::PARAM_STR);
        $query->execute();
        header('location:all.php');
        exit();
    }

    /*insert information to db*/
    $sql = "UPDATE calls set name=:name ,service=:service , number=:number ,  res =:res , description=:description , status=:status ,address= :address,problem = 'no'  WHERE id = :id";
    $query =  $conn->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':service', $service, PDO::PARAM_STR);
    $query->bindParam(':number', $number, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':res', $res, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    header("location:$SITE_url/calls/all.php");
}



/*get list from db*/
$recent_services_sql = "SELECT * FROM services";
$recent_services_result = $conn->prepare($recent_services_sql);
$recent_services_result->execute();
$recent_services = $recent_services_result->fetchAll(PDO::FETCH_ASSOC);


/*get performers list from db*/
$recent_performers_sql = "SELECT name,id FROM performers";
$recent_performers_result = $conn->prepare($recent_performers_sql);
$recent_performers_result->execute();
$recent_performers = $recent_performers_result->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش تماس</title>
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
                            <input type="text" class="form-control" name="name" required value="<?php echo $pre_calls['name']; ?>">
                        </div>
                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">نوع خدمت</label>
                            <select id="disabledSelect" class="form-select" name="service">
                                <?php foreach ($recent_services as $name) { ?>
                                    <option <?php if ($name['name'] == $pre_calls['service']) {
                                                echo 'selected';
                                            } ?> value="<?php echo $name['name']; ?>"><?php echo $name['name']; ?></option>
                                <?php     } ?>

                            </select>
                        </div>
                        <div class="my-3">
                            <label for="exampleInputPassword1" class="form-label">تلفن</label>
                            <input type="text" class="form-control" name="number" required value="<?php echo $pre_calls['number']; ?>">
                        </div>
                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">آدرس</label>
                            <input type="text" class="form-control" name="address" required value="<?php echo $pre_calls['address']; ?>">

                        </div>

                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">مسئول</label>
                            <select id="disabledSelect" class="form-select" name="res">
                                <?php foreach ($recent_performers as $performer) { ?>
                                    <option <?php if ($performer['id'] == $pre_calls['res']) {
                                                echo 'selected';
                                            } ?> value="<?php echo $performer['id']; ?>"><?php echo $performer['name']; ?></option>
                                <?php     } ?>

                            </select>
                        </div>

                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">توضیحات</label>
                            <input type="text" class="form-control" name="description" required value="<?php echo $pre_calls['description']; ?>">
                        </div>

                        <div>
                            <input class="form-check-input" type="checkbox" value="yes" id="flexCheckDefault" name="problem" <?php if ($pre_calls['problem'] == 'yes') {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                            <label class="form-check-label" for="flexCheckDefault">
                                مورد دار
                            </label>
                        </div>

                        <div class="my-3">
                            <label for="disabledSelect" class="form-label">وضعیت</label>
                            <select id="disabledSelect" class="form-select" name="status">

                                <option value="0" <?php if ($pre_calls['status'] == 0) {
                                                        echo 'selected';
                                                    } ?>>در انتظار</option>
                                <option value="2" <?php if ($pre_calls['status'] == 2) {
                                                        echo 'selected';
                                                    } ?>>انجام شده</option>
                                <option value="1" <?php if ($pre_calls['status'] == 1) {
                                                        echo 'selected';
                                                    } ?>>انجام نشده</option>
                            </select>
                        </div>

                        <input type="submit" class="btn btn-primary d-inline-block my-4" name="submit" value="ثبت تغییرات">
                        <a href="<?php echo constant("SITE_URL"); ?>/calls/all.php" class=" btn btn-warning d-inline mx-1" type="submit" name="submit">بازگشت</a>
                    </form>
                </div>
            </div>

        </div>
    </div>







    <?php include '../scripts/footer.php'; ?>

</body>

</html>