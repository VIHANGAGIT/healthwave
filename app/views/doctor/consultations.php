<?php 
  session_start();
  if(($_SESSION['userType']) != 'Doctor'){
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
              <a href="" class="link flex">
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
              <a href="../doctor/reservations" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Reservations</span>
              </a>
            </li>
            <li class="item active">
              <a href="../doctor/consultations" class="link flex">
              <i class="uil uil-history"></i>

                <span>Past Consultations</span>
              </a>
            </li>
          </ul>

          <li class="item">
              <a href="../doctor/ongoing_consults" class="link flex">
                <i class="uil uil-stethoscope"></i>
                <span>Ongoing Consultations</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="../doctor/profile" class="link flex">
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

    <div class="content">
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Past Consulations</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Details</th>
                            <!--<th>Prescription</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>12223</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href='patient_details'><button class='button'>Details</button></a></td>
                            <!--<td><a href=''><button class='button'>Prescription</button></a></td>-->
                        </tr>
                        <!--<tr>
                            <td>12223</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href=''><button class='button'>Details</button></a></td>
                            <td><a href=''><button class='button'>Prescription</button></a></td>
                        </tr>
                        <tr>
                            <td>12223</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href=''><button class='button'>Details</button></a></td>
                            <td><a href=''><button class='button'>Prescription</button></a></td>
                        </tr>
                        <tr>
                            <td>12223</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href=''><button class='button'>Details</button></a></td>
                            <td><a href=''><button class='button'>Prescription</button></a></td>
                        </tr>
                        <tr>
                            <td>12223</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href=''><button class='button'>Details</button></a></td>
                            <td><a href=''><button class='button'>Prescription</button></a></td>
                        </tr>
                        <tr>
                            <td>12223</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href=''><button class='button'>Details</button></a></td>
                            <td><a href=''><button class='button'>Prescription</button></a></td>
                        </tr>
                        <tr>
                            <td>12223</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href=''><button class='button'>Details</button></a></td>
                            <td><a href=''><button class='button'>Prescription</button></a></td>
                        </tr>
                        <tr>
                            <td>12223</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href=''><button class='button'>Details</button></a></td>
                            <td><a href=''><button class='button'>Prescription</button></a></td>
                        </tr>-->
                    </tbody>
                </table>
            </div>
        </section>
    </div>
  </body>
</html>