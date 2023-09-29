<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style.css">
         
    <title>Login & Registration Form</title> 
</head>
<body>
    
    <div class="container-login">
        <div class="forms">
            <div class="form login">
                <span class="title">User Login</span><br><br>

                <form action="<?php echo URLROOT; ?>/users/login" method="POST">
                    <div class="input-field">
                        <input type="text" class="<?php echo (!empty($data['Uname_err'])) ? 'error' : '' ?>" placeholder="Enter your email" name="email">
                        
                    </div>
                    <span class="err-msg"><?php echo $data['Uname_err'] . "\u{200B}"; ?></span>
                    
                    <div class="input-field">
                        <input type="password" class="password <?php echo (!empty($data['Pass_err'])) ? 'error' : '' ?>" placeholder="Enter your password" name="pass">
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <span class="err-msg"><?php echo $data['Pass_err'] . "\u{200B}"; ?></span>
                    

                    <div class="checkbox-text">
                        <!--<div class="checkbox-content">
                            <input type="checkbox" id="logCheck">
                            <label for="logCheck" class="text">Remember me</label>
                        </div> -->
                        
                        <a href="#" class="text" style="color: #4070f4;">Forgot password?</a>
                    </div>

                    <div class="input-field button">
                        <input type="submit" value="Login">
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Not a member?
                        <a href="#" class="text signup-link" style="color: #4070f4;">Signup Now</a>
                    </span>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="form signup">
                <span class="title">User Registration</span>

                <form action="#">
                    <div class="input-field button">
                        <a  href="<?php echo URLROOT; ?>/users/register_patient"><input type="button" value="Signup as a Patient"></a>
                    </div>
                    <div class="input-field button">
                        <input type="button" value="Signup as a Doctor">
                    </div>
                    <div class="input-field button">
                        <input type="button" value="Signup as a Hospital Manager">
                    </div>
                    <div class="input-field button">
                        <input type="button" value="Signup as a Pharmacist">
                    </div>
                    <div class="input-field button">
                        <input type="button" value="Signup as a Lab Assistant">
                    </div>
                </form>
                <div class="login-signup">
                    <span class="text">Already a member?
                        <a href="#" class="text login-link" style="color: #4070f4;" >Login Now</a>
                    </span>
                </div>
                
            </div>
        </div>
    </div>

     <script src="<?php echo URLROOT;?>/js/main.js"></script> 
</body>
</html>