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
    <div class="container-signup" style="height: 720px;" >
        <header>Hospital Registration</header>

        <form action="<?php //echo URLROOT; ?>/users/register_doctor" method="POST" style="height: 600px;">
            <div class="form first" >
                <div class="details personal">
                    <span class="title">Hospital Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Hospital Name*</label>
                            <input type="text" placeholder="Enter hospital name" name="hname" value="<?php //echo $data['F_name'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Address*</label>
                            <input type="text" placeholder="Enter hospital adress" name="hadress" value="<?php //echo $data['L_name'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Region*</label>

                            <select name="region" required>
                            <option selected value="<?php //echo $data['Gender'] ?>" > <?php //echo ($data['Gender'] == '') ? 'Select gender' : $data['Gender'] ?></option>
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
                            <input type="text" placeholder="Enter hospital charge" name="hcharge" value="<?php //echo $data['DOB'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Manager ID*</label>
                            <input type="text" placeholder="Enter Manager ID" name="managerid" value="<?php //echo $data['NIC'] ?>" required>
                        </div>
                        <div class="input-field">
                            <label>Contact Number*</label>
                            <input type="text" placeholder="Enter hospital contact number" name="cnum" value="<?php //echo $data['C_num'] ?>" required>
                        </div>
                    </div>
                </div>

                    <div class="buttons">
                        <button>
                            <span class="btnText">Clear</span>
                        </button>
                        
                        <button class="sumbit">
                            <span class="btnText">Add</span>
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