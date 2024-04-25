<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title>Appointments Update</title>
</head>
<body>
    <div class="container-signup" style="height: 620px; overflow: hidden;">
        <header>Appointments Update</header>

        <form action="<?php echo URLROOT; ?>/admin/edit_appointments" method="POST" style="height: 600px;">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Appointment Details</span>

                    <!-- Hidden input field for data -->
                    <input type="hidden" name="" value="<?php //echo $data['H_ID'] ?>">

                    <div class="fields">
                        <div class="input-field">
                            <label>Reservation ID*</label>
                            <input type="text" placeholder="" name="" value="<?php //echo $data['H_name'] ?>" required disabled>
                        </div>

                        <div class="input-field">
                            <label>Patient Name*</label>
                            <input type="text" placeholder="" name="" value="<?php //echo $data['H_address'] ?>" required disabled>
                        </div>

                        <div class="input-field">
                            <label>NIC*</label>
                            <input type="text" placeholder="" name="" value="<?php //echo $data['H_address'] ?>" required disabled>
                        </div>

                        <!-- Radio buttons for Date -->
                        <div class="input-field">
                            <label>Date*</label>
                            <div class="radio-container">
                                <label><input type="radio" name="appointment_date" value="2024-04-25" required> April 25, 2024</label>
                                
                                <!-- Add more radio buttons for other dates as needed -->
                            </div>
                        </div>

                        <div class="input-field">
                            <label>Date</label>
                            <div class="radio-container">
                            <label><input type="radio" name="appointment_date" value="2024-04-25" required> April 25, 2024</label>
                              
                            </div>
                        </div>

                        <div class="input-field">
                            <label>Date*</label>
                            <div class="radio-container">
                            <label><input type="radio" name="appointment_date" value="2024-04-25" required> April 25, 2024</label>
                               
                            </div>
                        </div>

                        <div class="input-field">
                            <label>Appointment Number*</label>
                            <input type="text" placeholder="Enter appointment number" name="" value="<?php //echo $data['C_num'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Start Time*</label>
                            <input type="time" placeholder="Enter appointment number" name="" value="<?php //echo $data['C_num'] ?>" required>
                        </div>

                        <div class="input-field">
                            <label>End Time*</label>
                            <input type="time" placeholder="" name="" value="<?php //echo $data['C_num'] ?>" required>
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" onclick="window.history.back()">
                        <span class="btnText">Back</span>
                    </button>
                        
                    <button class="submit">
                        <span class="btnText">Submit</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="<?php echo URLROOT; ?>/js/signup.js"></script>
</body>
</html>
