<?php
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
    <title><?php echo SITENAME; ?>: Schedule Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>
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
        <i class='uil uil-calander'></i> 
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
            <li class="item active">
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

    <div class="content">
    <section class="table-wrap" >
    <div class="table-container">
          <div class="search">
            <h1>Search Schedules</h1>
           
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <table style="width: 95%;">
                   <tr>
                    <td>
                      <div class="input-field">
                            <label>Date</label>
                            <input type="date" name="search_text" placeholder="Date">
                        </div>
                      </td>
                      <td>
                        <input type="submit" class="button" value="Search" name="Search" >
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
    </section></br>
            
        <section class="table-wrap" >
        <div class="table-container">
        <div class="search">
        <h1>Schedule Management<span class="dashboard-stat" style="font-size: 25px; justify-content:right;" ><a href='add_schedules'><button class='button'>Add</button></a></span></h1>
        <hr><br>
                <?php if (empty($data['schedules'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No schedules are available</p>
                    </div>
                <?php else: ?>
                <table class="table" id="schedule-table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Doctor Name</th>
                            <th style="text-align: center;">Specialization</th>
                            <th style="text-align: center;">Room Name</th>
                            <th style="text-align: center;">Day of Week</th>
                            <th style="text-align: center;">Time Slot</th>
                            <th style="text-align: center;">Edit</th>
                            <th style="text-align: center;">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['schedules'] as $schedule) : ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $schedule->First_Name . ' ' . $schedule->Last_Name; ?></td>
                                <td style="text-align: center;"><?php echo $schedule->Specialization; ?></td>
                                <td style="text-align: center;"><?php echo $schedule->Room_Name; ?></td>
                                <td style="text-align: center;"><?php echo $schedule->Day_of_Week; ?></td>
                                <td style="text-align: center;"><?php echo $schedule->Time_Start . ' - ' . $schedule->Time_End; ?></td>
                                <td style="text-align: center;"><a href="<?php echo URLROOT; ?>/manager/edit_schedule?id=<?php echo $schedule->Schedule_ID; ?>"><button class='button'>Edit</button></a></td>
                                <td style="text-align: center;"><a href="<?php echo URLROOT; ?>/manager/remove_schedule?id=<?php echo $schedule->Schedule_ID; ?>"><button class='button red remove'>Remove</button></a></td>
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
            $('#schedule-table').dataTable({
                "bPaginate": false, // Disable pagination
                "bFilter": false, // Disable search/filtering
                "bInfo": false, // Disable info text
                "columnDefs": [
                    { "targets": [5, 6], "orderable": false }
                ]
            });
        });
    </script>
  </body>
  </html>