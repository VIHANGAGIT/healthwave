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
<div class="container-signup" style="height: 350px; overflow: hidden;">
    <header>Edit Test - Hospital</header>

    <form action="<?php echo URLROOT; ?>/manager/edit_test" method="POST" style="height: 500px;">
        <div class="form first">
            <div class="details personal">
                <span class="title">Test Details</span>

                <div class="fields">
                    <div class="input-field" >
                        <label>Test ID*</label>
                        <input type="number" name="test_id" value="<?php echo $data['T_ID'] ?>" required readonly>

                    </div>
                    <div class="input-field" style="width: 30%;">
                        <label>Test*</label>
                        <input type="text" name="test_name" value="<?php echo $data['T_Name'] ?>" required readonly>

                    </div>
                    <div class="input-field" >
                        <label>Test Price*</label>
                        <input type="number" placeholder="Enter test price" name="test_price" value="<?php echo $data['T_price'] ?>" class="<?php echo (!empty($data['T_price_err'])) ? 'error' : '' ?>" required>
                        <span class="err-msg"><?php echo $data['T_price_err']; ?></span>
                    </div>
                    <div class="input-field">
                    </div>
                </div>
            </div>

            <div class="buttons">
            <button type="reset" onclick="window.history.back()" >
                        <span class="btnText">Back</span>
                    </button>
                <button class="submit">
                    <span class="btnText">Submit</span>
                </button>
            </div>
        </div>
    </form>
</div>


    <script src="<?php echo URLROOT; ?>/js/signup.js"></script>
</body>
</html>