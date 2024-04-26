<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

        <title><?php echo SITENAME?>: Add Doctor</title>
    </head>
    <body>
    <div class="container-signup" style="height: 720px;" >
        <header>Add Doctor</header>

        <form  action="<?php echo URLROOT; ?>/admin/add_doctor" method="POST" style="height: 600px;">
            <div class="form first" >
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>First Name*</label>
                            <input type="text" placeholder="Enter first name" name="fname" value="<?php echo $data['F_name'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Last Name*</label>
                            <input type="text" placeholder="Enter last name" name="lname" value="<?php echo $data['L_name'] ?>" required>
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
                            <span class="err-msg"><?php echo $data['NIC_err'] ?></span>
                        </div>
                        <div class="input-field">
                            <label>Mobile Number*</label>
                            <input type="number" placeholder="Enter your mobile number" name="cnum" value="<?php echo $data['C_num'] ?>" class="<?php echo (!empty($data['C_num_err'])) ? 'error' : '' ?>" required>
                            <span class="err-msg"><?php echo $data['C_num_err'] ?></span>
                        </div>
                        <div class="input-field">
                            <input type="hidden" placeholder="" name="" value="<?php //echo $data['DOB'] ?>" class="<?php //echo (!empty($data['DOB_err'])) ? 'error' : '' ?>" required>
                        </div>
                    </div>
                </div>

                <div class="details Medical">
                    <span class="title">Registration Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Specialization*</label>
                            <select name="spec" required>
                                <option selected value="<?php echo $data['Spec'] ?>" > <?php echo ($data['Spec'] == '') ? 'Select specialization' : $data['Spec'] ?></option>
                                <option value="Cardiologist">Cardiologist</option>
                                <option value="Dermatologist">Dermatologist</option>
                                <option value="Gastroenterologist">Gastroenterologist</option>
                                <option value="General practitioner">General practitioner</option>
                                <option value="Hematologist">Hematologist</option>
                                <option value="Neurologist">Neurologist</option>
                                <option value="Gynecologist">Gynecologist</option>
                                <option value="Oncologist">Oncologist</option>
                                <option value="Ophthalmologist">Ophthalmologist</option>
                                <option value="Radiologist">Radiologist</option>
                                <option value="Pediatrician">Pediatrician</option>
                                <option value="Psychiatrist">Psychiatrist</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>SLMC Regisration Number*</label>
                            <input type="number" placeholder="Enter SLMC regisration number" name="slmc" value="<?php echo $data['SLMC'] ?>" class="<?php echo (!empty($data['SLMC_err'])) ? 'error' : '' ?>" required>
                            <span class="err-msg"><?php echo $data['SLMC_err']; ?></span>
                        </div>
                        <div class="input-field">
                            <label>Appointment Charges*</label>
                            <input type="number" step="0.01" placeholder="Enter appointment charges" name="charges" value="<?php echo $data['Charges'] ?>" class="<?php echo (!empty($data['Char_err'])) ? 'error' : '' ?>" required>
                            <span class="err-msg"><?php echo $data['Char_err']; ?></span>
                        </div>
                    </div>
                    <div class="details account">
                    <span class="title">Account Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Email*</label>
                            <input type="email" placeholder="Enter an email" name="email" value="" class="<?php echo (!empty($data['Uname_err'])) ? 'error' : '' ?>">
                            <span class="err-msg"><?php echo $data['Uname_err'] . "\u{200B}"; ?></span>
                        </div>
                        


                        <div class="input-field">
                            <label>Password*</label>
                            <input type="password" placeholder="Enter a password" name="pass" value="" class="<?php echo (!empty($data['Pass_err'])) ? 'error' : '' ?>" >
                            <span class="err-msg"><?php echo $data['Pass_err'] . "\u{200B}"; ?></span>
                        </div>
                        

                        <div class="input-field" style="margin-bottom: 0;" >
                            <label>Confirm Password*</label>
                            <input type="password" placeholder="Enter the password again" name="cpass" value="" class="<?php echo (!empty($data['C_pass_err'])) ? 'error' : '' ?>" >
                            <span class="err-msg"><?php echo $data['C_pass_err'] . "\u{200B}"; ?></span>
                        </div>
                        
                    </div>
                    <div class="buttons">
                    <button type="reset" onclick="window.history.back()">
                        <span class="btnText">Back</span>
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

    <!--<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clearButton = document.getElementById('clearButton');
        const registrationForm = document.getElementById('registrationForm');

        // Add click event listener to the Clear button
        clearButton.addEventListener('click', function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();

            // Reset the form
            registrationForm.reset();
        });
    });
    </script>-->

    </body>
</html>