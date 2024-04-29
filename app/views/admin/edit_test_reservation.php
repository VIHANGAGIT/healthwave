<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title><?php echo SITENAME; ?>: Edit Test Reservation</title>
</head>
<body>
    <div class="container-signup" style="height: 420px; overflow: hidden;">
        <header>Edit Test Reservation</header>

        <form action="" method="POST" style="height: 600px;">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Test Reservation Details</span>

                    <!-- Hidden input field for data -->
                    <input type="hidden" name="" value="<?php //echo $data['H_ID'] ?>">

                    <div class="fields">
                        <div class="input-field">
                            <label>Reservation ID*</label>
                            <input type="text" placeholder="" name="res_id" value="<?php echo $data['res_id'] ?>" required readonly>
                        </div>

                        <div class="input-field">
                            <label>Patient Name*</label>
                            <input type="text" placeholder="" name="patient_name" value="<?php echo $data['patient_name'] ?>" required disabled>
                        </div>

                        <div class="input-field">
                            <label>NIC*</label>
                            <input type="text" placeholder="" name="nic" value="<?php echo $data['nic'] ?>" required disabled>
                        </div>

                        <div class="input-field">
                            <label>Date*</label>
                            <input type="date" id="dateSelect" placeholder="" name="date" value="<?php echo $data['date'] ?>" class="<?php echo (!empty($data['test_date_err'])) ? 'error' : '' ?>" required>
                            <span class="err-msg"><?php echo $data['test_date_err'] ?></span>
                        </div>

                       

                        <div class="input-field">
                            <label>Time*</label>
                            <select name="time" id="timeSelect" required>
                                <option selected><?php echo $data['time'] ?></option>
                            </select>
                        </div>

                        <div class="input-field">
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" onclick="window.location.href = 'test_reservations'">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#dateSelect").change(function() {
                var selectedDate = $(this).val();
                var hospital_id = <?php echo $data['hospital_id']; ?>;

                $.ajax({
                    type: "POST",
                    url: "get_reservation_times",
                    data: { date: selectedDate, hospital_id: hospital_id},
                    dataType: "json",
                    success: function(response) {
                        var timeContainer = $("#timeSelect");
                        timeContainer.empty();

                        Object.keys(response).forEach(function(key) {
                            var timeSlot = response[key];
                            var startTime = timeSlot.start_time;
                            var endTime = timeSlot.end_time;

                            var timeLabel = $("<option>").text(startTime + " - " + endTime); 
                            timeContainer.append(timeLabel);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + xhr.status + " - " + error);
                    }
                });
            });
        });
    </script>
</body>
</html>
