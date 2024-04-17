<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style3.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/stylereg.css">


    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Hospital Staff Regisration</title>
</head>

<body>
    <div class="container-signup">
        <header>Hospital Staff Registration</header>

        <form action="" method="POST">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>First Name*</label>
                            <input type="text" placeholder="Enter your first name" name="fname" value="" required>
                        </div>

                        <div class="input-field">
                            <label>Last Name*</label>
                            <input type="text" placeholder="Enter your last name" name="lname" value="" required>
                        </div>

                        <div class="input-field">
                            <label>Gender*</label>
                            <select name="gender" required>
                                <option selected value="">Select gender</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Date of Birth*</label>
                            <input type="date" placeholder="Enter birth date" name="dob" value="" required>
                        </div>

                        <div class="input-field">
                            <label>NIC Number*</label>
                            <input type="text" placeholder="Enter your NIC number" name="nic" value="" required>
                        </div>
                        <div class="input-field">
                            <label>Mobile Number*</label>
                            <input type="number" placeholder="Enter your mobile number" name="cnum" value="" required>
                        </div>
                    </div>
                </div>

                <div class="details Medical">
                    <span class="title">Employment Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Hospital*</label>
                            <select name="hospital" required>
                                <option selected value="">Select hospital</option>
                                <option value="Asiri Hospitals - Kirula Rd">Asiri Hospitals - Kirula Rd.</option>
                                <option value="Lanka Hospitals - Nugegoda">Lanka Hospitals - Nugegoda</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Role*</label>
                            <select name="role" required>
                                <option selected value="">Select role</option>
                                <option value="Manager">Hospital Manager</option>
                                <option value="Lab Assistant">Lab Assistant</option>
                                <option value="Pharmacist">Pharmacist</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Employed Date*</label>
                            <input type="date" name="employed_date" value="" required>
                        </div>

                       

                        <div class="input-field">
                            <label>Staff ID*</label>
                            <input type="text" placeholder="Enter your Staff ID number" name="staffid" value="" required>
                        </div>
                         </div>
                </div>

                <div class="details account">
                    <span class="title">Account Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Email*</label>
                            <input type="email" placeholder="Enter your email" name="email" value="" class="">
                            <span class="err-msg"></span>
                        </div>

                        <div class="input-field">
                            <label>Password*</label>
                            <input type="password" placeholder="Enter a password" name="pass" value="" class="">
                            <span class="err-msg"></span>
                        </div>

                        <div class="input-field" style="margin-bottom: 0;">
                            <label>Confirm Password*</label>
                            <input type="password" placeholder="Enter your password again" name="cpass" value="" class="">
                            <span class="err-msg"></span>
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
                <div class="login-signup" style="margin-top: -20px; font-size: 14px;">
                    <span class="text">Already have an account?
                        <a href="#" class="text login-link">Login Now</a>
                    </span>
                </div>
            </div>

        </form>
    </div>

    <script src="signup.js"></script>
</body>

</html>
