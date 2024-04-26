<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title><?php echo SITENAME; ?>: Edit Reservation</title>
</head>
<body>
    <div class="container-signup" style="height: 520px; overflow: hidden;">
        <header>Edit Reservation</header>

        <form action="" method="POST" style="height: 600px;">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Reservation Details</span>

                    <!-- Hidden input field for data -->
                    <!-- <input type="hidden" name="" value="<?php //echo $data['H_ID'] ?>"> -->

                    <div class="fields">
                        <div class="input-field">
                            <label>Reservation ID*</label>
                            <input type="text" name="res_id" value="<?php echo $data['res_id'] ?>" required readonly >
                        </div>

                        <div class="input-field">
                            <label>Patient Name*</label>
                            <input type="text" name="patient_name" value="<?php echo $data['patient_name'] ?>" required disabled>
                        </div>

                        <div class="input-field">
                            <label>NIC*</label>
                            <input type="text" name="nic" value="<?php echo $data['nic'] ?>" required disabled>
                        </div>

                        <div class="input-field">
                            <label>Date*</label>

                            <select name="date" id="dateSelect" required>
                                <option disabled selected><?php echo $data['date'] ?></option>
                                <?php foreach($data['next_dates'] as $date): ?>
                                    <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-field">
                        </div>
                        <div class="input-field">
                        </div>

                        <div class="input-field">
                            <label>Appointment Number*</label>
                            <input type="text" name="app_no" id="appNoInput" value="<?php echo $data['app_no'] ?>" required readonly >
                        </div>

                        <div class="input-field">
                            <label>Time*</label>
                            <input type="text" name="time" id="timeInput" value="<?php echo $data['time'] ?>" required readonly >
                        </div>

                        <div class="input-field">
                            <!-- <label>End Time*</label>
                            <input type="time" placeholder="" name="" value="<?php //echo $data['C_num'] ?>" required> -->
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" onclick="window.history.back()">
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
