<?php 
  session_start();
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
        <img src="../images/logo.png" alt=""> HealthWave
      </div>
      <div class="navbar_content">
        <i class='uil uil-sun' id="darkLight"></i>
        <button class='button'>Logout</button>
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
              <a href="../home.php" class="link flex">
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
              <a href="doc_booking.php" class="link flex">
                <i class="uil uil-stethoscope"></i>
                <span>Doctor Booking</span>
              </a>
            </li>
            <li class="item">
              <a href="test_booking.php" class="link flex">
                <i class="uil uil-heart-rate"></i>
                <span>Lab Test Booking</span>
              </a>
            </li>
            <li class="item">
              <a href="reservations.php" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Reservations</span>
              </a>
            </li>
            <li class="item">
              <a href="medical_records.php" class="link flex">
                <i class="uil uil-file-alt"></i>
                <span>Medical Records</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="#" class="link flex">
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
            <img src="../images/profile.png" alt="logo_img" />
          </span>
          <div class="data_text">
            <span class="name">K.H. Gunawardhana</span><br>
            <span class="role">Patient</span>
          </div>
        </div>
      </div>
    </nav>

    <div class="content" style="padding-top: 4%;">
        <div class="container-edit">
            <div class="forms">
                <div class="form login">
                    <span class="title">Make Appointment</span>

                    <form action="#">
                        <div class="input-field">
                            <label>Patient Name</label><br>
                            <input type="text" name="name" value="K.H. Gunawardhana" disabled required>
                        </div>
                        <div class="input-field">
                            <label>Location</label><br>
                            <select name="hospital" required>
                                <option selected value="Select hospital"</option>
                                <option value="Asiri Hospitals - Kirula Rd">Asiri Hospitals - Kirula Rd.</option>
                                <option value="Lanka Hospitals - Nugegoda">Lanka Hospitals - Nugegoda</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Date</label><br>
                            <input type="date" required>
                        </div>
                        <div class="input-field">
                            <label>Time</label><br>
                            <select name="hospital" required>
                                <option selected value="Select time"</option>
                                <option value="9:00 AM">9:00 AM</option>
                                <option value="9:30 AM">9:30 AM</option>
                                <option value="12:30 PM">12:30 PM</option>
                                <option value="13:00 PM">13:00 pM</option>
                                <option value="13:30 PM">13:30 PM</option>
                            </select>
                        </div>
                        <div class="input-field">
                          <table class="table-edit">
                              <tr class="table-edit-row" >
                                  <td>
                                      <div class="edit-btn">
                                        <button class='button' >Book Now</button>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="edit-btn">
                                        <button class='button red' >Cancel</button>
                                      </div>
                                  </td>
                              </tr>
                          </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>