<?php 
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  if(($_SESSION['userType']) != 'Patient'){
    redirect("users/login");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME; ?>: Profile</title>
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
              <a href="../patient/doc_booking" class="link flex">
                <i class="uil uil-stethoscope"></i>
                <span>Doctor Booking</span>
              </a>
            </li>
            <li class="item">
              <a href="../patient/test_booking" class="link flex">
                <i class="uil uil-heart-rate"></i>
                <span>Lab Test Booking</span>
              </a>
            </li>
            <li class="item">
              <a href="../patient/reservations" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Reservations</span>
              </a>
            </li>
            <li class="item">
              <a href="../patient/medical_records" class="link flex">
                <i class="uil uil-file-alt"></i>
                <span>Medical History</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item active">
              <a href="../patient/profile" class="link flex">
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
    <div class="profile-content">
      <div class="profile-card">
        <div class="pr-image">
          <img src="<?php echo URLROOT;?>/img/profile.png" alt="" class="prof-image">
        </div>

        <div class="profile-text">
          <span class="profile-name"><?php echo $data['First_Name'] . ' ' . $data['Last_Name']?></span>
          <span class="profile-role"><?php echo $_SESSION['userType'] ?></span>
        </div>

        <div class="profile-details">
          <span class="profile-detail"><strong>Gender: </strong><?php echo $data['Gender'] ?></span>
          <span class="profile-detail"><strong>NIC: </strong> <?php echo $data['NIC'] ?></span>
          <span class="profile-detail"><strong>Contact Number: </strong><?php echo $data['C_Num'] ?></span>
          <span class="profile-detail"><strong>Email: </strong><?php echo $data['Email'] ?></span>
          <span class="profile-detail"><strong>Height: </strong><?php echo $data['Height'] ?> cm</span>
          <span class="profile-detail"><strong>Weight: </strong><?php echo $data['Weight'] ?> kg</span>
          <span class="profile-detail"><strong>Allergies: </strong><?php echo $data['Allergies'] ?></span>
        </div>

        <div class="profile-btns">
          <a href='profile_update'><button class="profile-btn">Update</button></a>
          <a href='profile_delete'><button class="profile-delete" onclick="confirmRemove(event)" >Delete</button></a>
        </div>
      </div>
    </div>
    <script>
      function confirmRemove(event) {
          event.preventDefault();
          
          // Display a confirmation dialog
          if (window.confirm('Are you sure you want to remove your account? All your existing appointments will be cancelled.')) {
              // If confirmed, proceed with the removal action
              window.location.href = event.target.closest('a').href;
          } else {
              return false;
          }
      }
    </script>
  </body>
</html>