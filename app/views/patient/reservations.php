<?php 
  if(($_SESSION['userType']) != 'Patient'){
    redirect("users/login");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME; ?>: Reservations</title>
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
              <a href="../patient/doc_booking" class="link flex">
                <i class="uil uil-stethoscope"></i>
                <span>Doctor Booking</span>
              </a>
            </li>
            <li class="item">
              <a href="../patient/test_booking" class="link flex">
                <i class="uil uil-heart-rate"></i>
                <span>Lab Test Booking</span>
              </a>
            </li>
            <li class="item active">
              <a href="../patient/reservations" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Reservations</span>
              </a>
            </li>
            <li class="item">
              <a href="../patient/medical_records" class="link flex">
                <i class="uil uil-file-alt"></i>
                <span>Medical History</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="../patient/profile" class="link flex">
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
                <h1>Doctor Reservations</h1>
                <hr>
                <?php if (empty($data['doc_reservations'])): ?>
                  <br>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No upcoming doctor reservations available</p>
                    </div>
                <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Hospital</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Details</th>
                            <th>Cancel</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($data['doc_reservations'] as $doc_reservation): ?>
                          <tr>
                              <td>Dr. <?php echo $doc_reservation->First_Name . ' ' . $doc_reservation->Last_Name; ?></td>
                              <td><?php echo $doc_reservation->Hospital_Name; ?></td>
                              <td><?php echo $doc_reservation->Date; ?></td>
                              <td><?php echo $doc_reservation->Start_Time . ' - ' . $doc_reservation->End_Time; ?></td>
                              <td><a href=''><button class='button'>Details</button></a></td>
                              <td><button id="btn-cancel" class='button red doc-cancel-btn' data-doc-reservation-id="<?php echo $doc_reservation->Doc_Res_ID; ?>" <?php echo ($doc_reservation->allow_cancel == false ? 'disabled' : '') ?>>Cancel</button></td>
                          </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section>
        <br>
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Lab Tests Reservations</h1>
                <hr>
                <?php if (empty($data['test_reservations'])): ?>
                  <br>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No upcoming test reservations available</p>
                    </div>
                <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Test Name</th>
                            <th>Hospital</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Details</th>
                            <th>Cancel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['test_reservations'] as $test_reservation): ?>
                            <tr>
                                <td><?php echo $test_reservation->Test_Name; ?></td>
                                <td><?php echo $test_reservation->Hospital_Name; ?></td>
                                <td><?php echo $test_reservation->Date; ?></td>
                                <td><?php echo $test_reservation->Start_Time . ' - ' . $test_reservation->End_Time; ?></td>
                                <td><a href=''><button class='button'>Details</button></a></td>
                                <td><button id="btn-cancel" class='button red test-cancel-btn' data-test-reservation-id="<?php echo $test_reservation->Test_Res_ID; ?>">Cancel</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <br><br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo URLROOT;?>/js/reservations.js" defer></script>
  </body>
</html>