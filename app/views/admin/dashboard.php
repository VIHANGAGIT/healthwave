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
    <title><?php echo SITENAME; ?>: Admin Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <li class="item">
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
              <a href="#" class="link flex">
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
                <h1>System Statistics :<span class="dashboard-stat" style="font-size: 25px;" >HealthWave</span></h1>
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
    </div>
   
    <script>
    const ctx = document.getElementById('myChart');

    // Extracted PHP data for JavaScript
    const labels = ['<?php echo $data['months']; ?>'];
    const data = [<?php echo $data['reservationsCount']; ?>];

    console.log('labels:' + labels);
    console.log(data);

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