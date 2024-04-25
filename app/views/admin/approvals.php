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
    <title><?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
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
            <li class="item active">
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
                <i class="uil uil-stethoscope"></i>
                <span>Hospital Management</span>
              </a>
            </li>
            <li class="item">
              <a href="../admin/reservations" class="link flex">
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
              <a href="#" class="link flex">
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
                <h1>Doctor Approvals</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>NIC</th>
                            <th>SLMC Reg No</th>
                            <th>Approve</th>
                            <th>Decline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dr. M.S. Perera</td>
                            <td>Gastroenterologist</td>
                            <td>892382331v</td>
                            <td>No.12/2, Jaya Rd., Colombo</td>
                            <td><a href=''><button class='button'>Approve</button></a></td>
                            <td><a href=''><button class='button red'>Decline</button></a></td>
                        </tr>
                        <tr>
                            <td>Dr. M.S. Perera</td>
                            <td>Gastroenterologist</td>
                            <td>892382331v</td>
                            <td>No.12/2, Jaya Rd., Colombo</td>
                            <td><a href=''><button class='button'>Approve</button></a></td>
                            <td><a href=''><button class='button red'>Decline</button></a></td>
                        </tr>
                        <tr>
                            <td>Dr. M.S. Perera</td>
                            <td>Gastroenterologist</td>
                            <td>892382331v</td>
                            <td>No.12/2, Jaya Rd., Colombo</td>
                            <td><a href=''><button class='button'>Approve</button></a></td>
                            <td><a href=''><button class='button red'>Decline</button></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Hospital Approvals</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Registration No</th>
                            <th>Address</th>
                            <th>Region</th>
                            <th>Approve</th>
                            <th>Decline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Asiri Hospitals - Panadura</td>
                            <td>AS0832</td>
                            <td>No.12/2, Jaya Rd., Panadura</td>
                            <td>Kalutara</td>
                            <td><a href=''><button class='button'>Approve</button></a></td>
                            <td><a href=''><button class='button red'>Decline</button></a></td>
                        </tr>
                        <tr>
                            <td>Asiri Hospitals - Panadura</td>
                            <td>AS0832</td>
                            <td>No.12/2, Jaya Rd., Panadura</td>
                            <td>Kalutara</td>
                            <td><a href=''><button class='button'>Approve</button></a></td>
                            <td><a href=''><button class='button red'>Decline</button></a></td>
                        </tr>
                        <tr>
                            <td>Asiri Hospitals - Panadura</td>
                            <td>AS0832</td>
                            <td>No.12/2, Jaya Rd., Panadura</td>
                            <td>Kalutara</td>
                            <td><a href=''><button class='button'>Approve</button></a></td>
                            <td><a href=''><button class='button red'>Decline</button></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
  </body>
</html>