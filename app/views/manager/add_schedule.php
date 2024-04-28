<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title><?php echo SITENAME; ?>: Add Schedule</title>
</head>
<body>
    <div class="container-signup" style="height: 520px; overflow: hidden;">
        <header>Add Schedule</header>

        <form action="" method="POST" style="height: 600px;">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Schedule Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Doctor Name*</label>
                            <select name="doctor" required >
                                <option selected value="<?php echo $data['Doctor_ID'] ?>" > <?php echo ($data['Doctor_ID'] == '') ? 'Select doctor' : $data['Doctor_ID'] ?></option>
                                <?php foreach($data['doctors'] as $doctor): ?>
                                    <option value="<?php echo $doctor->Doctor_ID; ?>"><?php echo $doctor->First_Name . ' '. $doctor->Last_Name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Room*</label>
                            <select name="room" required class="<?php echo (!empty($data['Room_err'])) ? 'error' : '' ?>">
                                <option selected value="<?php echo $data['Room_ID'] ?>" > <?php echo ($data['Room_ID'] == '') ? 'Select room' : $data['Room_ID'] ?></option>
                                <?php foreach($data['rooms'] as $room): ?>
                                    <option value="<?php echo $room->Room_ID; ?>"><?php echo $room->Room_Name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="err-msg"><?php echo $data['Room_err']; ?></span>
                        </div>

                        <div class="input-field">
                            <label>Day of Week*</label>
                            <select name="day" required class="<?php echo (!empty($data['Day_err'])) ? 'error' : '' ?>">
                                <option selected value="<?php echo $data['Day'] ?>" > <?php echo ($data['Day'] == '') ? 'Select day' : $data['Day'] ?></option>
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
                                <option selected value="<?php echo $data['start_hour'] ?>" > <?php echo ($data['start_hour'] == '') ? 'Select start hour' : $data['start_hour'] ?></option>
                                <?php for($i = 6; $i < 24; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <span class="err-msg"><?php echo $data['Time_Start_err']; ?></span>
                        </div>

                        <div class="input-field">
                            <label>Start Min*</label>
                            <select name="start_min" required class="<?php echo (!empty($data['Time_Start_err'])) ? 'error' : '' ?>" >
                                <option selected value="<?php echo $data['start_min'] ?>" > <?php echo ($data['start_min'] == '') ? 'Select start min' : $data['start_min'] ?></option>
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
                                <option selected value="<?php echo $data['end_hour'] ?>" > <?php echo ($data['end_hour'] == '') ? 'Select end hour' : $data['end_hour'] ?></option>
                                <?php for($i = 6; $i < 24; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <span class="err-msg"><?php echo $data['Time_End_err']; ?></span>
                        </div>

                        <div class="input-field">
                            <label>End Min*</label>
                            <select name="end_min" required >
                                <option selected value="<?php echo $data['end_min'] ?>" > <?php echo ($data['end_min'] == '') ? 'Select end min' : $data['end_min'] ?></option>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#dateSelect").change(function() {
                var selectedDate = $(this).val();
                var hospital_id = <?php echo $data['hospital_id']; ?>;
                var doctor_id = <?php echo $data['doctor_id']; ?>;

                $.ajax({
                    type: "POST",
                    url: "get_appointment_data",
                    data: { date: selectedDate, hospital_id: hospital_id, doctor_id: doctor_id},
                    dataType: "json",
                    success: function(response) {
                        $("#appNoInput").val(response[0].app_no);
                        $("#timeInput").val(response[0].time);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + xhr.status + " - " + error);
                    }
                });
            });
        });

        // $("#submit").click(function() {
        //     event.preventDefault();
        //     var res_id = $("input[name='res_id']").val();
        //     var date = $("select[name='date']").val();
        //     var app_no = $("input[name='app_no']").val();
        //     var time = $("input[name='time']").val();

        //     $.ajax({
        //         type: "POST",
        //         url: "edit_reservation",
        //         data: { res_id: res_id, date: date, app_no: app_no, time: time},
        //         type: "json",
        //         success: function(response) {
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Error: " + xhr.status + " - " + error);
        //         }
        //     });
        // });
    </script>
</body>
</html>
