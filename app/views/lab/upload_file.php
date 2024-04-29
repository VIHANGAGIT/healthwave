<?php
  if(($_SESSION['userType']) != 'Lab Assistant'){
    redirect("users/login");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title><?php echo SITENAME?>: Upload Results</title>
</head>
<body>
    <div class="container-signup" style="height: 420px; overflow: hidden;">
        <header>Upload Test Result</header>

            <form action="<?php echo URLROOT; ?>/lab/upload_file" method="POST" enctype="multipart/form-data">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Test Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Patient Name*</label>
                            <input type="text" name="patientName" value="<?php echo $data['patientName'] ?>"  required readonly>
                            <input type="hidden" name="resId" value="<?php echo $data['Res_ID'] ?>"  required readonly>
                        </div>
                        <div class="input-field">
                            <label>Test Name*</label>
                            <input type="text" name="testName" value="<?php echo $data['testName'] ?>"  required readonly>
                        </div>
                        <div class="input-field">
                            <label>Test Type*</label>
                            <input type="text" name="testType" value="<?php echo $data['testType'] ?>"  required readonly>
                        </div>
                        <div class="input-field">
                            <label>Test Result*</label>
                            <input type="file" name="file" class="<?php echo (!empty($data['file_err'])) ? 'error' : '' ?>" required>
                            <!-- <span class="err-msg"><?php //echo $data['file_err'] ?></span> -->
                        </div>
                    </div>
                    <div class="buttons">
                        <button type="reset" onclick="window.history.back()" >
                            <span class="btnText">Back</span>
                        </button>
                        
                        <button class="sumbit">
                            <span class="btnText">Upload</span>
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
  </body>
</html>