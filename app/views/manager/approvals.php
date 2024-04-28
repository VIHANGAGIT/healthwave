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
            <li class="item">
              <a href="../manager/dashboard" class="link flex">
                <i class="uil uil-chart-line"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="item active">
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
                <h1>Lab Assistant Approvals</h1>
                <hr><br>
                <?php if (empty($data['lab'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No pending approvals at the moment</p>
                    </div>
                <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>NIC</th>
                            <th>Gender</th>
                            <th>Contat No</th>
                            <th>Approve</th>
                            <th>Decline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['lab'] as $lab) : ?>
                            <tr>
                                <td><?php echo $lab->First_Name . ' ' . $lab->Last_Name; ?></td>
                                <td><?php echo $lab->NIC; ?></td>
                                <td><?php echo $lab->Gender; ?></td>
                                <td><?php echo $lab->Contact_No; ?></td>
                                <td><button class='button' onclick="confirmApproval('<?php echo URLROOT; ?>/manager/approve?id=<?php echo $lab->HS_ID; ?>&email=<?php echo $lab->Username; ?>&type=lab')">Approve</button></td>
                                <td><button class='button red remove' onclick="confirmDecline('<?php echo URLROOT; ?>/manager/decline?id=<?php echo $lab->HS_ID; ?>&email=<?php echo $lab->Username; ?>&type=lab')">Decline</button></td>

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
                <h1>Pharmacist Approvals</h1>
                <hr><br>
                <?php if (empty($data['pharmacist'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No pending approvals at the moment</p>
                    </div>
                <?php else: ?>
                <table class="table">
                <thead>
                        <tr>
                            <th>Name</th>
                            <th>NIC</th>
                            <th>Gender</th>
                            <th>Contat No</th>
                            <th>Approve</th>
                            <th>Decline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['pharmacist'] as $pharmacist) : ?>
                            <tr>
                                <td><?php echo $pharmacist->First_Name . ' ' . $pharmacist->Last_Name; ?></td>
                                <td><?php echo $pharmacist->NIC; ?></td>
                                <td><?php echo $pharmacist->Gender; ?></td>
                                <td><?php echo $pharmacist->Contact_No; ?></td>
                                <td><button class='button' onclick="confirmApproval('<?php echo URLROOT; ?>/manager/approve?id=<?php echo $pharmacist->HS_ID; ?>&email=<?php echo $pharmacist->Username; ?>&type=pharm')">Approve</button></td>
                                <td><button class='button red remove' onclick="confirmDecline('<?php echo URLROOT; ?>/manager/decline?id=<?php echo $pharmacist->HS_ID; ?>&email=<?php echo $pharmacist->Username; ?>&type=pharm')">Decline</button></td>

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