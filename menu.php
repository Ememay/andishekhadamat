<?php

/*get menus  from db*/
$menus_sql = "SELECT * FROM menus WHERE type = 'menu'";
$menus_result = $conn->prepare($menus_sql);
$menus_result->execute();
$menus = $menus_result->fetchAll(PDO::FETCH_ASSOC);

/*get submenus from db*/
$sub_menus_sql = "SELECT * FROM menus WHERE type = 'submenu'";
$sub_menus_result = $conn->prepare($sub_menus_sql);
$sub_menus_result->execute();
$sub_menus = $sub_menus_result->fetchAll(PDO::FETCH_ASSOC);

?>


<!-- mobile version -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-md-none">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">سلام <?php echo $_SESSION['name']; ?></a>
        <button class="navbar-toggler p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNavDropdown">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a href="<?php echo constant("SITE_URL"); ?>/dashboard.php" class="nav-link align-middle px-0">
                    <img src="<?php echo constant("SITE_URL"); ?>/assets/icons/building.svg" alt=""> <span class="ms-1">داشبورد</span>
                </a>
            </li>
                <?php foreach ($menus as $menu) {
                    if ($menu['type'] == 'menu') {
                ?>
                        <li class="nav-item">
                            <a href="<?php echo $menu['url']; ?>" class="nav-link align-middle px-0 " data-bs-toggle="collapse">
                                <img src="<?php echo constant("SITE_URL"); ?><?php echo $menu['icon']; ?>" alt=""> <span class="ms-1 d-sm-inline"><?php echo $menu['title']; ?></span>
                            </a>
                        </li>
                        <?php
                        foreach ($sub_menus as $sub) {
                            if ($sub['parentid'] == $menu['id']) {
                        ?>
                                <ul class="nav flex-column ms-1" id="<?php echo str_replace("#", '', $menu['url']) ?>" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="<?php echo constant("SITE_URL"); ?><?php echo $sub['url'] ?>" class="nav-link px-0">- <?php echo $sub['title'] ?></a>
                                    </li>

                                </ul>

                <?php

                            }
                        }
                    }
                }
                ?>
            </ul>
            <div class="dropdown my-4 d-flex flex-row">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo constant("SITE_URL"); ?>/uploads/<?php echo $adminInfo['image']; ?>" alt="hugenerd" width="30" height="30" class="rounded-circle">
                <span class="d-none d-sm-inline mx-1">پروفایل</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="<?php echo constant("SITE_URL"); ?>/setting.php?id=<?php echo $adminId; ?>">تنظیمات</a></li>
                <li><a class="dropdown-item" href="<?php echo constant("SITE_URL"); ?>/logout.php">خروج</a></li>
            </ul>
        </div>
        </div>
    </div>
</nav>

<!--desktop version-->
<div class="col-2 px-sm-2 px-0 bg-dark min-vh-100 menu position-relative d-none d-md-block">


    <div class=" position-fixed d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline">سلام <?php echo $_SESSION['name']; ?></span>
        </a>

        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start " id="menu">
            <li class="nav-item">
                <a href="<?php echo constant("SITE_URL"); ?>/dashboard.php" class="nav-link align-middle px-0">
                    <img src="<?php echo constant("SITE_URL"); ?>/assets/icons/building.svg" alt=""> <span class="ms-1 d-none d-sm-inline">داشبورد</span>
                </a>
            </li>
            <?php

            foreach ($menus as $menu) {
                if ($menu['type'] == 'menu') {
            ?>
                    <li class="nav-item">
                        <a href="<?php echo $menu['url']; ?>" class="nav-link align-middle px-0 " data-bs-toggle="collapse">
                            <img src="<?php echo constant("SITE_URL"); ?><?php echo $menu['icon']; ?>" alt=""> <span class="ms-1 d-none d-sm-inline"><?php echo $menu['title']; ?></span>
                        </a>
                    </li>
                    <?php
                    foreach ($sub_menus as $sub) {
                        if ($sub['parentid'] == $menu['id']) {
                    ?>
                            <ul class="nav flex-column ms-1" id="<?php echo str_replace("#", '', $menu['url']) ?>" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="<?php echo constant("SITE_URL"); ?><?php echo $sub['url'] ?>" class="nav-link px-0">- <?php echo $sub['title'] ?></a>
                                </li>

                            </ul>

            <?php

                        }
                    }
                }
            }
            ?>


        </ul>
        <hr>
        <div class="dropdown pb-4 d-flex flex-row">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo constant("SITE_URL"); ?>/uploads/<?php echo $adminInfo['image']; ?>" alt="hugenerd" width="30" height="30" class="rounded-circle">
                <span class="d-none d-sm-inline mx-1">پروفایل</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="<?php echo constant("SITE_URL"); ?>/setting.php?id=<?php echo $adminId; ?>">تنظیمات</a></li>
                <li><a class="dropdown-item" href="<?php echo constant("SITE_URL"); ?>/logout.php">خروج</a></li>
            </ul>
        </div>
    </div>
</div>