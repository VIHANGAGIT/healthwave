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

   <title><?php echo SITENAME?>: Edit Test</title>
</head>
<body>
    <div class="container-signup" style="height: 350px; overflow: hidden;" >
        <header>Edit Test</header>

        <form action="<?php echo URLROOT; ?>/admin/update_test" method="POST" style="height: 600px;">
            <div class="form first" >
                <div class="details personal">
                    <span class="title">Test Details</span>

                    <input type="hidden" name="testid" value="<?php echo $data['ID'] ?>">

                    <div class="fields">
                        <div class="input-field" style="width: calc(50% - 10px); margin-right: 10px;">
                            <label>Test Name*</label>
                            <input type="text" placeholder="Enter test name" name="testname" value="<?php echo $data['T_name'] ?>" class="<?php echo (!empty($data['T_name_err'])) ? 'error' : '' ?>" required>
                            <span class="err-msg"><?php echo $data['T_name_err']; ?></span>
                        </div>
                        <div class="input-field" style="width: calc(50% - 10px);">
                            <label>Test Type*</label>
                            <select name="testtype" class="<?php echo (!empty($data['T_type_err'])) ? 'error' : '' ?>" required>
                            <option selected value=" <?php echo $data['T_type'] ?>" > <?php echo ($data['T_type'] == '') ? 'Select test type' : $data['T_type'] ?></option>
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
                            <span class="err-msg"><?php echo $data['T_type_err']; ?></span>
                        </div>
                    </div>
                </div>

                    <div class="buttons">
                    <button type="button" onclick="window.history.back()" style="width: calc(50% - 10px);">
                            <span class="btnText">Back</span>
                        </button>
                        
                        <button class="sumbit" style="width: calc(50% - 10px);  margin-left: 15px;">
                            <span class="btnText">Submit</span>
                        </button>
                    </div>
                </div>
        </form>
    </div>

    <script src="<?php echo URLROOT; ?>/js/signup.js"></script>
</body>
</html>