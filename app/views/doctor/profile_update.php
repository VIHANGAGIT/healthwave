<?php 
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  if(($_SESSION['userType']) != 'Doctor'){
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

   <title>Doctor Profile Update</title>
</head>
<body>
    <div class="container-signup" style="height: 720px;" >
        <header>Doctor Profile Update</header>

        <form action="<?php echo URLROOT; ?>/doctor/profile_update" method="POST" style="height: 600px;">
            <div class="form first" >
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>First Name*</label>
                            <input type="text" placeholder="Enter your first name" name="fname" value="<?php echo $data['First_Name'] ?>" disabled>
                        </div>

                        <div class="input-field">
                            <label>Last Name*</label>
                            <input type="text" placeholder="Enter your last name" name="lname" value="<?php echo $data['Last_Name'] ?>" disabled>
                        </div>

                        <div class="input-field">
                            <label>Gender*</label>
                            <select name="gender" disabled>
                            <option selected value="<?php echo $data['Gender'] ?>" > <?php echo ($data['Gender'] == '') ? 'Select gender' : $data['Gender'] ?></option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>NIC Number*</label>
                            <input type="text" placeholder="Enter your NIC number" name="nic" value="<?php echo $data['NIC'] ?>" disabled>
                        </div>
                        <div class="input-field">
                            <label>Mobile Number*</label>
                            <input type="number" placeholder="Enter your mobile number" name="cnum" value="<?php echo $data['C_Num'] ?>" required>
                            <span class="err-msg"><?php echo $data['C_num_err']; ?></span>
                        </div>
                        <div class="input-field">
                            <label></label>
                            <input type="date" style="opacity: 0;">
                        </div>
                    </div>
                </div>

                <div class="details Medical">
                    <span class="title">Registration Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Specialization*</label>
                            <select name="spec" disabled>
                                <option selected value="<?php echo $data['Spec'] ?>" > <?php echo ($data['Spec'] == '') ? 'Select specialization' : $data['Spec'] ?></option>
                                <option value="Neurologist">Neurologist</option>
                                <option value="Gastroenterologist">Gastroenterologist</option>
                                <option value="Psychiatrist">Psychiatrist</option>
                                <option value="Radiologist">Radiologist</option>
                                <option value="General practitioner">General practitioner</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>SLMC Regisration Number*</label>
                            <input type="number" placeholder="Enter SLMC Regisration Number" name="slmc" value="<?php echo $data['SLMC'] ?>" disabled>
                        </div>
                        <div class="input-field">
                            <label>Appointment Charges*</label>
                            <input type="number" step="0.01" placeholder="Enter appointment charges" name="charges" value="<?php echo $data['Charges'] ?>" required>
                            <span class="err-msg"><?php echo $data['Char_err']; ?></span>
                        </div>
                    </div>
                    <div class="details account">
                    <span class="title">Account Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Email*</label>
                            <input type="email" placeholder="Enter your email" name="email" value="<?php echo $data['Email'] ?>" class="<?php echo (!empty($data['Uname_err'])) ? 'error' : '' ?>">
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
                        <button type="button" onclick="window.history.back()">
                            <span class="btnText">Back</span>
                        </button>
                        
                        <button class="sumbit">
                            <span class="btnText">Submit</span>
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