<?php 
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  if(($_SESSION['userType']) != 'Lab Assistant'){
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
              <a href="../users/landing" class="link flex">
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
            <li class="item active">
              <a href="../lab/test_appt_management" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Reservations</span>
              </a>
            </li>
            <li class="item">
              <a href="../lab/test_management" class="link flex">
                <i class="uil uil-heart-rate"></i>
                <span>Test Management</span>
              </a>
            </li>
            <li class="item">
              <a href="../lab/test_result_upload" class="link flex">
                <i class="uil uil-upload"></i>
                <span>Results Upload</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="../lab/profile" class="link flex">
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
            <img src="<?php echo URLROOT;?>/img/profile.png" alt="logo_img" />
          </span>
          <div class="data_text">
            <span class="name"><?php echo $_SESSION['userName'] ?></span><br>
            <span class="role"><?php echo $_SESSION['userType'] ?></span>
          </div>
        </div>
      </div>
    </nav>
<!--page heading-->
    <div class = "content">
      <section class = "table-wrap">
        <div class = "table-container">
          <h1>Appointment Details 
          </h1>  
        </div>
      </section>
      <br>


<!--test details table-->
      
      <section class = "table-wrap">
      <div class = "table-container">
        <table class = "table">
          <thead>
            <tr>
              <th> Test_Res_ID </th>
              <th> Test Name </th>
              <th> Test Type </th>
              <th> Price </th>
              <th> Time </th>
              <th> Edit </th>
              <th> Remove </th>
            </tr>
          </thead>
          <tbody>

            <?php foreach ($data['reservations'] as $reservations): ?>
                      <tr>
                            <td style="text-align: center;"><?php echo $reservations->Test_Res_ID;?></td>
                            <td style="text-align: center;"><?php echo $reservations->Test_Name;?></td>
                            <td style="text-align: center;"><?php echo $reservations->Test_Type;?></td>
                            <td style="text-align: center;"><?php echo $reservations->Price;?></td>
                            <td style="text-align: center;"><?php echo $reservations->Start_Time. "-".$reservations->End_Time;?></td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                            <!--<td><a href='lab_test_details'><button class='button'>View</button></a></td>-->
                    
                        </tr>
                    <?php endforeach;?>  
            <!--<tr>
              <td> 2 </td>
              <td> Urine Test </td>
              <td> Rs.300</td>
              <td> 1.30 p.m </td>
              <td><a href=''><button class='button'>Edit</button></a></td>
              <td><a href=''><button class='button red'>Remove</button></a></td>
            </tr>
            <tr>
              <td> 3 </td>
              <td> Iodine test </td>
              <td> Rs.500 </td>
              <td> 1.40 p.m </td>
              <td><a href=''><button class='button'>Edit</button></a></td>
              <td><a href=''><button class='button red'>Remove</button></a></td>
            </tr>-->
          </tbody>
        </table>
      </div>
      </section>

    </div>

    



  </body>
</html>