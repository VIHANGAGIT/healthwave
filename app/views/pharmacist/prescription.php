<?php 
  if(($_SESSION['userType']) != 'Pharmacist'){
    redirect("users/login");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME; ?>: Prescription View</title>
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
              <a href="" class="link flex">
                <i class="uil uil-estate"></i>
                <span>Home</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item active">
              <a href="../pharmacist/prescription" class="link flex">
                <i class="uil uil-file-medical"></i>
                <span>Prescription</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="../pharmacist/profile" class="link flex">
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
        <div class="content-search" style="height: 180px;">
          <div class="search">
            <h2 style="color: black;">Prescription Search</h2>
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <table style="width: 95%;" >
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Prescription ID</label>
                            <input type="text" name="pres_id" placeholder="Reservation ID" style="margin: 0%;" >
                        </div>
                      </td>
                      <td>
                        <div class="input-field">
                            <label>Patient Name</label>
                            <input type="text" name="patient_name" placeholder="Patient Name" style="margin: 0%;" >
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
        <div class="detail-wrapper">
            <?php if (empty($data['prescriptions'])): ?>
                <div class="error-msg" style="border-color: #4070f4;">
                    <div class="error-icon"><i class="uil uil-exclamation-circle" style="color: #4070f4;"></i></div>
                    <p>No prescriptions to show</p>
                </div>
            <?php else: ?>
              <?php foreach ($data['prescriptions'] as $prescription): ?>
                <div class='detail-card'>
                  <div class='detail-card-content'>
                    <p class="detail-title">Patient: <?php echo $prescription->First_Name . ' ' . $prescription->Last_Name;?></p>
                    <p class='detail-comp'>Pres ID: <?php echo $prescription->Prescription_ID;?>  | Doctor: <?php echo $prescription->Doc_First_Name. " ".$prescription->Doc_Last_Name;?> </p>
                  </div>
                  <div class='detail-card-sub'>
                  <hr class="vertical-line">
                      <div class='detail-card-info'>
                          <p>Status :</p>
                          <p class="detail-location" ><?php echo $prescription->Status;?></p>
                      </div>
                  </div>
                  <div class='detail-view'>
                  <a href='view_prescription?id=<?php echo $prescription->Prescription_ID ?>'><button class="button" style="width: 50px; margin-right: -15px;  margin-top: 16px;"><i class="uil uil-import"></i></button></a>
                  <a href='complete_prescription?id=<?php echo $prescription->Prescription_ID ?>'><button class='button detail-btn' style="width: 160px;" <?php echo  $prescription->Status != 'Not Claimed'  ? 'disabled' : '' ?> >Completed</button></a>
                  </div>
                </div>
              <?php endforeach;?>  
            <?php endif; ?>
        </div>
        
    </div>
  </body>
</html>