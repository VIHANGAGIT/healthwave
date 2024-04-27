<?php 
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  if(($_SESSION['userType']) != 'Pharmacist'){
    redirect("users/login");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <img src="<?php echo URLROOT;?>/img/logo.png" alt=""> HealthWave
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
                    <a href="../pharmacist/dashboard" class="link flex">
                        <i class="uil uil-chart-line"></i>
                        <span>Prescription</span>
                    </a>
                </li>
            <ul class="menu_item">
                <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="../pharmacist/profile" class="link flex">
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
        
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Account Details
                    <span class="dashboard-stat" style="font-size: 25px; justify-content: right;" >
                        <a href='profile_update'><button class='button' style="width: auto;">Update Details</button></a>
                    </span>
                    <span class="dashboard-stat" style="font-size: 25px; justify-content: right;" >
                        <a href='profile_delete'><button class='button red' style="width: auto;">Delete Account</button></a>
                    </span>
                </h1>
                <table class="table-dashboard">
                    <tr>
                        <td class="profile-img">
                            <img src="<?php echo URLROOT;?>/img/profile.png" alt="profile_img" />
                        </td>
                        <td>
                            <table class="table-dashboard">
                                <tbody class="profile" >
                                    <tr>
                                        <td>Name: <?php echo $data['First_Name']. ' ' . $data['Last_Name']?></td>
                                        <td>Gender: <?php echo $data['Gender'] ?></td>
                                        <td>NIC:  <?php echo $data['NIC']?></td>
                                    </tr>
                                    <tr>
                                        <td>Contact Number: <?php echo $data['C_Num'] ?></td>
                                        <td>Email: <?php echo $data['Email'] ?></td>
                                        
                                        <td></td>
                                        
                                    </tr>
                                    <tr>
                                        <td>Staff ID: <?php echo $data['Staff_ID']?></td>
                                        <td>Hospital: <?php echo $data['Hospital']?></td>
                                        <!--<td>Specialization: <?php  //echo $data['Spec'] ?></td>-->
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
        <br>
</div>
</body>
</html>