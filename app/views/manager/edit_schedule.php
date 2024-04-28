<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title><?php echo SITENAME; ?>: Edit Schedule</title>
</head>
<body>
    <div class="container-signup" style="height: 520px; overflow: hidden;">
        <header>Edit Schedule</header>

        <form action="" method="POST" style="height: 600px;">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Schedule Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Doctor Name*</label>
                            <input type="text" name="doctor" value="<?php echo $data['Doctor_ID'] ?>" required readonly >
                        </div>

                        <div class="input-field">
                            <label>Room*</label>
                            <select name="room" required class="<?php echo (!empty($data['Room_err'])) ? 'error' : '' ?>">
                                <option selected value="<?php echo $data['Room_ID'] ?>" > <?php echo $data['Room_Name'] ?></option>
                                <?php foreach($data['rooms'] as $room): ?>
                                    <option value="<?php echo $room->Room_ID; ?>"><?php echo $room->Room_Name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="err-msg"><?php echo $data['Room_err']; ?></span>
                        </div>

                        <div class="input-field">
                            <label>Day of Week*</label>
                            <select name="day" required class="<?php echo (!empty($data['Day_err'])) ? 'error' : '' ?>">
                                <option selected value="<?php echo $data['Day'] ?>" > <?php echo $data['Day'] ?></option>
                                <option value="Mon">Monday</option>
                                <option value="Tue">Tuesday</option>
                                <option value="Wed">Wednesday</option>
                                <option value="Thu">Thursday</option>
                                <option value="Fri">Friday</option>
                                <option value="Sat">Saturday</option>
                                <option value="Sun">Sunday</option>
                            </select>
                            <span class="err-msg"><?php echo $data['Day_err']; ?></span>
                        </div>

                        <div class="input-field">
                            <label>Start Hour*</label>
                            <select name="start_hour" required class="<?php echo (!empty($data['Time_Start_err'])) ? 'error' : '' ?>">
                                <option selected value="<?php echo $data['start_hour'] ?>" > <?php echo $data['start_hour'] ?></option>
                                <?php for($i = 6; $i < 24; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <span class="err-msg"><?php echo $data['Time_Start_err']; ?></span>
                        </div>

                        <div class="input-field">
                            <label>Start Min*</label>
                            <select name="start_min" required class="<?php echo (!empty($data['Time_Start_err'])) ? 'error' : '' ?>" >
                                <option selected value="<?php echo $data['start_min'] ?>" > <?php echo $data['start_min'] ?></option>
                                <option>00</option>
                                <option>15</option>
                                <option>30</option>
                                <option>45</option>
                            </select>
                            <span class="err-msg"><?php echo $data['Time_Start_err']; ?></span>
                        </div>

                        <div class="input-field">
                        </div>

                        <div class="input-field">
                            <label>End Hour*</label>
                            <select name="end_hour" required >
                                <option selected value="<?php echo $data['end_hour'] ?>" > <?php echo $data['end_hour']?></option>
                                <?php for($i = 6; $i < 24; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <span class="err-msg"><?php echo $data['Time_End_err']; ?></span>
                        </div>

                        <div class="input-field">
                            <label>End Min*</label>
                            <select name="end_min" required >
                                <option selected value="<?php echo $data['end_min'] ?>" > <?php echo $data['end_min'] ?></option>
                                <option>00</option>
                                <option>15</option>
                                <option>30</option>
                                <option>45</option>
                            </select>
                            <span class="err-msg"><?php echo $data['Time_End_err']; ?></span>
                        </div>
                        <div class="input-field">
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" onclick="window.location.href = 'schedule_management'">
                        <span class="btnText">Back</span>
                    </button>
                        
                    <button class="submit">
                        <span class="btnText" id="submit" >Submit</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="<?php echo URLROOT; ?>/js/signup.js"></script>
    
</body>
</html>
