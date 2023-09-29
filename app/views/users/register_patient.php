<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title>Responsive Regisration Form </title>
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
                            <input type="text" placeholder="Enter your first name" name="fname" >
                        </div>

                        <div class="input-field">
                            <label>Last Name*</label>
                            <input type="text" placeholder="Enter your last name" name="lname">
                        </div>

                        <div class="input-field">
                            <label>Gender*</label>
                            <select required name="gender">
                                <option  selected value=""> Select gender</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Date of Birth*</label>
                            <input type="date" placeholder="Enter birth date" name="dob">
                        </div>

                        <div class="input-field">
                            <label>NIC (not required if age < 18)</label>
                            <input type="text" placeholder="Enter your NIC number" name="nic">
                        </div>
                        <div class="input-field">
                            <label>Mobile Number*</label>
                            <input type="number" placeholder="Enter your mobile number" name="cnum">
                        </div>
                    </div>
                </div>

                <div class="details Medical">
                    <span class="title">Medical Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Height (in cm)</label>
                            <input type="number" placeholder="Enter your height" name="height">
                        </div>

                        <div class="input-field">
                            <label>Weight (in kg)</label>
                            <input type="number" placeholder="Enter your weight" name="weight">
                        </div>
                        <div class="input-field">
                            <label>Blood Group</label>
                            <select name="bgroup">
                                <option selected value="">Select blood group</option>
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
                            <input type="text" placeholder="Enter allergies if you have" name="allergies">
                        </div>
                    </div>
                    <button class="nextBtn">
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
                <div class="details emergency">
                    <span class="title">Emergency Contact Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Contact Name</label>
                            <input type="email" placeholder="Enter contact's name">
                        </div>

                        <div class="input-field">
                            <label>Contact Mobile Number</label>
                            <input type="number" placeholder="Enter contact's number">
                        </div>

                        <div class="input-field">
                            <label>Relation</label>
                            <select>
                                <option disabled selected>Select relation</option>
                                <option>Parent</option>
                                <option>Spouse</option>
                                <option>Child</option>
                                <option>Other</option>
                            </select>
                        </div>
                    </div>
                </div>    
                <div class="details account">
                    <span class="title">Account Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Email*</label>
                            <input type="email" placeholder="Enter your email" name="email">
                        </div>

                        <div class="input-field">
                            <label>Password*</label>
                            <input type="password" placeholder="Enter a password" name="pass">
                        </div>

                        <div class="input-field">
                            <label>Confirm Password*</label>
                            <input type="password" placeholder="Enter your password again" name="cpass">
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