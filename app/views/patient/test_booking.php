<?php 
  if(($_SESSION['userType']) != 'Patient'){
    redirect("users/login");
  }
?>
<!DOCTYPE html>
<!-- Coding by CodingNepal || www.codingnepalweb.com -->
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
              <a href="../patient/doc_booking" class="link flex">
                <i class="uil uil-stethoscope"></i>
                <span>Doctor Booking</span>
              </a>
            </li>
            <li class="item active">
              <a href="../patient/test_booking" class="link flex">
                <i class="uil uil-heart-rate"></i>
                <span>Lab Test Booking</span>
              </a>
            </li>
            <li class="item">
              <a href="../patient/reservations" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Reservations</span>
              </a>
            </li>
            <li class="item">
              <a href="../patient/medical_records" class="link flex">
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

      <div class="content-search">
          <div class="search">
            <h2>Find Lab Tests</h2>
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <table style="width: 95%;" >
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Test Name</label>
                            <input type="text" name="search_text" placeholder="Test Name">
                        </div>
                      </td>
                      <td>
                        <div class="input-field">
                          <label>Hospital Name</label>
                          <select required>
                              <option disabled selected>Select Hospital</option>
                              <option>Lanka Hospitals - Kiribathgoda</option>
                              <option>Lanka Hospitals - Kiribathgoda</option>
                              <option>Lanka Hospitals - Kiribathgoda</option>
                          </select>
                        </div>
                      </td>
                      <td>
                        <input type="submit" class="button" value="Search" name="search" >
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Test Type</label>
                            <input type="text" name="search_text" placeholder="Type">
                        </div>
                      </td>
                      <td>
                      <div class="input-field">
                            <label>Date</label>
                            <input type="date" name="search_text" placeholder="Date">
                        </div>
                      </td>
                      <td>
                        <a href=""><button class="button" style="background-color: red;" >Reset</button></a>
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
                <p class="detail-title">Complete Blood Count (CBC)</p>
                <p class='detail-comp'>Blood Test</p>
                <!--div class='detail-details'
                    <p><i class='uil uil-calendar-alt'></i>hh</p>
                    <p><i class='uil uil-clock'></i>gg</p>
                    
                </-div-->
            </div>
            <div class='detail-card-sub'>
            <hr class="vertical-line">
                <div class='detail-card-info'>
                    <p>Available at :</p>
                    <p class="detail-location" >4 locations</p>
                </div>
            </div>
            <div class='detail-view'>
              <button class='button detail-btn'style="width:230px" >Book Now</button>
            </div>
          </div>
          <div class='detail-card'>
            <div class='detail-card-content'>
                <p class="detail-title">Complete Blood Count (CBC)</p>
                <p class='detail-comp'>Blood Test</p>
            </div>
            <div class='detail-card-sub'>
            <hr class="vertical-line">
                <div class='detail-card-info'>
                    <p>Available at :</p>
                    <p class="detail-location" >4 locations</p>
                </div>
            </div>
            <div class='detail-view'>
              <button class='button detail-btn'style="width:230px" >Book Now</button>
            </div>
          </div>

          <div class='detail-card'>
            <div class='detail-card-content'>
                <p class="detail-title">Complete Blood Count (CBC)</p>
                <p class='detail-comp'>Blood Test</p>
            </div>
            <div class='detail-card-sub'>
            <hr class="vertical-line">
                <div class='detail-card-info'>
                    <p>Available at :</p>
                    <p class="detail-location" >4 locations</p>
                </div>
            </div>
            <div class='detail-view'>
              <button class='button detail-btn'style="width:230px" >Book Now</button>
            </div>
          </div>

          <div class='detail-card'>
            <div class='detail-card-content'>
                <p class="detail-title">Complete Blood Count (CBC)</p>
                <p class='detail-comp'>Blood Test</p>
            </div>
            <div class='detail-card-sub'>
            <hr class="vertical-line">
                <div class='detail-card-info'>
                    <p>Available at :</p>
                    <p class="detail-location" >4 locations</p>
                </div>
            </div>
            <div class='detail-view'>
              <button class='button detail-btn'style="width:230px" >Book Now</button>
            </div>
          </div>

          
        </div>
        
    </div>
  </body>
</html>