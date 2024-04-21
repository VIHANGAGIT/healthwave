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

   <title>Hospital Regisration</title>
</head>
<body>
<div class="container-signup" style="height: 720px;">
    <header>Add Test</header>

    <form action="<?php //echo URLROOT; ?>/users/register_doctor" method="POST" style="height: 600px;">
        <div class="form first">
            <div class="details personal">
                <span class="title">Test Details</span>

                <div class="fields">
                    <div class="input-field" style="width: calc(50% - 10px); margin-right: 10px;">
                        <label>Test Name*</label>
                        <input type="text" placeholder="Enter test name" name="testname" value="<?php //echo $data['F_name'] ?>" required>
                    </div>

                    <div class="input-field" style="width: calc(50% - 10px);">
                        <label>Test Type*</label>
                        <select name="region" required>
                            <option selected value="<?php //echo $data['Gender'] ?>"><?php //echo ($data['Gender'] == '') ? 'Select test type' : $data['Gender'] ?></option>
                            <option>Test Type 1</option>
                            <option>Test Type 2</option>
                            <option>Test Type 3</option>
                            <option>Test Type 4</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button style="width: calc(50% - 10px);">
                    <span class="btnText">Clear</span>
                </button>
                <button class="submit" style="width: calc(50% - 10px);  margin-left: 15px;">
                    <span class="btnText">Add</span>
                </button>
            </div>
        </div>
    </form>
</div>


    <script src="<?php echo URLROOT; ?>/js/signup.js"></script>
</body>
</html>