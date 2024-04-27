<?php 
  session_start();
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
            <li class="item active">
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
              <a href="../manager/Schedules" class="link flex">
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

    <!--Search box-->
    <div class="content">
    <div class="content-search">
        <div class="search">
          <h2>Lab Test Management<span class="dashboard-stat" style="font-size: 25px; justify-content: right;" ><a href='#'><button id="addLabTestButton" class='button'>Add Lab Test</button></a></span></h2>
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <table style="width: 95%;" >
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Test ID</label>
                            <input type="text" name="search_text" placeholder="Test ID">
                        </div>
                      </td>
                      <td>
                        <div class="input-field">
                            <label>Test Name</label>
                            <input type="text" name="search_text" placeholder="Test Name">
                        </div>
                      </td>
                      <td>
                        <input type="submit" class="button" value="Search" name="search" >
                      </td>
                    </tr>
                  </table>
                </div>
              </form>
          </div>
          
        </div>

        <div class="popup">
          <div class="popup-content">
            <img src="<?php echo URLROOT;?>/img/cross.png" alt="close" class="close">
            <header>Add New Lab Test</header>
            <form action="<?php echo URLROOT; ?>/lab/add_test" method="post">
              <div class="form-first">
                <div class="details-labtest">
                  
                  <span class="title">Test details</span>
                  
                  <div class="fields">

                    <div class="input-field">
                      <label>Hospital ID</label>
                      <input type="text" placeholder="Enter Hospital ID" name="Hospital_ID"   required>
                    </div> 

                    <div class="input-field">
                      <label>Test name</label>
                      <input type="text" placeholder="Enter test name" name="Test_Name" required>
                    </div>

                    <div class="input-field">
                      <label>Type</label>
                      <input type="text" placeholder="Enter type" name="Type"  required>
                    </div>

                    <div class="input-field">
                      <label>Price</label>
                      <input type="float" placeholder="Enter price" name="Price" required>
                    </div>


                  </div>

                  <input type="submit" class="button" value="Submit" name="Submit" >

                </div>
              </div>
            </form>

            
            
          </div> 
        </div> 
        
        <script>
          document.getElementById("addLabTestButton").addEventListener("click", function(){
          document.querySelector(".popup").style.display = "flex";
          });

          document.querySelector(".close").addEventListener("click", function(){
          document.querySelector(".popup").style.display = "none";
          });
        </script>

        <br> 

        <!--test list table-->
        
        <section class="table-wrap" >
            <div class="table-container">
                <table class="table table-sort">
                    <thead>
                        <tr>
                            <th>Test ID</th>
                            <th>Test Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Edit</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data['tests'] as $test): ?>
                      <tr>
                            <td style="text-align: center;"><?php echo $test->Test_ID?></td>
                            <td style="text-align: center;"><?php echo $test->Test_Name?></td>
                            <td style="text-align: center;"><?php echo $test->Test_Type?></td>
                            <td style="text-align: center;"><?php echo $test->Price?></td>
                            <td><a href='#'><button id="Edit" class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                    <?php endforeach;?>

                      

                    
                        <!--<tr>
                            <td>T114</td>
                            <td>Dengue Antigen</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href='#'><button id="Edit" class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T115</td>
                            <td>ECG</td>
                            <td>ECG</td>
                            <td>Rs. 3000.00</td>
                            <td><a href='#'><button id="Edit" class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T116</td>
                            <td>Fasting Blood Sugar</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href='#'><button id="Edit" class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T117</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href='#'><button id="Edit" class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T118</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href='#'><button id="Edit" class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T119</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href='#'><button id="Edit" class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>-->
                    </tbody>
                </table>
                
                
            </div>
        </section>
    </div>
  </body>
</html>

    <!--<div class="content">
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Lab Test Management</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Test ID</th>
                            <th>Test Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>

                    

                        <tr>
                            <td>T112</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T112</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T112</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T112</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T112</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T112</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T112</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>T112</td>
                            <td>Complete Blood Count (CBC)</td>
                            <td>Blood Test</td>
                            <td>Rs. 1500.00</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
  </body>
</html>