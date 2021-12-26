<?php


/*db*/
include 'dbconfig.php';

/*get admin info*/
if (isset($_GET['id'])) {



    /*get admin info*/
    $adminInfoSql = "SELECT * FROM admin WHERE id = :id";
    $adminInfoQuery = $conn->prepare($adminInfoSql);
    $adminInfoQuery->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $adminInfoQuery->execute();
    $admininfo = $adminInfoQuery->fetch(PDO::FETCH_ASSOC);
}



/*update admin setting*/
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id = $_GET['id'];


    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    // Check if file already exists
    if (file_exists($target_file)) {
        echo "
        <script>
        alert('همچین عکسی با همین نام قبلا ذخیره شده است، لطفا نام عکس رو عوض کنید')
</script>
        ";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "       <script>
        alert('حجم عکست خیلی بالاست، کمتر از 1 مگابایتش کن')
</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    ) {
        echo "       <script>
        alert('میدونستی فقط باید عکس هایی با فرمت jpg,png و jpeg آپلود کنی ؟')
</script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
     
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        
        } else {
          
        }
    }

    /*update session*/
    $_SESSION['name'] = $name;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;


    /*insert new information to db*/
    $image = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
    $login_sql = "UPDATE admin set name = :name , username = :username , password = :password , image = :image WHERE id = :id;";
    $login_query = $conn->prepare($login_sql);
    $login_query->bindParam(':name', $name, PDO::PARAM_STR);
    $login_query->bindParam(':username', $username, PDO::PARAM_STR);
    $login_query->bindParam(':password', $password, PDO::PARAM_STR);
    $login_query->bindParam(':image', $image, PDO::PARAM_STR);
    $login_query->bindParam(':id', $id, PDO::PARAM_STR);
    $login_query->execute();

    // /*redirect to dashboard*/
    header('location:dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تنظیمات کاربری</title>
    <?php include 'scripts/header.php'; ?>
</head>


<body class="setting">

<div class="container-fluid ">
    <div class="row">
    <?php include 'menu.php'; ?>

    <!--login page--->
    <main class="form-signin col-10 my-5 d-flex justify-content-center">
        <form method="POST" class="w-50" enctype="multipart/form-data">
            <h1 class="h3 mb-4 fw-normal">هیچ وقت شخصیتی که قبلا بودی رو فراموش نکن!</h1>
            <div class="form-floating my-3">
                <input required type="text" class="form-control input-h-80" placeholder="name@example.com" name="name" value="<?php echo $admininfo['name']; ?>">
                <label for="floatingInput">نام شما</label>
            </div>
            <div class="form-floating my-3">
                <input required type="text" class="form-control input-h-80" placeholder="name@example.com" name="username" value="<?php echo $admininfo['username']; ?>">
                <label for="floatingInput ">یوزر نیم شما</label>
            </div>
            <div class="form-floating my-3">
                <input required type="password" class="form-control input-h-80" placeholder="Password" name="password" value="<?php echo $admininfo['password']; ?>" id="pasword-input">  
                <label for="floatingPassword">پسورد شما</label>
                <input type="checkbox" class="show-pass-toggle"  onclick="togglepass()">
            </div>
            <div class="form-floating my-3">
                <input type="file" class="form-control input-h-80" id="fileToUpload" placeholder="Password" name="fileToUpload" value="<?php echo $admininfo['image']; ?>" >
                <label for="floatingPassword"> تصویر پروفایل شما</label>
            </div>
            <button class="w-50 btn btn-lg btn-primary d-inline" type="submit" name="submit">ذخیره تنظیمات</button><a href="dashboard.php" class="w-25 btn btn-lg btn-warning d-inline mx-1" type="submit" name="submit">بازگشت</a>
        </form>
    </main>
 </div>
 </div>
 <?php include 'scripts/footer.php'; ?>   
</body>

</html>