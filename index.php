<?php








$localHostIp = array(
    '127.0.0.1',
    '::1'
);
$domainName = $_SERVER['SERVER_NAME'];


if (!in_array($_SERVER['REMOTE_ADDR'], $localHostIp)) {
    if (isset($_SERVER['HTTPS'])) {
        define("SITE_URL", "https://$domainName");
    } else {
        define("SITE_URL", "http://$domainName");
    }
} else {
    $localHostKey = "Andishekhadamat";
    if (isset($_SERVER['HTTPS'])) {
        define("SITE_URL", "https://$domainName/$localHostKey");
    } else {
        define("SITE_URL", "http://$domainName/$localHostKey");
    }
}






/*start session*/
session_start();


$servername = "localhost";
$username = "khadamat_andishe";
$password = "Andishekhadamat.ir7";
$dbname = 'khadamat_andishe';

// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e;
}

$persianSetting = $conn->prepare("SET NAMES utf8");
$persianSetting->execute();




/*check if cookie set or not*/
if (isset($_COOKIE['username'])) {
    $admin_username = $_COOKIE['username'];
    $admin_password = $_COOKIE['password'];

    /*log in*/
    $login_sql = "SELECT * FROM admin WHERE username = :username AND password = :password ;";
    $login_query = $conn->prepare($login_sql);
    $login_query->bindParam(':username', $admin_username, PDO::PARAM_STR);
    $login_query->bindParam(':password', $admin_password, PDO::PARAM_STR);
    $login_query->execute();

    /*session*/
    if ($login_query->rowCount() >= 1) {
        $admin = $login_query->fetch(PDO::FETCH_ASSOC);
        $_SESSION['login'] = true;
        $_SESSION['name'] = $admin['name'];
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['adminid'] = $admin['id'];
        header('location:dashboard.php');
    } else {
        echo "
       <script>
                alert('نام کاربری یا رمز عبور اشتباست! دوباره امتحان کن خوشگله...')
        </script>
        ";
    }
}



/*log in*/
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login_sql = "SELECT * FROM admin WHERE username = :username AND password = :password ;";
    $login_query = $conn->prepare($login_sql);
    $login_query->bindParam(':username', $username, PDO::PARAM_STR);
    $login_query->bindParam(':password', $password, PDO::PARAM_STR);
    $login_query->execute();

    /*session*/
    if ($login_query->rowCount() >= 1) {
        $admin = $login_query->fetch(PDO::FETCH_ASSOC);
        $_SESSION['login'] = true;
        $_SESSION['name'] = $admin['name'];
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['adminid'] = $admin['id'];
        /*check if remember checked or not*/
        if (isset($_POST['remember'])) {
            setcookie("username", $username, time() + 10000);
            setcookie("password", $password, time() + 10000);
        }
        header('location:dashboard.php');
    } else {
        echo "
       <script>
                alert('نام کاربری یا رمز عبور اشتباست! دوباره امتحان کن خوشگله...')
        </script>
        ";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وارد شو یا در تلاشش بمیر!</title>
    <!----these script are just for this page--->
    <link rel="icon" type="image/x-icon" href="<?php echo constant("SITE_URL"); ?>/uploads/svg.svg">
    <link rel="stylesheet" href="<?php echo constant("SITE_URL"); ?>/assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo constant("SITE_URL"); ?>/assets/bootstrap/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo constant("SITE_URL"); ?>/assets/bootstrap/bootstrap-icons.css">

</head>


<body class="d-flex align-items-center min-vh-100">


    <!--login page--->
    <main class="form-signin container m-auto d-flex align-items-center justify-content-center ">
        <form method="POST" class="w-50">
            <h1 class="h3 mb-4 fw-normal">بگو برا کی کار میکنی ؟</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="username">
                <label for="floatingInput">یوزر نیم شما</label>
            </div>
            <div class="form-floating my-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">پسورد شما</label>
            </div>
            <div class="form-check my-3">
                <input class="form-check-input" type="checkbox" name="remember">
                <label class="form-check-label" for="flexCheckDefault">
                    مرا به خاطر بسپار
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">ورود به پنل ادمین</button>

        </form>
    </main>


</body>

</html>