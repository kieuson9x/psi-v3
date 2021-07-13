<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-primary mb-3">
    <div class="flex-row d-flex">
        <button type="button" class="navbar-toggler mr-2 " data-toggle="offcanvas" title="Toggle responsive left sidebar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#" title="Free Bootstrap 4 Admin Template">Kangaroo - PSI</a>
    </div>

    <div class="navbar-collapse collapse" id="collapsingNavbar">
        <ul class="navbar-nav">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <?php
                $employee_level = $_SESSION['employee_level'] ?? '';

                if ($employee_level == 'Quản lý khu vực' || $employee_level == 'Admin') :
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "/agencies.php" ?>">
                            <i class="material-icons" style="font-size: 13px">business_center</i>
                            Danh sách đại lý
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])) : ?>
                <?php
                $employee_level = $_SESSION['employee_level'] ?? '';

                if ($employee_level == 'Tài chính' || $employee_level == 'Admin') :
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "/inventories.php" ?>" id="nav-link-inventory">
                            <i class="material-icons" style="font-size: 13px">inventory_2</i>
                            Bảng nhập tồn kho
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])) : ?>
                <?php
                $employee_level = $_SESSION['employee_level'] ?? '';

                if ($employee_level == 'Quản lý khu vực' || $employee_level == 'Admin') :
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "/employee-sales.php" ?>"" id=" nav-link-employee-sales">
                            <i class="material-icons" style="font-size: 13px">inventory_2</i>
                            Bảng nhập nhập số sales
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">Xin chào <?php echo $_SESSION['full_name'] ?? ''; ?></span>
            </li>
            <li class="nav-item">
                <span class="nav-link"> | </span>
            </li>
            <li class="nav-item" id="topNavLogout"><a href="logout.php" class="nav-link"> <i class="glyphicon glyphicon-log-out"></i> Đăng xuất</a></li>
            </li>
        </ul>


    </div>

    <li class="nav-item navigation-item hidden" id="topNavLogout"><a href="logout.php" class="nav-link"> <i class="glyphicon glyphicon-log-out"></i> Đăng xuất</a></li>
    </li>
</nav>