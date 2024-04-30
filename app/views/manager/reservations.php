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
    <title><?php echo SITENAME; ?>: Hospital Reservations</title>
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
            <li class="item active">
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

    <div class="content">
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Doctor Appointments Management</h1>
                <hr><br>
                <?php if (empty($data['doc_reservations'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No appointments for hospital.</p>
                    </div>
                <?php else: ?>
                    <table class="table" id="appointment-table" >
                        <thead>
                            <tr>
                                <th style="text-align: center;" >Res. ID</th>
                                <th style="text-align: center;" >Patient Name</th>
                                <th style="text-align: center;" >Doctor Name</th>
                                <th style="text-align: center;" >Hospital</th>
                                <th style="text-align: center;" >Date</th>
                                <th style="text-align: center;" >Appt. No</th>
                                <th style="text-align: center;" >Edit</th>
                                <th style="text-align: center;" >Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['doc_reservations'] as $appointment): ?>
                                <tr>
                                    <td style="text-align: center;" ><?php echo $appointment->Doc_Res_ID; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->First_Name. ' ' . $appointment->Last_Name; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Doc_First_Name. ' ' . $appointment->Doc_Last_Name; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Hospital_Name; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Date; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Appointment_No ?></td>
                                    <td style="text-align: center;" ><a href='edit_reservation?res_id=<?php echo $appointment->Doc_Res_ID; ?>'><button class='button' style="width: 60px;"><i class="uil uil-pen"></i></button></a></td>
                                    <td style="text-align: center;" ><a href='remove_reservation?res_id=<?php echo $appointment->Doc_Res_ID; ?>' onclick="confirmRemove(event)"><button class='button remove'style="width: 60px;"><i class="uil uil-trash-alt"></i></button></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <!-- <table class="table">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                         <tr>
                            <td>A.V. Tony Stark</td>
                            <td>Dr. M.S. Perera</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>A.V. Tony Stark</td>
                            <td>Dr. M.S. Perera</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>A.V. Tony Stark</td>
                            <td>Dr. M.S. Perera</td>
                            <td>Lanka Hospitals - Kiribathgoda</td>
                            <td>2023/10/12</td>
                            <td>10:30 AM</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                    </tbody>
                </table> -->
            </div>
        </section>
        <br>
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Test Appointments Management</h1>
                <hr><br>
                <?php if (empty($data['test_reservations'])): ?>
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
                                <th style="text-align: center;" >Edit</th>
                                <th style="text-align: center;" >Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['test_reservations'] as $appointment): ?>
                                <tr>
                                    <td style="text-align: center;" ><?php echo $appointment->Test_Res_ID; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->First_Name. ' ' . $appointment->Last_Name; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Test_Name; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Hospital_Name; ?></td>
                                    <td style="text-align: center;" ><?php echo $appointment->Date; ?></td>
                                    <td style="text-align: center;" ><a href='edit_test_reservation?res_id=<?php echo $appointment->Test_Res_ID; ?>'><button class='button' style="width: 60px;"><i class="uil uil-pen"></i></button></a></td>
                                    <td style="text-align: center;" ><a href='remove_test_reservation?res_id=<?php echo $appointment->Test_Res_ID; ?>' onclick="confirmRemove(event)" ><button class='button remove'style="width: 60px;"><i class="uil uil-trash-alt"></i></button></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </section>
    </div>
  </body>
</html>