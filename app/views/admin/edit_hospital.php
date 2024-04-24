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

   <title>Hospital Update</title>
</head>
<body>
    <div class="container-signup" style="height: 720px;" >
        <header>Hospital Update</header>

        <form action="<?php echo URLROOT; ?>/admin/edit_hospital" method="POST" style="height: 600px;">
            <div class="form first" >
                <div class="details personal">
                    <span class="title">Hospital Details</span>

                    <input type="hidden" name="hid" value="<?php echo $data['H_ID'] ?>">

                    <div class="fields">
                        <div class="input-field">
                            <label>Hospital Name*</label>
                            <input type="text" placeholder="Enter hospital name" name="hname" value="<?php echo $data['H_name'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Address*</label>
                            <input type="text" placeholder="Enter hospital adress" name="haddress" value="<?php echo $data['H_address'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Region*</label>

                            <select name="region" required>
                            <option selected value="<?php echo $data['Region'] ?>" > <?php echo ($data['Region'] == '') ? 'Select region' : $data['Region'] ?></option>
                                <option>Colombo</option>
                                <option>Kandy</option>
                                <option>Galle</option>
                                <option>Matara</option>
                                <option>Kurunegala</option>
                                <option>Badulla</option>
                                <option>Anuradhapura</option>
                                <option>Polonnaruwa</option>
                                <option>Trincomalee</option>
                                <option>Jaffna</option>
                                <option>Other</option>

                            </select>
                        </div>

                        <div class="input-field">
                            <label>Hospital Charge*</label>
                            <input type="text" placeholder="Enter hospital charge" name="hcharge" value="<?php echo $data['H_charge'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Manager ID*</label>
                            <input type="text" placeholder="Enter Manager ID" name="managerid" value="<?php echo $data['M_ID'] ?>" required>
                        </div>
                        <div class="input-field">
                            <label>Contact Number*</label>
                            <input type="text" placeholder="Enter hospital contact number" name="cnum" value="<?php echo $data['C_num'] ?>" required>
                            <span class="err-msg"><?php echo $data['C_num_err'] ?></span>

                        </div>
                    </div>
                </div>

                    <div class="buttons">
                        <button type="button" onclick="window.history.back()" >
                            <span class="btnText">Back</span>
                        </button>
                        
                        <button class="sumbit">
                            <span class="btnText">Sumbit</span>
                        </button>
                    </div>
                </div>
                   
                </div>
                
            </div>
        </form>
</div>

    <script src="<?php echo URLROOT; ?>/js/signup.js"></script>
</body>
</html>