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
    <title><?php echo SITENAME; ?>: Doctor Schedules</title>
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
            <li class="item active">
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
                <h1>Doctor Schedule Management</h1>
                <hr><br>
                <?php if (empty($data['schedule'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No schedules available</p>
                    </div>
                <?php else: ?>
                <table class="table" id="doc-schedule-table">
                    <thead>
                        <tr>
                            
                            <th style="text-align: center;">Hospital</th>
                            <th style="text-align: center;">Room</th>
                            <th style="text-align: center;">Next Date</th>
                            <th style="text-align: center;">Session Time</th>
                            <th style="text-align: center;">No of Reservations</th>
                            <!--<th>View</th>-->
                            <!--<th>Delete</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['schedule'] as $schedule) {
                                echo "<tr>";
                                echo "<td style='text-align: center;'>".$schedule->Hospital_Name."</td>";
                                echo "<td style='text-align: center;'>".$schedule->Room_Name."</td>";
                                echo "<td style='text-align: center;'>".$schedule->Date."</td>";
                                echo "<td style='text-align: center;'>".$schedule->Time_Start. " - " . $schedule->Time_End."</td>";
                                echo "<td style='text-align: center;'>".$schedule->NoOfReservations."</td>";
                                //echo "<td><a href='../doctor/edit_reservation/".$schedule->Reservation_ID."'><button class='button'>View</button></a></td>";
                                //echo "<td><a href='../doctor/delete_reservation/".$schedule->Reservation_ID."'><button class='button'>Delete</button></a></td>";
                                echo "</tr>";
                            }
                            
                        ?>
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
          $('#doc-schedule-table').dataTable( {
              "bPaginate": false,
              "bFilter": false,
              "bInfo": false
          } );
      } );
    </script> 
  </body>
</html>