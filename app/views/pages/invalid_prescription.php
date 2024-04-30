
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME; ?>: Invalid Prescription</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <img src="<?php echo URLROOT;?>/img/logo.png" alt=""> <span style="font-weight: 500;">HealthWave</span>
      </div>
      <div class="navbar_content">
        <i class='uil uil-sun' id="darkLight"></i>
        <!-- <a href='../users/logout'><button class='button'>Logout</button></a> -->
      </div>
    </nav>

    <div class="content-static">
      <div class="content-404">
        <div class="payment">
          <img src="<?php echo URLROOT;?>/img/test_invalid.png" alt="" style="width: 700px;">
          <h1>Invalid Prescription!</h1>
          <br>
          <div class="text404">
            <p>Hmm.. Looks like that prescription is not valid.</p>
          </div>
          <br><br>
        </div>
      </div>
    
    </div>

  </body>
</html>

