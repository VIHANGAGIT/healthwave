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
    <title><?php echo SITENAME; ?>: Test Booking</title>
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
                            <select name="hospital_name" id="test_name">
                              <?php if(!empty($data['test_names'])): ?>
                                  <?php foreach ($data['test_names'] as $name): ?>
                                          <option value="<?php echo $name->Test_Name; ?>"><?php echo $name->Test_Name; ?></option>
                                  <?php endforeach; ?>
                             <?php else :?>
                            <?php endif?>

                            </select>
                        </div>
                      </td>
                      <td>
                        <div class="input-field">
                          <label>Hospital Name</label>
                          <select name="hospital_name">
                                <option disabled selected>Select Hospital</option>
                                <?php foreach ($data['hospitals'] as $hospital): ?>
                                    <option value="<?php echo $hospital->Hospital_ID; ?>"><?php echo $hospital->Hospital_Name; ?></option>
                                <?php endforeach; ?>
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
                            <select name="test_type" id="test_type" >
                                <option selected disabled>select one</option>
                                <!-- <option>Blood Test</option> -->
                                 <!-- <option></option> -->
                                <?php foreach ($data['types'] as $type): ?>
                                    <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                      </td>
                      <td>
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
          <?php if (empty($data['searchTests'])): ?>
              <div class="error-msg">
                  <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                  <p>Could not find results for your search query.</p>
              </div>
          <?php else: ?>
              <?php foreach ($data['searchTests'] as $test): ?>
                  <div class='detail-card'>
                      <div class='detail-card-content'>
                          <p class="detail-title"><?php echo $test->Test_Name; ?></p> 
                          <p class='detail-comp'><?php echo $test->Test_Type; ?></p>
                      </div>
                      <div class='detail-card-sub'>
                          <hr class="vertical-line">
                          <div class='detail-card-info'>
                              <p>Available at :</p>
                              <p class="detail-location">
                                  <?php
                                  $noOfHospitals = $data['no_of_hospitals'][$test->Test_ID]->NoOfHospitals;
                                  echo $noOfHospitals . ($noOfHospitals == 1 ? ' Location' : ' Locations');
                                  ?>
                              </p>
                          </div>
                      </div>
                      <div class='detail-view'>
                      <a href="/healthwave/patient/test_booking_details?test_id=<?php echo $test->Test_ID; ?>"><button class='button detail-btn' >Book Now</button></a>
                      </div>
                  </div>
              <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- <script src="/js/code_check.js" defer></script> -->
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
        
    </div>
  </body>
</html>