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

   <title><?php echo SITENAME?>: Add Test</title>
</head>
<body>
<div class="container-signup" style="height: 350px; overflow: hidden;">
    <header>Add Test - Hospital</header>

    <form action="<?php echo URLROOT; ?>/manager/add_test" method="POST" style="height: 500px;">
        <div class="form first">
            <div class="details personal">
                <span class="title">Test Details</span>

                <div class="fields">
                    <div class="input-field" style="width: calc(50% - 10px); margin-right: 10px;">
                        <label>Test*</label>
                        <select name="test_id" required>
                            <option selected disabled value="">Select a test</option>
                            <?php foreach($data['Tests'] as $test): ?>
                                <option value="<?php echo $test['Test_ID']; ?>"><?php echo $test['Test_Name_Test_Type']; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="input-field" style="width: calc(50% - 10px);">
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
                    <span class="btnText">Add</span>
                </button>
            </div>
        </div>
    </form>
</div>


    <script src="<?php echo URLROOT; ?>/js/signup.js"></script>
</body>
</html>