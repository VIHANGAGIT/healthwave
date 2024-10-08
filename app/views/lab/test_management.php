<?php 
  if(($_SESSION['userType']) != 'Lab Assistant'){
    redirect("users/login");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME; ?>: Test Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
  </head>
  <body>
    <script src="<?php echo URLROOT;?>/js/tablesort.js"></script>
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
              <a href="../users/landing" class="link flex">
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
              <a href="../lab/test_appt_management" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Reservations</span>
              </a>
            </li>
            <li class="item active">
              <a href="../lab/test_management" class="link flex">
                <i class="uil uil-heart-rate"></i>
                <span>Test Management</span>
              </a>
            </li>
            <li class="item">
              <a href="../lab/test_result_upload" class="link flex">
                <i class="uil uil-upload"></i>
                <span>Results Upload</span>
              </a>
            </li>
            <li class="item">
              <a href="../lab/completed_tests" class="link flex">
              <i class="uil uil-file-check-alt"></i>
                <span>Completed Tests</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="../lab/profile" class="link flex">
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
      <div class="content-search">
        <div class="search">
          <h2>Test Search</h2>
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <table style="width: 95%;" >
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Test ID</label>
                            <input type="text" name="T_ID" placeholder="Enter Test ID" style="margin: 0%;" >
                        </div>
                      </td>
                      <td>
                        <div class="input-field">
                            <label>Test Name</label>
                            <input type="text" name="T_Name" placeholder="Enter Test Name" style="margin: 0%;" >
                        </div>
                      </td>
                      <td>
                        <input type="submit" class="button" value="Search" name="search" >
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input-field">
                          <label>Test Type</label>
                          <select name="T_Type" required>
                              <option disabled selected>Select Test Type</option>
                              <?php foreach($data['types'] as $testType) : ?>
                                  <option value="<?php echo $testType; ?>"><?php echo $testType; ?></option>
                              <?php endforeach; ?>
                              </select>
                        </div>
                      </td>
                      <td>
                      </td>
                      <td>
                        <button class="button" style="background-color: red;" onclick="window.location.reload()" >Reset</button></a>
                      </td>
                    </tr>
                  </table>
                  <br>
                </div>
              </form>
          </div>
        </div>
        </section>
        <br>

        <!--test list table-->
        
        <section class="table-wrap" >
            <div class="table-container">
            <h1>Add Reservation<span class="dashboard-stat" style="font-size: 25px; justify-content: right;" ><a href='../lab/add_lab_test'><button class='button'>Add</button></a></span></h1>
            <hr><br>
              <?php if (empty($data['tests'])): ?>
                    <div class="error-msg">
                        <div class="error-icon"><i class="uil uil-exclamation-circle"></i></div>
                        <p>No tests are available</p>
                    </div>
                <?php else: ?>
                <table class="table table-sort" id="hospital-test-table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Test ID</th>
                            <th style="text-align: center;">Test Name</th>
                            <th style="text-align: center;">Type</th>
                            <th style="text-align: center;">Price</th>
                            <th style="text-align: center;">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data['tests'] as $test): ?>
                      <tr>
                            <td style="text-align: center;"><?php echo $test->Test_ID?></td>
                            <td style="text-align: center;"><?php echo $test->Test_Name?></td>
                            <td style="text-align: center;"><?php echo $test->Test_Type?></td>
                            <td style="text-align: center;"><?php echo $test->Price?></td>
                            <td style="text-align: center;">
                            <a href='remove_test?test_id=<?php echo $test->Test_ID; ?>' onclick="confirmRemove(event)">
                                <button class='button red remove' <?php echo ($test->Cancel == 'Not allowed') ? 'disabled' : '' ?> >Remove</button>
                            </a>
                            </td>
                        </tr>
                    <?php endforeach;?>     
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <br>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#hospital-test-table').dataTable({
                "bPaginate": false, // Disable pagination
                "bFilter": false, // Disable search/filtering
                "bInfo": false, // Disable info text
                "columnDefs": [
                    { "targets": [4], "orderable": false }
                ]
            });
        });
    </script>
    <script>
        function confirmRemove(event) {
            event.preventDefault(); // Prevent the default action of the link
            
            // Display a confirmation dialog
            if (window.confirm('Are you sure you want to remove?')) {
                // If confirmed, proceed with the removal action
                window.location.href = event.target.closest('a').href;
            } else {
                // If not confirmed, do nothing
                return false;
            }
        }
    </script>
  </body>
</html>