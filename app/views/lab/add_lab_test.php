<?php 
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
    <title><?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style.css" />
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
              <a href="../users/landing" class="link flex">
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

    <!--<div class="content">
    <div class="container-signup" >
    <header>Add Test</header>
    <form action="<?php echo URLROOT; ?>/lab/add_lab_test" method="POST" style="height:300px; width:500px; border-radius: 10px;">
    <div class="form first">
        <div class="details personal">
            <span class="title">Test Details</span>
            <div class="fields">
                <div class="input-field" style="width: calc(50% - 15px); margin-right: 10px;">
                <label>Test Name*</label>
                        <input type="text" placeholder="Enter test name" name="testname" value="<?php echo $data['T_name'] ?>" required>
                        
                </div>
                    
                <div class="input-field" style="width: calc(50% - 15px);">
                <label>Test Type*</label>
                        <select name="testtype" required>
                            <option selected value="<?php echo $data['T_type'] ?>"><?php echo ($data['T_type'] == '') ? 'Select test type' : $data['T_type'] ?></option>
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
                      
                <div class="input-field" style="width: calc(50% - 15px);">
                    <label>Price*</label>
                    <input type="text" placeholder="Price" name="price" value="<?php echo $data['Price'] ?>" required>
                </div>
            </div>
        </div>
                      
        <div class="buttons">
            <button type="reset" onclick="window.history.back()" >
                <span class="btnText">Back</span>
            </button>
            <button class="submit" type="submit">
                <span class="btnText">Add</span>
            </button>
        </div>
    </div>
</form>

          </div>
</div>-->

<div class="content">
    <div class="container-signup">
        <header>Add Test</header>
        <form action="<?php echo URLROOT; ?>/lab/add_lab_test" method="POST" style="height:300px; width:500px; border-radius: 10px;">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Test Details</span>
                    <div class="fields">
                        <div class="input-field" style="width: calc(50% - 15px); margin-right: 10px;">
                            <label>Test Name*</label>
                            <input type="text" placeholder="Enter test name" name="testname" required>
                        </div>
                        <div class="input-field" style="width: calc(50% - 15px);">
                            <label>Test Type*</label>
                            <select name="testtype" required>
                                <option value="">Select test type</option>
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
                        <div class="input-field" style="width: calc(50% - 15px);">
                            <label>Price*</label>
                            <input type="text" placeholder="Price" name="price" required>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button type="reset" onclick="window.history.back()">
                        <span class="btnText">Back</span>
                    </button>
                    <button class="submit" type="submit">
                        <span class="btnText">Add</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>



</body>
</html>

          