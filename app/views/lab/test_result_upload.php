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
            <li class="item">
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
            <li class="item active">
              <a href="../lab/test_result_upload" class="link flex">
                <i class="uil uil-upload"></i>
                <span>Results Upload</span>
              </a>
            </li>
          </ul>
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

    <div class="content">
        <div class="content-search">
          <div class="search">
          <h2>Lab Test Search<span class="dashboard-stat" style="font-size: 25px; justify-content: right;" ><a href=''></a></span></h2>
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <table style="width: 95%;" >
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Reservation ID</label>
                            <input type="text" name="search_text" placeholder="Reservation ID">
                        </div>
                      </td>
                      <td>
                        <div class="input-field">
                            <label>Patient ID</label>
                            <input type="text" name="search_text" placeholder="Patient ID">
                        </div>
                      </td>
                      <td>
                        <input type="submit" class="button" value="Search" name="search" >
                      </td>
                    </tr>
                  </table>
                </div>
              </form>
          </div>
        </div>
        <div class="detail-wrapper">
            <div class='detail-card'>
                <div class='detail-card-content'>
                    <p class="detail-title">Complete Blood Count (CBC) </p>
                    <p class='detail-comp'>Res ID: 12322  |  Patient: Morgan Stark </p>
                </div>
                <div class='detail-card-sub'>
                <hr class="vertical-line">
                    <div class='detail-card-info'>
                        <p>Status :</p>
                        <p class="detail-location" >Results Pending</p>
                    </div>
                </div>
                <div class='detail-view'>
                <button class="button" style="width: 50px;"><i class="uil uil-upload"></i></button>
                <button class='button complete-btn' >Completed</button>
                </div>
            </div>
            <div class='detail-card'>
                <div class='detail-card-content'>
                    <p class="detail-title">Urine FR</p>
                    <p class='detail-comp'>Res ID: 12325  |  Patient: B.H. Allen </p>
                    <!--div class='detail-details'
                        <p><i class='uil uil-calendar-alt'></i>hh</p>
                        <p><i class='uil uil-clock'></i>gg</p>
                        
                    </-div-->
                </div>
                <div class='detail-card-sub'>
                <hr class="vertical-line">
                    <div class='detail-card-info'>
                        <p>Status :</p>
                        <p class="detail-location" >Results Pending</p>
                    </div>
                </div>
                <div class='detail-view'>
                <button class="button" style="width: 50px;"><i class="uil uil-upload"></i></button>
                <button class='button complete-btn' >Completed</button>
                </div>
            </div>
            <div class='detail-card'>
                <div class='detail-card-content'>
                    <p class="detail-title">Complete Blood Count (CBC) </p>
                    <p class='detail-comp'>Res ID: 12322  |  Patient: L.A. Peter Parker </p>
                    <!--div class='detail-details'
                        <p><i class='uil uil-calendar-alt'></i>hh</p>
                        <p><i class='uil uil-clock'></i>gg</p>
                        
                    </-div-->
                </div>
                <div class='detail-card-sub'>
                <hr class="vertical-line">
                    <div class='detail-card-info'>
                        <p>Status :</p>
                        <p class="detail-location" >Results Pending</p>
                    </div>
                </div>
                <div class='detail-view'>
                <button class="button" style="width: 50px;"><i class="uil uil-upload"></i></button>
                <button class='button complete-btn' >Completed</button>
                </div>
            </div>
            <div class='detail-card'>
                <div class='detail-card-content'>
                    <p class="detail-title">Complete Blood Count (CBC) </p>
                    <p class='detail-comp'>Res ID: 12322  |  Patient: L.A. Peter Parker </p>
                    <!--div class='detail-details'
                        <p><i class='uil uil-calendar-alt'></i>hh</p>
                        <p><i class='uil uil-clock'></i>gg</p>
                        
                    </-div-->
                </div>
                <div class='detail-card-sub'>
                <hr class="vertical-line">
                    <div class='detail-card-info'>
                        <p>Status :</p>
                        <p class="detail-location" >Results Pending</p>
                    </div>
                </div>
                <div class='detail-view'>
                <button class="button" style="width: 50px;"><i class="uil uil-upload"></i></button>
                <button class='button complete-btn' >Completed</button>
                </div>
            </div>
        </div>
        
    </div>
  </body>
</html>