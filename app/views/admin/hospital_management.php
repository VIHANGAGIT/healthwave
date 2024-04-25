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
            <li class="item">
              <a href="../admin/test_management" class="link flex">
                <i class="uil uil-heart-rate"></i>
                <span>Test Management</span>
              </a>
            </li>
            <li class="item active">
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
            <h2>Hospital Search</h2>
              <form style="width: 100%;" method="POST" action="<?php echo URLROOT;?>/admin/hospital_management">
                <div class="fields">
                  <table style="width: 95%;">
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Hospital ID</label>
                            <input type="text" name="H_ID" placeholder="Enter hospital ID" value="<?php echo $data['H_ID'];?>" >
                        </div>
                      </td>
                      <td>
                        <div class="input-field">
                          <label>Hospital Name</label>
                          <select name="H_name" >
                              <option value="" selected>Select Hospital</option>
                              <?php foreach($data['hospitals'] as $hospital): ?>
                              <option value="<?php echo $hospital->Hospital_Name?>" <?php if($hospital->Hospital_Name == $data['H_name']) echo 'selected'; ?> >
                                <?php echo $hospital->Hospital_Name?>
                              </option>
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
                            <label>Reigon</label>
                            <select name="H_region" >
                                <option  selected value="">Select Reigon</option>
                                <option value="Colombo">Colombo</option>
                                <option>Kandy</option>
                                <option>Galle</option>
                                <option>Matara</option>
                                <option>Kurunegala</option>
                                <option>Badulla</option>
                                <option>Anuradhapura</option>
                                <option>Polonnaruwa</option>
                                <option>Trincomalee</option>
                                <option>Jaffna</option>
                                <option>Other</option>
                            </select>
                        </div>
                      </td>
                      <td>
                      <!--<div class="input-field">
                            <label>Date</label>
                            <input type="date" name="search_text" placeholder="Date">
                        </div>-->
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
                <h1>Hospitals Management<span class="dashboard-stat" style="font-size: 25px; justify-content: right;" ><a href='add_hospital'><button class='button'>Add Hospital</button></a></span></h1> 
                <table  id="myTable" class="table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Hospital ID</th>
                            <th style="text-align: center;">Hospital Name</th>
                            <th style="text-align: center;">Address</th>
                            <th style="text-align: center;">Reigon</th>
                            <th style="text-align: center;">Edit</th>
                            <th style="text-align: center;">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data['hospitals'] as $hospital): ?>
    <tr>
        <td style="text-align: center;"><?php echo $hospital->Hospital_ID; ?></td>
        <td style="text-align: center;"><?php echo $hospital->Hospital_Name; ?></td>
        <td style="text-align: center;"><?php echo $hospital->Address; ?></td>
        <td style="text-align: center;"><?php echo $hospital->Region; ?></td>
        <td style="text-align: center;"><a href='edit_hospital?hospital_id=<?php echo $hospital->Hospital_ID; ?>'><button class='button'>Edit</button></a></td>
        <td style="text-align: center;">
        <a href='remove_hospital?hospital_id=<?php echo $hospital->Hospital_ID; ?>' onclick="confirmRemove(event)">
            <button class='button red'>Remove</button>
        </a>
    </td>
    </tr>
<?php endforeach; ?>



                        </tr>
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
                    { "targets": [4, 5], "orderable": false } // Disable ordering on columns 5 and 6
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