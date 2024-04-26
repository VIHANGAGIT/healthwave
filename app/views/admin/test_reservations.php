<?php 
  if(($_SESSION['userType']) != 'Admin'){
    redirect("users/login");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME; ?>: Reservation Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
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
              <a href="../admin/dashboard" class="link flex">
                <i class="uil uil-chart-line"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="item">
              <a href="../admin/approvals" class="link flex">
                <i class="uil uil-check-circle"></i>
                <span>Approvals</span>
              </a>
            </li>
            <li class="item">
              <a href="../admin/doc_management" class="link flex">
                <i class="uil uil-stethoscope"></i>
                <span>Doctor Management</span>
              </a>
            </li>
            <li class="item">
              <a href="../admin/test_management" class="link flex">
                <i class="uil uil-heart-rate"></i>
                <span>Test Management</span>
              </a>
            </li>
            <li class="item">
              <a href="../admin/hospital_management" class="link flex">
                <i class="uil uil-hospital-square-sign"></i>
                <span>Hospital Management</span>
              </a>
            </li>
            <li class="item">
              <a href="../admin/doc_reservations" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Doctor Reservations</span>
              </a>
            </li>
            <li class="item active">
              <a href="../admin/test_reservations" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Test Reservations</span>
              </a>
            </li>
          </ul>
          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="../admin/profile" class="link flex">
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
        <div class="content-search">
          <div class="search">
            <h2>Test Search</h2>
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <table style="width: 95%;">
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Patient Name</label>
                            <input type="text" name="patient_name" placeholder="Enter Patient Name" style="margin: 0%;">
                        </div>
                      </td>
                      <td>
                        <div class="input-field">
                          <label>Test Name</label>
                          <input type="text" name="test_name" placeholder="Enter Test Name" style="margin: 0%;">                        
                        </div>
                      </td>
                      <td>
                        <input type="submit" class="button" value="Search" name="test_search" >
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input-field">
                          <label>Hospital Name</label>
                          <input type="text" name="hospital_name" placeholder="Enter Hospital Name" style="margin: 0%;">
                        </div>
                      </td>
                      <td>
                      <div class="input-field">
                            <label>Date</label>
                            <input type="date" name="date" placeholder="Date" style="margin: 0%;">
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
        </section><br>
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Test Reservations Management</h1>
                <hr><br>
                <?php if (!isset($data['test_appointments'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-search"></i></div>
                        <p>Please search to find test reservations</p>
                    </div>
                <?php elseif (empty($data['test_appointments'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>Could not find reservations for your search query.</p>
                    </div>
                <?php else: ?>
                    <table class="table" id="tests-table" >
                        <thead>
                            <tr>
                                <th style="text-align: center;" >Res. ID</th>
                                <th style="text-align: center;" >Patient Name</th>
                                <th style="text-align: center;" >Test Name</th>
                                <th style="text-align: center;" >Hospital</th>
                                <th style="text-align: center;" >Date</th>
                                <th style="text-align: center;" >Time Slot</th>
                                <th style="text-align: center;" >Edit</th>
                                <th style="text-align: center;" >Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['test_appointments'] as $appointment): ?>
                                <tr>
                                    <td style="text-align: center;" ><?php echo $appointment->Test_Res_ID; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->First_Name. ' ' . $appointment->Last_Name; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Test_Name; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Hospital_Name; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Date; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Start_Time. ' - ' . $appointment->End_Time; ?></td>
                                    <td style="text-align: center;" ><a href=''><button class='button' style="width: 60px;"><i class="uil uil-pen"></i></button></a></td>
                                    <td style="text-align: center;" ><a href=''><button class='button remove'style="width: 60px;"><i class="uil uil-trash-alt"></i></button></a></td>
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
    <script>
      $(document).ready(function() {
            $('#tests-table').dataTable({
                "bPaginate": false, // Disable pagination
                "bFilter": false, // Disable search/filtering
                "bInfo": false, // Disable info text
                "columnDefs": [
                    { "targets": [6, 7], "orderable": false } // Disable ordering on columns 5 and 6
                ]
            });
        });
    </script> 
  </body>
</html>