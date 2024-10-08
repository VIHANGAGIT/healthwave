<?php 
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
    <title><?php echo SITENAME; ?>: Ongoing Consultations</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
  </head>
  <body>

    <div class="popup-container-4">
        <div class="popup-box-4">
            <h1>Consultation Details</h1><br>
            <hr>
            <table style="width: 95%;">
              
              <tr>
                <td class="popup-data">
                  <br>
                  <span class="category" >Patient Name: </span><span id="patient-name-popup-4"></span>
                  <br>
                  <span class="category">Gender: </span> <span id="patient-gender-popup-4"></span>
                  <br>
                  <span class="category">Age: </span> <span id="patient-age-popup-4"></span>
                  <br>
                </td>
                <td class="popup-data">
                  <span class="category">Blood Group: </span> <span id="patient-blood-popup-4"></span>
                  <br>
                  <span class="category">Allergies: </span> <span id="patient-allergies-popup-4"></span>
                  <br>
                  </td>
              </tr>
              <tr>
                <td class="popup-data" colspan="2">
                    <br><button class="close-btn btn" id="add_presc" >Add Prescription</button>
                </td>
              </tr>
            </table>
        </div>
    </div>

    <div class="popup-container-6">
        <div class="popup-box-6">
            <h1>Complete without Prescription</h1><br>
            <hr>
            <table style="width: 95%;">
              <tr>
                <td class="popup-data">
                  <br>
                  <form action="" method="POST">
                    <span class="category" >Comments: </span><br>
                    <textarea name="comments" id="comments" rows="4" placeholder="Add comments here" required></textarea>
                    <br><br>
                    <button class="close-btn btn" id="add_consult" >Complete</button>
                  </form>
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
              <a href="" class="link flex">
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
              <a href="../doctor/schedules" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Schedules</span>
              </a>
            </li>
            <li class="item">
              <a href="../doctor/consultations" class="link flex">
              <i class="uil uil-history"></i>

                <span>Past Consultations</span>
              </a>
            </li>
          </ul>

          <li class="item active">
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
        <?php if (empty($data['schedule'])): ?>
            <br>
            <div class="error-msg">
                <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                <p>No ongoing sessions available at the moment</p>
            </div>
        <?php else: ?>
        <h1>Hospital :<span class="dashboard-stat" style="font-size: 25px;" ><?php echo $data['schedule']->Hospital_Name?></span></h1>
        <table class="table-dashboard">
            <tbody>
                <tr class="dashboard-row">
                    <td class="dashboard-content">
                        <p class="dashboard-stat-title">Session<br> Date :</p>
                        <p class="dashboard-stat"><?php echo $data['schedule']->Date?></p>
                    </td>
                    
                    <td class="dashboard-content">
                        <p class="dashboard-stat-title">Session <br> Duration :</h2>
                        <p class="dashboard-stat"><?php echo $data['schedule']->Time_Start. " - " . $data['schedule']->Time_End?></p>
                    </td>
                    <td class="dashboard-content">
                        <p class="dashboard-stat-title">Remaining Number<br>of Patients :</h2>
                        <p class="dashboard-stat"><?php echo $data['remaining_patients']?></p>
                    </td>
                    <td class="dashboard-content">
                        <p class="dashboard-stat-title">Total Number<br> of Patients :</h2>
                        <p class="dashboard-stat"><?php echo $data['total_patients']->NoOfReservations?></p>
                    </td>
                </tr>
            </tbody>
        </table>
      </div>
    </section><br>
    <section class="table-wrap" >
      <div class="table-container">
        <h1>Patient Queue</h1>
        <hr><br>
        <?php if (empty($data['reservations'])): ?>
        <br>
            <div class="error-msg">
                <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                <p>No reservations available for current session</p>
            </div>
        <?php else: ?>
        <section class="table-wrap" >
            <table class="table" id="ongoing-consults-table">
                <thead>
                    <tr>
                        <th style="text-align: center;">Appointment No</th>
                        <th style="text-align: center;">Patient Name</th>
                        <th style="text-align: center;">Gender</th>
                        <th style="text-align: center;">Age</th>
                        <th style="text-align: center;">Time Slot</th>
                        <th style="text-align: center;">Prescription</th>
                        <th style="text-align: center;">Complete</th>
                        <th style="text-align: center;">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['reservations'] as $reservation): ?>
                            <tr>
                            <td style="text-align: center;"><?php echo $reservation->Appointment_No?></td>
                            <td style="text-align: center;"><?php echo $reservation->First_Name. " " . $reservation->Last_Name?></td>
                            <td style="text-align: center;"><?php echo $reservation->Gender?></td>
                            <td style="text-align: center;"><?php echo $reservation->Age?></td>
                            <td style="text-align: center;"><?php echo $reservation->Start_Time. " - " . $reservation->End_Time?></td>
                            <td style="text-align: center;"><a href="prescription?patient_id=<?php echo $reservation->Patient_ID;?>&res_id=<?php echo $reservation->Doc_Res_ID?>"><button class="button" style="width: 50px;"><i class="uil uil-plus"></i></button></a></td>
                            <td style="text-align: center;"><button class="button show-details-6" data-res-id="<?php echo $reservation->Doc_Res_ID; ?>" style="width: 50px;"><i class="uil uil-check"></i></button></td>
                            <td style="text-align: center;"><button class="button show-details-4" data-patient-id="<?php echo $reservation->Patient_ID; ?>">Details</button></td>
                            </tr>
                    <?php endforeach; ?>
                    
                    </tr>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>
    </div>
    <script src="<?php echo URLROOT;?>/js/popup.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
      $(document).ready(function() {
          $('#ongoing-consults-table').dataTable( {
              "bPaginate": false,
              "bFilter": false,
              "bInfo": false,
              "columnDefs": [
                  { "orderable": false, "targets": [5,6,7] }
              ]
          } );
      } );
    </script> 
  </body>
</html>