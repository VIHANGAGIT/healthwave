<?php 
  if(($_SESSION['userType']) != 'Manager'){
    redirect("users/login");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME; ?>: Hospital Staff Approvals</title>
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
            <li class="item active">
              <a href="../manager/dashboard" class="link flex">
                <i class="uil uil-chart-line"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="item">
              <a href="../manager/approvals" class="link flex">
                <i class="uil uil-check-circle"></i>
                <span>Approvals</span>
              </a>
            </li>
            <li class="item">
              <a href="../manager/doc_management" class="link flex">
                <i class="uil uil-stethoscope"></i>
                <span>Doctor Management</span>
              </a>
            </li>
            <li class="item">
              <a href="../manager/test_management" class="link flex">
                <i class="uil uil-heart-rate"></i>
                <span>Test Management</span>
              </a>
            </li>
            <li class="item">
              <a href="../manager/reservations" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Reservations</span>
              </a>
            </li>
            <li class="item">
              <a href="../manager/schedule_management" class="link flex">
                <i class="uil uil-calender"></i>
                <span>Schedule Management</span>
              </a>
            </li>
          <li class="item">
              <a href="../manager/room_management" class="link flex">
                <i class="uil uil-house-user"></i>
                <span>Room Management</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="../manager/profile" class="link flex">
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

    <!--Search box-->
    <div class="content">
    <section class="table-wrap" >
            <div class="table-container">
                <h1>Hospital Statistics :<span class="dashboard-stat" style="font-size: 25px;" >HealthWave</span></h1>
                <table class="table-dashboard">
                    <tbody>
                        <tr class="dashboard-row">
                            <td class="dashboard-content">
                                <p class="dashboard-stat-title">Total Number<br>of Patients :</p>
                                <p class="dashboard-stat"><?php echo $data['statistic']['total_patients'] ?></p>
                            </td>
                            
                            <td class="dashboard-content">
                                <p class="dashboard-stat-title">Total Number<br>of Doctors :</h2>
                                <p class="dashboard-stat"><?php echo $data['statistic']['total_doctors'] ?></p>
                            </td>
                            <td class="dashboard-content">
                                <p class="dashboard-stat-title">Total Number<br>of Hospitals :</h2>
                                <p class="dashboard-stat"><?php echo $data['statistic']['total_hospitals'] ?></p>
                            </td>
                            <td class="dashboard-content">
                                <p class="dashboard-stat-title">Total Number<br>of Reservations :</h2>
                                <p class="dashboard-stat"><?php echo $data['statistic']['total_reservations'] ?></p>
                            </td>
                            <td class="dashboard-content">
                                <p class="dashboard-stat-title">Number of Upcoming<br> Reservations :</h2>
                                <p class="dashboard-stat"><?php echo $data['statistic']['total_upcoming'] ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section><br>
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Data Visualizations</h1>
                <hr><br>
                <table class="table-dashboard">
                    <tbody>
                        <tr>
                            <td>
                                <div class="visualization" >
                                    <canvas id="myChart"></canvas>
                                </div>
                            </td>
                            <td>
                                <div class="dashboard-types">
                                    <h2>Other Visulaizations</h2><br>
                                    <button class='button' style="width: 200px;" >Doctors by Spec.</button><br>
                                    <button class='button' style="width: 200px;" >Patients by Month</button><br>
                                    <button class='button' style="width: 200px;" >Lab Tests by Month</button><br>
                                    <button class='button' style="width: 200px;" >Lab Tests by Type</button><br>
                                    <button class='button' style="width: 200px;" >Earnings by Month</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section class="table-wrap" >
        <div class="content-search">
              <div class="search">
                <h2>Report Filter</h2>
                  <form style="width: 100%;" method="POST">
                    <div class="fields">
                      <table style="width: 95%;">
                        <tr>
                          <td>
                            <div class="input-field">
                                <label>Report Type</label>
                                <select name="report_name" >
                                  <option disabled selected>Select Type of Report</option>
                                  <option value="doc" >Appointment Booking Report</option>
                                  <option value="test" >Test Booking Report</option>
                                  <!-- <option value="payment" >Payment Report</option> -->
                              </select>
                            </div>
                          </td>
                          <td>
                            <div class="input-field">
                                <label>Patient Name</label>
                                <select name="patient_name" >
                                  <option disabled selected>Select Patient Name</option>
                                  <?php foreach ($data['patients'] as $patient): ?>
                                    <option value="<?php echo $patient->Patient_ID; ?>"><?php echo $patient->First_Name . ' ' . $patient->Last_Name . ' - '. $patient->NIC; ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>
                          </td>
                          <td>
                            <input type="submit" class="button" value="Generate" name="search" >
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="input-field">
                                <label>Doctor Name</label>
                                <select name="doctor_name" >
                                  <option disabled selected>Select Doctor Name</option>
                                  <?php foreach ($data['doctors'] as $doctor): ?>
                                    <option value="<?php echo $doctor->Doctor_ID?>"><?php echo $doctor->First_Name . ' ' . $doctor->Last_Name . ' - '. $doctor->Specialization; ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>
                          </td>
                          <td>
                            <div class="input-field">
                                <label>Time Period</label>
                                <select name="no_of_days" required>
                                  <option value="7" selected>Last 7 days</option>
                                  <option value="30" >Last 30 days</option>
                                  <option value="90" >Last 90 days</option>
                                </select>
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
            <h1>Reports</h1>
            <hr><br>
                <?php if (empty($data['doc_report']) && empty($data['test_report'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>Generate to get reports</p>
                    </div>
                <?php elseif(!empty($data['doc_report'])): ?>
                <table  id="myTable" class="table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Res ID</th>
                            <th style="text-align: center;">Patient Name</th>
                            <th style="text-align: center;">Doctor Name</th>
                            <th style="text-align: center;">Hospital Name</th>
                            <th style="text-align: center;">Date</th>
                            <th style="text-align: center;">Time Slot</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data['doc_report'] as $doc_report): ?>
                      <tr>
                        <td style="text-align: center;"><?php echo $doc_report->Doc_Res_ID; ?></td>
                        <td style="text-align: center;"><?php echo $doc_report->First_Name . " " . $doc_report->Last_Name; ?></td>
                        <td style="text-align: center;"><?php echo $doc_report->Doc_First_Name . ' ' . $doc_report->Doc_Last_Name; ?></td>
                        <td style="text-align: center;"><?php echo $doc_report->Hospital_Name; ?></td>
                        <td style="text-align: center;"><?php echo $doc_report->Date; ?></td>
                        <td style="text-align: center;"><?php echo $doc_report->Start_Time . ' - ' . $doc_report->End_Time; ?></td>
                      </td>

                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php elseif(!empty($data['test_report'])): ?>
                <table  id="myTable" class="table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Res ID</th>
                            <th style="text-align: center;">Patient Name</th>
                            <th style="text-align: center;">Test Name</th>
                            <th style="text-align: center;">Hospital Name</th>
                            <th style="text-align: center;">Date</th>
                            <th style="text-align: center;">Time Slot</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data['test_report'] as $test_report): ?>
                      <tr>
                        <td style="text-align: center;"><?php echo $test_report->Test_Res_ID; ?></td>
                        <td style="text-align: center;"><?php echo $test_report->First_Name . " " . $test_report->Last_Name; ?></td>
                        <td style="text-align: center;"><?php echo $test_report->Test_Name; ?></td>
                        <td style="text-align: center;"><?php echo $test_report->Hospital_Name; ?></td>
                        <td style="text-align: center;"><?php echo $test_report->Date; ?></td>
                        <td style="text-align: center;"><?php echo $test_report->Start_Time . ' - ' . $test_report->End_Time; ?></td>
                      </td>

                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section><br>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
      $(document).ready(function() {
          $('#myTable').dataTable( {
              "bPaginate": false,
              "bFilter": false,
              "bInfo": false
          } );
      } );
    </script> 
   
    <script>
      const ctx = document.getElementById('myChart');

      // Extracted PHP data for JavaScript
      const labels = ['<?php echo $data['months']; ?>'];
      const data = [<?php echo $data['reservationsCount']; ?>];

      new Chart(ctx, {
          type: 'line',
          data: {
              labels: labels,
              datasets: [{
                  label: 'Total No of Doctor Reservations',
                  data: data,
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });
  </script>
      
  </body>
</html>