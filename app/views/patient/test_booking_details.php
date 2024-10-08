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
    <title><?php echo SITENAME; ?>: Test Booking</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
  </head>
  <body>

    <div class="popup-container-1">
        <div class="popup-box-1">
            <h1>Reservation Summary</h1><br>
            <hr>
            <p class="popup-data" id="patient-name-popup" ><b>Patient Name: </b> </p>
            <p class="popup-data" id="patient-nic-popup" ><b>Patient NIC: </b> </p>
            <p class="popup-data" id="patient-mobile-popup" ><b>Mobile Number: </b> </p>
            <p class="popup-data" id="patient-email-popup" ><b>Email Address: </b> </p>
            <p class="popup-data" id="test-name-popup" ><b>Test Name: </b> </p>
            <p class="popup-data" id="test-type-popup" ><b>Test Type: </b> </p>
            <p class="popup-data" id="hospital-name-popup" ><b>Hospital Name: </b> </p>
            <p class="popup-data" id="app-date-popup" ><b>Date: </b> </p>
            <p class="popup-data" id="app-time-popup" ><b>Time Slot: </b> </p>
            <p class="popup-data" id="price-value-total-popup" ><b>Total Price: </b> </p>
            <button class="close-btn pay-btn" id="pay" >Pay Now</button>
        </div>
    </div>
    
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
      <div class="content-appointment">
          <div class="appointment">
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <h2>Enter Reservation Details</h2>
                  <table style="width: 95%;">
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Patient Name</label>
                            <input type="text" name="patient_name" id="patient-name" value="<?php echo $data['First_Name']. ' '. $data['Last_Name'] ?>" disabled>
                        </div>
                      </td>
                      <td rowspan="5">
                        <div class="profile-card">
                          <div class="profile-name" id="test-name"><?php echo $data['test_data']->Test_Name?></div>
                          <div class="profile-specialization" id="test-type"><?php echo $data['test_data']->Test_Type?></div>
                        </div>
                        <div class="price-card">
                          <div class="price-item">
                            <span class="price-label">Test Charges:</span>
                            <span class="price-value" id="price-value-test">LKR 0.00</span> <!-- Use JS for this since price changes with hospital -->
                          </div>
                          <div class="price-item">
                            <span class="price-label">Service Charges:</span>
                            <span class="price-value" id="price-value-service">LKR 100.00</span>
                          </div>
                          <div class="price-item">
                            <span class="price-label">Taxes (5%):</span>
                            <span class="price-value" id="price-value-tax">LKR 0.00</span>
                          </div>
                          <hr>
                          <div class="price-item">
                            <span class="price-label">Total Price:</span>
                            <span class="price-value-total" id="price-value-total">LKR 0.00</span>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Patient NIC</label>
                            <input type="text" name="patient_nic" id="patient-nic" value="<?php echo $data['NIC'] ?>" disabled>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="text" name="patient_mobile" id="patient-mobile" value="<?php echo $data['C_Num']?>">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Email Address</label>
                            <input type="text" name="patient_email" id="patient-email" value="<?php echo $data['Email']?>">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input-field">
                          <label>Select Hospital</label>
                          <select id="hospitalSelect">  
                              <option disabled selected>Select Hospital</option>
                              <?php foreach ($data['hospital_data'] as $hospital): ?>
                                  <option value="<?php echo $hospital->Hospital_ID; ?>"><?php echo $hospital->Hospital_Name; ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <br>
                        <div class="input-field">
                            <label>Select Date</label>
                            <div class="container-radio" name="date">
                                <!-- Date options will be added here -->
                            </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      <br>
                      <div class="input-field">
                          <label>Select Time Slot</label>
                          <div class="container-radio" name="time">
                              <!-- Time slots will be added here -->
                          </div>
                      </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <!--<input type="submit" class="button" value="Next" name="search" >-->
                        <button id="show1" class="button" style="background-color: #4070f4;" >Next</button>
                        <button id="cancel" class="button" style="background-color: red;" >Cancel</button>
                      </td>
                    </tr>
                  </table>
                </div>
              </form>
              <input type="hidden" id="testId" value="<?php echo $data['test_data']->Test_ID; ?>">
              <input type="hidden" id="selectedDay">
              <input type="hidden" id="selectedDate">
              <input type="hidden" id="startTime">
              <input type="hidden" id="endTime">
          </div>
        </div>
    </div> 
    <br><br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo URLROOT;?>/js/test_payment.js" defer></script>
    <script src="<?php echo URLROOT;?>/js/test_popup.js" defer></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    <script src="<?php echo URLROOT;?>/js/test_booking_details.js" defer></script>
    <!-- <script>
        
        var testId = <?php echo json_encode($data['test_id']); ?>;
        var docCharges = <?php echo json_encode($data['doctor_data']->Charges); ?>;

    </script> -->

  </body>
</html>