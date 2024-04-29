<?php 
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
    <title><?php echo SITENAME; ?>: Test Reservations</title>
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
            <li class="item">
              <a href="../lab/completed_tests" class="link flex">
              <i class="uil uil-file-check-alt"></i>
                <span>Completed Tests</span>
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
          <h2>Test Reservation Search<span class="dashboard-stat" style="font-size: 25px; justify-content: right;" ></span></h2>
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <table style="width: 95%;" >
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Patient ID</label>
                            <input type="text" name="search_text" placeholder="Patient ID">
                        </div>
                      </td>
                      <td>
                        <div class="input-field">
                            <label>Patient Name</label>
                            <input type="text" name="search_text" placeholder="Patient Name">
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
        <br>
        <section class="table-wrap" >
            <div class="table-container">
            <h1>Add Reservation<span class="dashboard-stat" style="font-size: 25px; justify-content: right;" ><a href='../lab/add_lab_test'><button class='button'>Add</button></a></span></h1>
              <hr><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Date</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data['reservations'] as $reservations): ?>
                      <tr>
                            <td style="text-align: center;"><?php echo $reservations->Patient_ID;?></td>
                            <td style="text-align: center;"><?php echo $reservations->First_Name. " ".$reservations->Last_Name;?></td>
                            <td style="text-align: center;"><?php echo $reservations->Date;?></td>
                            <td><a href='lab_test_details?patient_id=<?php echo $reservations->Patient_ID ?>&date=<?php echo $reservations->Date ?>'><button class='button'>View</button></a></td>
                        </tr>
                    <?php endforeach;?>  
                    </tbody>
                </table>
            </div>
        </section>
    </div>

  </body>
</html>