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
              <a href="../manager/schedules" class="link flex">
                <i class="uil uil-calender"></i>
                <span>Schedules</span>
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
            <li class="item">
              <a href="../manager/notofications" class="link flex">
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
        <h1>Schedules<span class="dashboard-stat" style="font-size: 25px; justify-content:right;" ><a href='addschedules'><button class='button'>Add</button></a></span></h1>
               <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th>Doctor Name</th>
                            <th>Room ID</th>
                            <th>Start Time</th>
                            <th>End time</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>H.A. Weerasinghe</td>
                            <td>01</td>
                            <td>13:00:00</td>
                            <td>13:30:00</td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                        <td>W.P. Krishan Weerasinghe</td>
                            <td>02</td>
                            <td>13:30:00</td>
                            <td>13:45:00</td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                        <td>Tony Stark</td>
                            <td>03</td>
                            <td>14:00:00</td>
                            <td>14:30:00</td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                        <td>H.A. Weerasinghe</td>
                            <td>02</td>
                            <td>13:30:00</td>
                            <td>14:45:00</td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        
                       </tbody>
                </table>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
      <script>
        let table = new DataTable('#myTable');
      </script>
  </body>
  </html>