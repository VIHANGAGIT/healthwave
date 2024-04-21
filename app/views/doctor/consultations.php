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
    <title><?php echo SITENAME; ?>: Past Consultations</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
  </head>
  <body>

      <div class="popup-container-4 ">
        <div class="popup-box-4">
            <h1>Consultation Details</h1><br>
            <hr>
            <table style="width: 95%;">
              
              <tr>
                <td class="popup-data">
                  <br>
                  <span class="category" >Patient Name: </span><span id="patient-name-popup-4">Steven Spilberg</span>
                  <br>
                  <span class="category">Gender: </span> <span id="patient-gender-popup-4">Male</span>
                  <br>
                  <span class="category">Age: </span> <span id="patient-age-popup-4">55</span>
                  <br>
                </td>
                <td class="popup-data">
                  <span class="category">Blood Group: </span> <span id="patient-blood-popup-4">A+</span>
                  <br>
                  <span class="category">Allergies: </span> <span id="patient-allergies-popup-4">Penicillin antibiotics</span>
                  <br>
                  </td>
              </tr>
              <tr>
                <td class="popup-data" colspan="2">
                    <span class="category">Comments: </span> <span id="patient-comments-popup-4">He is making impressive progress and should continue with the current regimen for optimal results. Encouragement to maintain the good work is recommended.</span>
                </td>
              </tr>
              <tr>
                <td class="popup-data" colspan="2">
                    <br><button class="close-btn btn" id="pay" >Prescription</button>
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
              <a href="../doctor/schedules" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Schedules</span>
              </a>
            </li>
            <li class="item active">
              <a href="../doctor/consultations" class="link flex">
              <i class="uil uil-history"></i>

                <span>Past Consultations</span>
              </a>
            </li>

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
              <hr><br>
              <table id="myTable" class="table">
                    <thead>
                        <tr>
                            
                            <th style="text-align: center;">Reservation ID</th>
                            <th style="text-align: center;">Patient Name</th>
                            <th style="text-align: center;">Hospital</th>
                            <th style="text-align: center;">Date</th>
                            <th style="text-align: center;">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['consultations'] as $consultation): ?>
                                <tr>
                                <td style="text-align: center;"><?php echo $consultation->Doc_Res_ID?></td>
                                <td style="text-align: center;"><?php echo $consultation->First_Name. " " . $consultation->Last_Name?></td>
                                <td style="text-align: center;"><?php echo $consultation->Hospital_Name?></td>
                                <td style="text-align: center;"><?php echo $consultation->Date?></td>
                                <td style="text-align: center;"><a href=""><button class="button show-details-5" data-patient-id="<?php echo $consultation->Patient_ID; ?>">Details</button></a></td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                    
                </table>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="<?php echo URLROOT;?>/js/popup.js" defer></script>
    <script>
      $(document).ready(function() {
          $('#myTable').dataTable( {
              "bPaginate": false,
              "bFilter": false,
              "bInfo": false,
              "columnDefs": [
                {"targets": [4], "orderable": false}, // Disable ordering on the last column
              ]
                    
          } );
      } );
    </script> 
  </body>
</html>