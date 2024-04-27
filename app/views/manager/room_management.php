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
            <li class="item">
              <a href="../manager/Schedules" class="link flex">
                <i class="uil uil-calender"></i>
                <span>Schedules</span>
              </a>
            </li>
          <li class="item active">
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

    <div class="content">
    <div class="table-wrap" >
    <div class="table-container">
          <div class="search">
            <h1>Room Management<span class="dashboard-stat" style="font-size: 25px; justify-content:right;" ><a href=''><button id="addRoomButton"class='button'>Add</button></a></span></h1>
            <a href="addrooms">
            
              
</div>
</br>

<div class="popup">
          <div class="popup-content">
            <img src="<?php echo URLROOT;?>/img/cross.png" alt="close" class="close">
            <header>Add New Room</header>
            <form action="<?php echo URLROOT; ?>/manager/add_Room" method="post">
              <div class="form-first">
                <div class="details-labtest">
                  
                  <!--<span class="title">Test details</span>-->
                  
                  <div class="fields">

                    <div class="input-field">
                      <label>Room ID</label>
                      <input type="text" placeholder="Enter Room ID" required>
                    </div>

                    <div class="input-field">
                      <label>Room name</label>
                      <input type="text" placeholder="Enter Room name" required>
                    </div>




                  </div>

                  <input type="submit" class="button" value="Submit" name="Submit" >

                </div>
              </div>
            </form>

            
            
          </div> 
        </div> 
        
        <script>
          document.getElementById("addRoomButton").addEventListener("click", function(event){
          event.preventDefault();
          document.querySelector(".popup").style.display = "flex";
          });

          document.querySelector(".close").addEventListener("click", function(event){
          event.preventDefault();
          document.querySelector(".popup").style.display = "none";
          });
        </script>

        <br> 

<div class="table-wrap" >
        <div class="table-container">
               <table class="table">
                    <thead>
                        <tr>
                            <th>Room ID</th>
                            <th>Room Name</th>
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01</td>
                            <td>West-002</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>02</td>
                            <td>West-003</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        <tr>
                            <td>03</td>
                            <td>South-012</td>
                            <td><a href=''><button class='button'>Edit</button></a></td>
                            <td><a href=''><button class='button red'>Remove</button></a></td>
                        </tr>
                        
                        
                       </tbody>
                </table>
            </div>



























    </html>
  
