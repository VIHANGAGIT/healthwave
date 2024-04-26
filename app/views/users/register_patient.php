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

   <title>Patient Regisration</title>
</head>
<body>
    <div class="container-signup">
        <header>Patient Registration</header>

        <form action="<?php echo URLROOT; ?>/users/register_patient" method="POST">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>First Name*</label>
                            <input type="text" placeholder="Enter your first name" name="fname" value="<?php echo $data['F_name'] ?>">
                        </div>

                        <div class="input-field">
                            <label>Last Name*</label>
                            <input type="text" placeholder="Enter your last name" name="lname" value="<?php echo $data['L_name'] ?>">
                        </div>

                        <div class="input-field">
                            <label>Gender*</label>
                            <select name="gender">
                            <option selected value="<?php echo $data['Gender'] ?>" > <?php echo ($data['Gender'] == '') ? 'Select gender' : $data['Gender'] ?></option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Date of Birth*</label>
                            <input type="date" placeholder="Enter birth date" name="dob" value="<?php echo $data['DOB'] ?>">
                            <span class="err-msg"><?php echo $data['DOB_err'] ; ?></span>
                        </div>

                        <div class="input-field">
                            <label>NIC Number</label>
                            <input type="text" placeholder="Enter your NIC number" name="nic" value="<?php echo $data['NIC'] ?>">
                            <span class="err-msg"><?php echo $data['NIC_err'] ; ?></span>
                        </div>
                        <div class="input-field">
                            <label>Mobile Number*</label>
                            <input type="number" placeholder="Enter your mobile number" name="cnum" value="<?php echo $data['C_num'] ?>">
                            <span class="err-msg"><?php echo $data['C_num_err'] ; ?></span>
                        </div>
                    </div>
                </div>

                <div class="details Medical">
                    <span class="title">Medical Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Height (in cm)</label>
                            <input type="number" placeholder="Enter your height" name="height" value="<?php echo $data['Height'] ?>">
                        </div>

                        <div class="input-field">
                            <label>Weight (in kg)</label>
                            <input type="number" placeholder="Enter your weight" name="weight" value="<?php echo $data['Weight'] ?>">
                        </div>
                        <div class="input-field">
                            <label>Blood Group</label>
                            <select name="bgroup">
                                <option selected value="<?php echo $data['B_group'] ?>" > <?php echo ($data['B_group'] == '') ? 'Select blood group' : $data['B_group'] ?></option>
                                <option value="A+">A Positive (A+)</option>
                                <option value="A-">A Negative (A-)</option>
                                <option value="B+">B Positive (B+)</option>
                                <option value="B-">B Negative (B-)</option>
                                <option value="AB+">AB Positive (AB+)</option>
                                <option value="AB-">AB Negative (AB-)</option>
                                <option value="O+">O Positive (O+)</option>
                                <option value="O-">O Negative (O-)</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Allergies</label>
                            <input type="text" placeholder="Enter allergies if you have" name="allergies" value="<?php echo $data['Allergies'] ?>">
                        </div>
                    </div>
                    <!-- The preventDefault function allows to contiune to second page without submitting the form  -->
                    <button class="nextBtn" onclick="event.preventDefault();">
                        <span class="btnText">Next</span>
                    </button>
                    <div class="login-signup" style="margin-top: -20px; font-size: 14px;" ">
                        <span class="text">Already have an account?
                            <a href="<?php echo URLROOT; ?>/users/login" class="text login-link">Login Now</a>
                        </span>
                    </div>
                </div>
                
            </div>

            <div class="form second" style="width: 100%;" >
                <div class="details account">
                    <span class="title">Account Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Email*</label>
                            <input type="email" placeholder="Enter your email" name="email" value="<?php echo $data['Uname'] ?>" class="<?php echo (!empty($data['Uname_err'])) ? 'error' : '' ?>">
                            <span class="err-msg"><?php echo $data['Uname_err'] . "\u{200B}"; ?></span>
                        </div>
                        


                        <div class="input-field">
                            <label>Password*</label>
                            <input type="password" placeholder="Enter a password" name="pass" value="<?php echo $data['Pass'] ?>" class="<?php echo (!empty($data['Pass_err'])) ? 'error' : '' ?>" >
                            <span class="err-msg"><?php echo $data['Pass_err'] . "\u{200B}"; ?></span>
                        </div>
                        

                        <div class="input-field" style="margin-bottom: 0;" >
                            <label>Confirm Password*</label>
                            <input type="password" placeholder="Enter your password again" name="cpass" value="<?php echo $data['C_pass'] ?>" class="<?php echo (!empty($data['C_pass_err'])) ? 'error' : '' ?>" >
                            <span class="err-msg"><?php echo $data['C_pass_err'] . "\u{200B}"; ?></span>
                        </div>
                        
                    </div>
                    <div class="buttons">
                        <div class="backBtn">
                            <span class="btnText">Back</span>
                        </div>
                        
                        <button class="sumbit">
                            <span class="btnText">Submit</span>
                        </button>
                    </div>
                </div>
                <br>
                <div class="login-signup">
                    <span class="text" style="font-size: 14px;" >Already have an account?
                        <a href="<?php echo URLROOT; ?>/users/login" class="text login-link">Login Now</a>
                    </span>
                </div>
            </div>
            
        </form>
    </div>

    <script src="<?php echo URLROOT; ?>/js/signup.js"></script>
</body>
</html>