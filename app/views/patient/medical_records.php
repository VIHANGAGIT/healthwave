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
    <title><?php echo SITENAME; ?>: Medical Records</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
  </head>
  <body>

      <div class="popup-container-4">
        <div class="popup-box-4">
            <h1>Consultation Details</h1><br>
            <hr>
            <table style="width: 95%;">
              <tr>
                <td class="popup-data" colspan="2">
                  <br>
                    <span class="category">Comments: </span> <span id="patient-comments-popup-4"></span>
                </td>
              </tr>
            </table>
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
            <li class="item">
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
            <li class="item active">
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
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Past Consultations</h1>
                <hr>
                <?php if (empty($data['doc_consultations'])): ?>
                  <br>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No past consultation records available</p>
                    </div>
                <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Specialization</th>
                            <th>Hospital</th>
                            <th>Date</th>
                            <th>Details</th>
                            <th>Prescription</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['doc_consultations'] as $doc_consultation): ?>
                          <tr>
                              <td>Dr. <?php echo $doc_consultation->First_Name . ' ' . $doc_consultation->Last_Name; ?></td>
                              <td><?php echo $doc_consultation->Specialization; ?></td>
                              <td><?php echo $doc_consultation->Hospital_Name; ?></td>
                              <td><?php echo $doc_consultation->Date; ?></td>
                              <td><button class='button show-details-7' data-res-id="<?php echo $doc_consultation->Doc_Res_ID; ?>">Details</button></td>
                              <td><a href='view_prescription?id=<?php echo $doc_consultation->Prescription_ID ?>' ><button class='button doc-cancel-btn'<?php echo ($doc_consultation->Prescription_ID == null ? 'disabled' : '') ?> >Prescription</button></td>
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
                <h1>Lab Tests Results</h1>
                <hr>
                <?php if (empty($data['test_reservations'])): ?>
                  <br>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No past lab test records available</p>
                    </div>
                <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Test Name</th>
                            <th>Test Type</th>
                            <th>Hospital</th>
                            <th>Date</th>
                            <th>Details</th>
                            <th>Results</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['test_reservations'] as $test_reservation): ?>
                            <tr>
                                <td><?php echo $test_reservation->Test_Name; ?></td>
                                <td><?php echo $test_reservation->Test_Type; ?></td>
                                <td><?php echo $test_reservation->Hospital_Name; ?></td>
                                <td><?php echo $test_reservation->Date; ?></td>
                                <td><a href=''><button class='button'>Details</button></a></td>
                                <td>
                                <a href='<?php echo str_replace("\\", "/", APPROOT) . "/results_upload/" . $test_reservation->Result; ?>'>
                                    <button class='button'>Results</button>
                                </a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="<?php echo URLROOT;?>/js/popup.js" defer></script>
  </body>
</html>