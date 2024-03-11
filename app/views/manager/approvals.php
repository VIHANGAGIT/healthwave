<?php
session_start();
if ($_SESSION['userType'] != 'Manager') {
    redirect("users/login");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style2.css"/>
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="<?php echo URLROOT; ?>/js/light_mode.js" defer></script>
</head>
<body>
<!-- navbar -->
<nav class="navbar">
    <div class="logo_item">
        <img src="<?php echo URLROOT; ?>/img/logo.png" alt=""> HealthWave
    </div>
    <div class="navbar_content">
        <i class='uil uil-sun' id="darkLight"></i>
        <a href='../users/logout'><button class='button'>Logout</button></a>
    </div>
</nav>

<!--sidebar-->
<nav class="sidebar">
    <div class="menu_container">
        <div class="menu_items">
            <ul class="menu_item">
                <div class="menu_title flex">
                    <span class="line"></span>
                </div>
                <li class="item">
                    <a href="#" class="link flex">
                        <i class="uil uil-estate"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="item">
                    <a href="#" class="link flex">
                        <i class="uil uil-info-circle"></i>
                        <span>About Us</span>
                    </a>
                </li>
            </ul>

            <ul class="menu_item">
                <div class="menu_title flex">
                    <span class="line"></span>
                </div>
                <li class="item">
                    <a href="../manager/dashboard" class="link flex">
                        <i class="uil uil-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="item active">
                    <a href="../manager/approvals" class="link flex">
                        <i class="uil uil-check-circle"></i>
                        <span>Approvals</span>
                    </a>
                </li>
                <li class="item">
                    <a href="../manager/doc_management" class="link flex">
                        <i class="uil uil-stethoscope"></i>
                        <span>Doctor Management</span>
                    </a>
                </li>
                <li class="item">
                    <a href="../manager/test_management" class="link flex">
                        <i class="uil uil-heart-rate"></i>
                        <span>Test Management</span>
                    </a>
                </li>
                <li class="item">
                    <a href="../manager/reservations" class="link flex">
                        <i class="uil uil-calendar-alt"></i>
                        <span>Reservations</span>
                    </a>
                </li>
            </ul>

            <ul class="menu_item">
                <div class="menu_title flex">
                    <span class="line"></span>
                </div>
                <li class="item">
                    <a href="../manager/profile" class="link flex">
                        <i class="uil uil-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="item">
                    <a href="#" class="link flex">
                        <i class="uil uil-bell"></i>
                        <span>Notifications</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar_profile flex">
            <span class="nav_image">
                <img src="<?php echo URLROOT; ?>/img/profile.png" alt="logo_img"/>
            </span>
            <div class="data_text">
                <span class="name"><?php echo $_SESSION['userName'] ?></span><br>
                <span class="role"><?php echo $_SESSION['userType'] ?></span>
            </div>
        </div>
    </div>
</nav>

<div class="content">
    <section class="table-wrap">
        <div class="table-container">
            <h1>Hospital Staff Approvals</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Name</th>
                        <th>NIC</th>
                        <th>Action</th> <!-- Updated heading to "Action" -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pharmacist</td>
                        <td>Prasanna Bandara</td>
                        <td>621011699v</td>
                        <td><a href=''><button class='button'>View</button></a></td> <!-- Updated button to "View" -->
                    </tr>
                    <tr>
                        <td>Lab Assistant</td>
                        <td>Sujith Peris</td>
                        <td>872382331v</td>
                        <td><a href=''><button class='button'>View</button></a></td> <!-- Updated button to "View" -->
                    </tr>
                    <tr>
                        <td>Lab Assistant</td>
                        <td>kamal Perera</td>
                        <td>882382331v</td>
                        <td><a href=''><button class='button'>View</button></a></td> <!-- Updated button to "View" -->
                    </tr>
                    <tr>
                        <td>Pharmacist</td>
                        <td>Tharindu Rathnayaka</td>
                        <td>992382331v</td>
                        <td><a href=''><button class='button'>View</button></a></td> <!-- Updated button to "View" -->
                    </tr>
                    <tr>
                        <td>Lab Assistant</td>
                        <td>Ajith Fernando</td>
                        <td>612382331v</td>
                        <td><a href=''><button class='button'>View</button></a></td> <!-- Updated button to "View" -->
                    </tr>
                    <tr>
                        <td>Pharmacist</td>
                        <td>Dilani Perera</td>
                        <td>792382221v</td>
                        <td><a href=''><button class='button'>View</button></a></td> <!-- Updated button to "View" -->
                    </tr>
                    <tr>
                        <td>Pharmacist</td>
                        <td>Samadhi Rajapakse</td>
                        <td>942382331v</td>
                        <td><a href=''><button class='button'>View</button></a></td> <!-- Updated button to "View" -->
                    </tr>
                    <tr>
                        <td>Lab Assistant</td>
                        <td>Jerome Fernando</td>
                        <td>882382331v</td>
                        <td><a href=''><button class='button'>View</button></a></td> <!-- Updated button to "View" -->
                    </tr>
                     
                </tbody>
            </table>
        </div>
    </section>
</div>

</body>
</html>
