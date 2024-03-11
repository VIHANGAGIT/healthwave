<?php 
  session_start();
  if(($_SESSION['userType']) != 'Manager'){
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
                <h1>Hospital Statistics :<span class="dashboard-stat" style="font-size: 25px;" >Asiri Hospitals - Kirula Rd.</span></h1>
                <table class="table-dashboard">
                    <tbody>
                        <tr class="dashboard-row">
                            <td class="dashboard-content">
                                <p class="dashboard-stat-title">Total Number<br>of Patients :</p>
                                <p class="dashboard-stat">693</p>
                            </td>
                            
                            <td class="dashboard-content">
                                <p class="dashboard-stat-title">Total Number<br>of Doctors :</h2>
                                <p class="dashboard-stat">35</p>
                            </td>
                            <td class="dashboard-content">
                                <p class="dashboard-stat-title">Total Number<br>of Appointments :</h2>
                                <p class="dashboard-stat">1822</p>
                            </td>
                            <td class="dashboard-content">
                                <p class="dashboard-stat-title">Avg. Appointments<br>per Month :</h2>
                                <p class="dashboard-stat">184.5</p>
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
    </div>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'line',
            data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'No of Patients',
                data: [156, 268, 123, 234, 268, 146],
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