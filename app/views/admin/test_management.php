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
        <a><a href='../users/logout'><button class='button'>Logout</button></a></a>
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
            <!-- <li class="item">
              <a href="#" class="link flex">
                <i class="uil uil-info-circle"></i>
                <span>About Us</span>
              </a>
            </li> -->
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
            <li class="item">
              <a href="../admin/doc_management" class="link flex">
                <i class="uil uil-stethoscope"></i>
                <span>Doctor Management</span>
              </a>
            </li>
            <li class="item active">
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
            <li class="item">
              <a href="../admin/profile" class="link flex">
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
    <div class="content-search">
          <div class="search">
            <h2>Test Search</h2>
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <table style="width: 95%;">
                    <tr>
                      <td>
                        <div class="input-field">
                        <label>Test ID</label>
                        <input type="text" name="search_text" placeholder="Enter test id">
                        </div>
                      </td>
                      <td>
                        <div class="input-field">
                          <label>Test Type</label>
                          <select required>
                              <option disabled selected>Select Test Type</option>
                              <option>Blood Test</option>
                                <option>CT Scan</option>
                                <option>Urine Test</option>
                                <option>MRI Scan</option>
                                <option>ECG</option>
                                <option>Endoscopy</option>
                                <option>Colonoscopy</option>
                                <option>Biopsy</option>
                                <option>Ultrasound</option>
                                <option>X-Ray</option>
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
                        <label>Test Name</label>
                        <input type="text" name="search_text" placeholder="Test Name">
                        </div>
                      </td>
                      <td>
                     
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
                <h1>Lab Test Management<span class="dashboard-stat" style="font-size: 25px; justify-content: right;" ><a href='add_test'><button class='button'>Add Test</button></a></span></h1>
                <table id="myTable" class="table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Test ID</th>
                            <th style="text-align: center;">Test Name</th>
                            <th style="text-align: center;">Type</th>
                            <th style="text-align: center;">Update Test</th>
                            <th style="text-align: center;">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php foreach($data['tests'] as $test) : ?>
                        <tr>
                          <td style="text-align: center;"><?php echo $test->Test_ID; ?></td>
                          <td style="text-align: center;"><?php echo $test->Test_Name; ?></td>
                          <td style="text-align: center;"><?php echo $test->Test_Type; ?></td>
                          <td style="text-align: center;"><a href="update_test?test_id=<?php echo $test->Test_ID; ?>"><button class="button">Update</button></a></td>
                          <td style="text-align: center;">
                          <a href='remove_test?test_id=<?php echo $test->Test_ID; ?>' onclick="confirmRemove(event)">
                              <button class='button red'>Remove</button>
                          </a>
                      </td>
                        </tr>
                        <?php endforeach; ?>

                      </tbody>
                </table>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').dataTable({
                "bPaginate": false, // Disable pagination
                "bFilter": false, // Disable search/filtering
                "bInfo": false, // Disable info text
                "columnDefs": [
                    { "targets": [3, 4], "orderable": false } // Disable ordering on columns 4 and 5
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