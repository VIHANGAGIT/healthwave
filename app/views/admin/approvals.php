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
    <title><?php echo SITENAME; ?>: Approvals</title>
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
                <h1>Doctor Approvals</h1>
                <hr><br>
                <?php if (empty($data['doctors'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No pending approvals at the moment</p>
                    </div>
                <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>SLMC Reg No</th>
                            <th>NIC</th>
                            <th>Contact No</th>
                            <th>Approve</th>
                            <th>Decline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['doctors'] as $doctor) : ?>
                            <tr>
                                <td><?php echo $doctor->First_Name . ' ' . $doctor->Last_Name; ?></td>
                                <td><?php echo $doctor->Specialization; ?></td>
                                <td><?php echo $doctor->SLMC_Reg_No; ?></td>
                                <td><?php echo $doctor->NIC; ?></td>
                                <td><?php echo $doctor->Contact_No; ?></td>
                                <td><button class='button' onclick="confirmApproval('<?php echo URLROOT; ?>/admin/approve?id=<?php echo $doctor->Doctor_ID; ?>&email=<?php echo $doctor->Username; ?>&type=doctor')">Approve</button></td>
                                <td><button class='button red remove' onclick="confirmDecline('<?php echo URLROOT; ?>/admin/decline?id=<?php echo $doctor->Doctor_ID; ?>&email=<?php echo $doctor->Username; ?>&type=doctor')">Decline</button></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section>
        <br>
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Hospital Manager Approvals</h1>
                <hr><br>
                <?php if (empty($data['managers'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No pending approvals at the moment</p>
                    </div>
                <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Hospital</th>
                            <th>Hospital Region</th>
                            <th>NIC</th>
                            <th>Contact No</th>
                            <th>Current Manager</th>
                            <th>Approve</th>
                            <th>Decline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['managers'] as $manager) : ?>
                            <tr>
                                <td><?php echo $manager->First_Name . ' ' . $manager->Last_Name; ?></td>
                                <td><?php echo $manager->Hospital_Name; ?></td>
                                <td><?php echo $manager->Region; ?></td>
                                <td><?php echo $manager->NIC; ?></td>
                                <td><?php echo $manager->Contact_No; ?></td>
                                <td><?php echo empty($manager->Current_Manager) ? 'No' : 'Yes' ?></td>
                                <td><button class='button' onclick="confirmApproval('<?php echo URLROOT; ?>/admin/approve?id=<?php echo $manager->HS_ID; ?>&email=<?php echo $manager->Username; ?>&type=manager&current=<?php echo $manager->Current_Manager; ?>')">Approve</button></td>
                                <td><button class='button red remove' onclick="confirmDecline('<?php echo URLROOT; ?>/admin/decline?id=<?php echo $manager->HS_ID; ?>&email=<?php echo $manager->Username; ?>&type=manager')">Decline</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <script>
        function confirmApproval(approvalUrl) {
            if (confirm("Are you sure you want to approve?")) {
                window.location.href = approvalUrl;
                // Show success alert
                setTimeout(function() {
                    alert("Approval successful!");
                }, 500);
            }
        }

        function confirmDecline(declineUrl) {
          if (confirm("Are you sure you want to decline?")) {
              window.location.href = declineUrl;
              // Show success alert
              setTimeout(function() {
                  alert("Decline successful!");
              }, 500); // Delay the alert
          }
        }
    </script>
  </body>
</html>