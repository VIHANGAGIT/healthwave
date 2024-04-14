<?php 
  if(($_SESSION['userType']) != 'Patient'){
    redirect("users/login");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME; ?>: Doctor Booking</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <img src="<?php echo URLROOT;?>/img/logo.png" alt=""> HealthWave
      </div>
      <div class="navbar_content">
        <i class='uil uil-sun' id="darkLight"></i>
        <a href='../users/logout'><button class='button'>Logout</button></a>
      </div>
    </nav>

   <!--sidebar-->
    <nav class="sidebar">
      <div class="menu_container">
        <div class="menu_items">
          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="#" class="link flex">
                <i class="uil uil-estate"></i>
                <span>Home</span>
              </a>
            </li>
            <li class="item">
              <a href="#" class="link flex">
                <i class="uil uil-info-circle"></i>
                <span>About Us</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item active">
              <a href="../patient/doc_booking" class="link flex">
                <i class="uil uil-stethoscope"></i>
                <span>Doctor Booking</span>
              </a>
            </li>
            <li class="item">
              <a href="../patient/test_booking" class="link flex">
                <i class="uil uil-heart-rate"></i>
                <span>Lab Test Booking</span>
              </a>
            </li>
            <li class="item">
              <a href="../patient/reservations" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Reservations</span>
              </a>
            </li>
            <li class="item">
              <a href="../patient/medical_records" class="link flex">
                <i class="uil uil-file-alt"></i>
                <span>Medical Records</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="../patient/profile" class="link flex">
                <i class="uil uil-user"></i>
                <span>Profile</span>
              </a>
            </li>
            <li class="item">
              <a href="#" class="link flex">
                <i class="uil uil-bell"></i>
                <span>Notifications</span>
              </a>
            </li>
           
          </ul>
        </div>

        <div class="sidebar_profile flex">
          <span class="nav_image">
            <img src="<?php echo URLROOT;?>/img/profile.png" alt="logo_img" />
          </span>
          <div class="data_text">
            <span class="name"><?php echo $_SESSION['userName'] ?></span><br>
            <span class="role"><?php echo $_SESSION['userType'] ?></span>
          </div>
        </div>
      </div>
    </nav>



    <div class="content">
      <div class="content-appointment">
          <div class="appointment">
              <form style="width: 100%;" method="POST">
                <div class="fields">
                  <h2>Enter Appointment Details</h2>
                  <table style="width: 95%;">
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Patient ID</label>
                            <input type="text" name="patient_id" value="<?php echo $_SESSION['userID'] ?>" disabled>
                        </div>
                      </td>
                      <td rowspan="6">
                        <div class="profile-card">
                          <div class="profile-photo">
                            <img src="<?php echo URLROOT;?>/img/profile.png" alt="Doctor Photo">
                          </div>
                          <div class="profile-name">Dr. <?php echo $data['doctor_data']->First_Name . ' ' . $data['doctor_data']->Last_Name?></div>
                          <div class="profile-specialization"><?php echo $data['doctor_data']->Specialization?></div>
                          <button class="button" style="background-color: #4070f4;" >View Profile</button>
                        </div>
                        <div class="price-card">
                        <div class="price-item">
                            <span class="price-label">Doctor Charges:</span>
                            <span class="price-value">LKR <?php echo $data['doctor_data']->Charges . ".00"; ?></span>
                          </div>
                          <div class="price-item">
                            <span class="price-label">Hospital Charges:</span>
                            <span class="price-value" id="hospotal_charge">LKR 0.00</span>
                          </div>
                          <div class="price-item">
                            <span class="price-label">Service Charges:</span>
                            <span class="price-value">LKR 100.00</span>
                          </div>
                          <div class="price-item">
                            <span class="price-label">Taxes:</span>
                            <span class="price-value">LKR 50.00</span>
                          </div>
                          <hr>
                          <div class="price-item">
                            <span class="price-label">Total Price:</span>
                            <span class="price-value-total">LKR 3950.00</span>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="text" name="patient_mobile" value="<?php echo $data['C_Num']?>" >
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input-field">
                            <label>Email Address</label>
                            <input type="text" name="patient_email" value="<?php echo $data['Email']?>">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input-field">
                          <label>Select Hospital</label>
                          <select id="hospitalSelect">  
                              <option disabled selected>Select Hospital</option>
                              <?php foreach ($data['hospital_data'] as $hospital): ?>
                                  <option value="<?php echo $hospital->Hospital_ID; ?>"><?php echo $hospital->Hospital_Name; ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <br>
                        <div class="input-field">
                            <label>Select Date</label>
                            <div class="container-radio" name="date">
                                <!-- Date options will be added here -->
                            </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      <br>
                      <div class="input-field">
                          <label>Select Time Slot</label>
                          <div class="container-radio" name="time">
                              <!-- Time slots will be added here -->
                          </div>
                      </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      <br>
                        <div class="input-field">
                          <div class="container-radio">
                              <label>
                                <input type="radio" name="time">
                                <span>11:30 - 12:00 AM</span>
                              </label>
                              <label>
                                <input type="radio" name="time">
                                <span>12:00 - 12:30 AM</span>
                              </label>
                              <label>
                                <input type="radio" name="time">
                                <span>12:30 - 13:00 AM</span>
                              </label>
                              
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <!--<input type="submit" class="button" value="Next" name="search" >-->
                        <button id="pay" class="button" style="background-color: #4070f4;" >Next</button>
                        <a href=""><button class="button" style="background-color: red;" >Cancel</button></a>
                      </td>
                    </tr>
                  </table>
                </div>
              </form>
          </div>
        </div>
    </div> 
    <br><br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo URLROOT;?>/js/payment.js" defer></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    <script>
        $(document).ready(function() {
            $("#hospitalSelect").change(function() {
                var hospitalId = $(this).val();
                var doctorId = <?php echo $data['doctor_data']->Doctor_ID; ?>;

                fetchScheduleDetails(hospitalId, doctorId, function(scheduleData) {
                    if (scheduleData && Array.isArray(scheduleData)) {
                        displayScheduleDetails(scheduleData);
                        updateHospitalCharges(scheduleData);
                    } else {
                        console.error("Invalid JSON response:", scheduleData);
                    }
                });
            });

            $(document).on('change', 'input[name="date"]', function() {
                var selectedDate = $(this).val();
                var selectedDay = selectedDate.split(',')[0];
                var hospitalId = $("#hospitalSelect").val();
                var doctorId = <?php echo $data['doctor_data']->Doctor_ID; ?>;
                fetchScheduleDetails(hospitalId, doctorId, function(scheduleData) {
                    updateTimeSlots(selectedDay, scheduleData);
                });
            });
        });

        function fetchScheduleDetails(hospitalId, doctorId, callback) {
            $.ajax({
                url: "<?php echo URLROOT;?>/patient/fetch_schedule_details",
                type: "GET",
                data: { hospital_id: hospitalId, doctor_id: doctorId },
                dataType: "json",
                success: function(scheduleData) {
                    callback(scheduleData); // Invoke the callback with the fetched data
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error fetching schedule details:", textStatus, errorThrown);
                }
            });
        }
        function displayScheduleDetails(scheduleData) {
            var dateContainer = $(".container-radio[name='date']");
            dateContainer.empty(); // Clear previous date options

            var timeContainer = $(".container-radio[name='time']");
            timeContainer.empty(); // Clear previous time slots

            var today = new Date();
            var daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

            // Loop through schedule data and populate date options and time slots
            for (var i = 0; i < scheduleData.length; i++) {
                var day = scheduleData[i].day_of_week;
                var startTime = scheduleData[i].start_time;
                var endTime = scheduleData[i].end_time;
                var hospitalCharge = scheduleData[i].hospital_charge;

                // Calculate the date for the current day in the coming week
                var currentDate = new Date();
                var dayIndex = daysOfWeek.indexOf(day);
                var currentdayIndex = today.getDay();
                if (dayIndex < currentdayIndex) {
                    currentDate.setDate(today.getDate() + (1 + dayIndex));
                } else if (dayIndex > currentdayIndex) {
                    currentDate.setDate(today.getDate() + (dayIndex - currentdayIndex));
                } else {
                    currentDate.setDate(today.getDate());
                }

                // Format the date as "Day, DD/MM/YYYY" (e.g., "Tuesday, 16/04/2024")
                var formattedDate = daysOfWeek[currentDate.getDay()] + ", " +
                    currentDate.getDate().toString().padStart(2, "0") + "/" +
                    (currentDate.getMonth() + 1).toString().padStart(2, "0") + "/" +
                    currentDate.getFullYear();

                // Create radio button for date option
                var dateRadio = $("<input>").attr({
                    type: "radio",
                    name: "date",
                    value: formattedDate // Set the value to the formatted date
                });

                var dateLabel = $("<span>").text(formattedDate); // Create span for date text

                var dateLabelContainer = $("<label>").append(dateRadio, dateLabel); // Combine radio and label

                dateContainer.append(dateLabelContainer); // Add date option to container
            }
        }

        function updateHospitalCharges(scheduleData) {
            var hospitalCharge = scheduleData[0].hospital_charge; // Assuming hospital charges are the same for all schedules
            $("#hospotal_charge").text("LKR " + hospitalCharge + ".00"); // Update hospital charges in the HTML
        }


        function updateTimeSlots(selectedDay,scheduleData) {
            var timeContainer = $(".container-radio[name='time']");
            timeContainer.empty(); // Clear previous time slots

            // Loop through time slot data and populate time slots
            for (var i = 0; i < scheduleData.length; i++) {
              if(scheduleData[i].day_of_week == selectedDay){
                  var startTime = scheduleData[i].start_time;
                  var endTime = scheduleData[i].end_time;

                  // Create radio button for time slot
                  var timeRadio = $("<input>").attr({
                      type: "radio",
                      name: "time",
                      value: startTime + " - " + endTime // Set the value to the start and end time
                  });

                  var timeLabel = $("<span>").text(startTime + " - " + endTime); // Create span for time slot text

                  var timeLabelContainer = $("<label>").append(timeRadio, timeLabel); // Combine radio and label

                  timeContainer.append(timeLabelContainer); // Add time slot to container
              }
                
            }
        }
    </script>

  </body>
</html>