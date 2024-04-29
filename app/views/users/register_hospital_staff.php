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

   <title><?php echo SITENAME; ?>: Hospital Staff Registration</title>
</head>
<body>
    <div class="container-signup" style="height: 720px;" >
        <header>Hospital Staff Registration</header>

        <form action="<?php echo URLROOT; ?>/users/register_hospital_staff" method="POST" style="height: 600px;">
            <div class="form first" >
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>First Name*</label>
                            <input type="text" placeholder="Enter your first name" name="fname" value="<?php echo $data['F_name'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Last Name*</label>
                            <input type="text" placeholder="Enter your last name" name="lname" value="<?php echo $data['L_name'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Gender*</label>
                            <select name="gender" required>
                            <option selected value="<?php echo $data['Gender'] ?>" > <?php echo ($data['Gender'] == '') ? 'Select gender' : $data['Gender'] ?></option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>NIC Number*</label>
                            <input type="text" placeholder="Enter your NIC number" name="nic" value="<?php echo $data['NIC'] ?>" class="<?php echo (!empty($data['NIC_err'])) ? 'error' : '' ?>" required>
                            <span class="err-msg"><?php echo $data['NIC_err']; ?></span>
                        </div>
                        <div class="input-field">
                            <label>Mobile Number*</label>
                            <input type="number" placeholder="Enter your mobile number" name="cnum" value="<?php echo $data['C_num'] ?>" class="<?php echo (!empty($data['C_num_err'])) ? 'error' : '' ?>" required>
                            <span class="err-msg"><?php echo $data['C_num_err']; ?></span>
                        </div>
                        <div class="input-field">
                            <input type="hidden" placeholder="" name="" value="<?php //echo $data['DOB'] ?>">
                        </div>
                    </div>
                </div>

                <div class="details Medical">
                    <span class="title">Employment Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Hospital*</label>
                            <select name="hospital" required>
                                <option selected value="<?php echo $data['Hospital'] ?>">
                                    <?php echo ($data['Hospital'] == '') ? 'Select hospital' : $data['Hospital'] ?>
                                </option>

                                <?php foreach ($data['hospitalNames'] as $hospital) {
                                    echo '<option value="' . $hospital->Hospital_ID . '">' . $hospital->Hospital_Name . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Role*</label>
                            <select name="role" required>
                                <option selected value="<?php echo $data['Role'] ?>" > <?php echo ($data['Role'] == '') ? 'Select role' : $data['Role'] ?></option>
                                <option value="Manager">Hospital Manager</option>
                                <option value="Lab Assistant">Lab Assistant</option>
                                <option value="Pharmacist">Pharmacist</option>
                            </select>
                        </div>
                        <div class="input-field" style="opacity: 0;" >
                            <label></label>
                            <input type="text">
                        </div>
                    </div>
                </div>

                <div class="details account">
                    <span class="title">Account Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Email*</label>
                            <input type="email" placeholder="Enter your email" name="email" value="" class="<?php echo (!empty($data['Uname_err'])) ? 'error' : '' ?>">
                            <span class="err-msg"><?php echo $data['Uname_err'] . "\u{200B}"; ?></span>
                        </div>
                        


                        <div class="input-field">
                            <label>Password*</label>
                            <input type="password" placeholder="Enter a password" name="pass" value="" class="<?php echo (!empty($data['Pass_err'])) ? 'error' : '' ?>" >
                            <span class="err-msg"><?php echo $data['Pass_err'] . "\u{200B}"; ?></span>
                        </div>
                        

                        <div class="input-field" style="margin-bottom: 0;" >
                            <label>Confirm Password*</label>
                            <input type="password" placeholder="Enter your password again" name="cpass" value="" class="<?php echo (!empty($data['C_pass_err'])) ? 'error' : '' ?>" >
                            <span class="err-msg"><?php echo $data['C_pass_err'] . "\u{200B}"; ?></span>
                        </div>
                        
                    </div>
                    <div class="buttons">
                        <button>
                            <span class="btnText">Clear</span>
                        </button>
                        
                        <button class="sumbit">
                            <span class="btnText">Submit</span>
                        </button>
                    </div>
                </div>
                    <div class="login-signup" style="margin-top: -20px; font-size: 14px;" ">
                        <span class="text">Already have an account?
                            <a href="<?php echo URLROOT; ?>/users/login" class="text login-link">Login Now</a>
                        </span>
                    </div>
                </div>
                
            </div>
        </form>
    </div>

    <script src="<?php echo URLROOT; ?>/js/signup.js"></script>
</body>
</html>