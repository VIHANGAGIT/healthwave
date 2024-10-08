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
    <title><?php echo SITENAME; ?>: Doctor Management</title>
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
            <li class="item active">
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
              <a href="../admin/profile" class="link flex">
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
        <div class="content-search">
              <div class="search">
                <h2>Doctor Search</h2>
                  <form style="width: 100%;" method="POST">
                    <div class="fields">
                      <table style="width: 95%;">
                        <tr>
                          <td>
                            <div class="input-field">
                                <label>Doctor Name</label>
                                <input type="text" name="doctor_name" placeholder="Doctor Name" style="margin: 0%;" >
                            </div>
                          </td>
                          <td>
                            <div class="input-field">
                              <label>Hospital Name</label>
                              <select name="hospital_name" >
                                <option disabled selected>Select Hospital</option>
                                <?php foreach ($data['hospitals'] as $hospital): ?>
                                  <option value="<?php echo $hospital->Hospital_ID; ?>"><?php echo $hospital->Hospital_Name; ?></option>
                                <?php endforeach; ?> 
                              </select>
                            </div>
                          </td>
                          <td>
                            <input type="submit" class="button" value="Search" name="search" >
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="input-field">
                                <label>Specialization</label>
                                <select name="specialization" >
                                  <option disabled selected>Select Specialization</option>
                                  <?php foreach ($data['specializations'] as $specialization): ?>
                                    <option value="<?php echo $specialization; ?>"><?php echo $specialization; ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>
                          </td>
                          <td>
                            <div class="input-field">
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
            <h1>Doctor Management<span class="dashboard-stat" style="font-size: 25px; justify-content: right;" ><a href='add_doctor'><button class='button'>Add Doctor</button></a></span></h1>
            <hr><br>
                <?php if (empty($data['doctors'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No doctors are available</p>
                    </div>
                <?php else: ?>
                <table  id="myTable" class="table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Doctor ID</th>
                            <th style="text-align: center;">Doctor Name</th>
                            <th style="text-align: center;">Specialization</th>
                            <th style="text-align: center;">NIC</th>
                            <th style="text-align: center;">SLMC Reg No</th>
                            <th style="text-align: center;">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data['doctors'] as $doctor): ?>
                      <tr>
                        <td style="text-align: center;"><?php echo $doctor->Doctor_ID; ?></td>
                        <td style="text-align: center;"><?php echo $doctor->First_Name . " " . $doctor->Last_Name; ?></td>
                        <td style="text-align: center;"><?php echo $doctor->Specialization; ?></td>
                        <td style="text-align: center;"><?php echo $doctor->NIC; ?></td>
                        <td style="text-align: center;"><?php echo $doctor->SLMC_Reg_No; ?></td>
                        <td style="text-align: center;">
                        <a href="#" onclick="confirmRemove('<?php echo $doctor->Doctor_ID; ?>')">
                          <button class='button red remove' <?php echo ($doctor->Cancel == 'Not allowed') ? 'disabled' : '' ?> >Remove</button>
                        </a>
                      </td>

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
          $('#myTable').dataTable( {
              "bPaginate": false,
              "bFilter": false,
              "bInfo": false,
              "columnDefs": [
                {"targets": [5], "orderable": false}, // Disable ordering on the last column
              ]
                    
          } );
      } );
    </script> 
    <script>
      function confirmRemove(doctorId) {
        if (confirm('Are you sure you want to remove?')) {
          // If user confirms, redirect to the remove doctor page
          window.location.href = 'remove_doctor?doc_id=' + doctorId;
        } else {
          // If user cancels, do nothing
          return false;
        }
      }
    </script>
  </body>
</html>