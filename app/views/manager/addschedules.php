<?php 
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  if(($_SESSION['userType']) != 'Manager'){
    redirect("users/login");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Schedules Form</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/form_style.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
    <script src="<?php echo URLROOT;?>/js/form.js" defer></script>

<!-- Fontawesome CDN Link For Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  </head>
  <body>
    <form action="thank-you.html">
      <h2>Add new Schedules</h2>
      <div class="form-group Doctorname">
        <label for="Doctorname">Doctor Name</label>
        <input type="text" id="Doctorname" placeholder="Enter Doctor's Name">
      </div>
      <div class="form-group RoomID">
        <label for="RoomeID">Room ID</label>
        <input type="text" id="Room ID" placeholder="Enter Room ID">
      </div>

      <div class="form-group date">
        <label for="date">Date</label>
        <input type="date" id="date">
      </div>
     <!--- <div class="form-group medication">
        <label for="medication">Medication</label>
        <input type="text" id="medication" placeholder="Enter medication">
      </div>-->
      
      <div class="form-group time" id="time_table">
        <label for="time">Time</label>
                <div id="time-row"  class="time-row">
                   
                    <div class="form-group">
                        <label>Start Time</label>
                        <select name="Time[]">
                          <option value="13:00:00">13:00:00</option>
                            <option value="13:15:00">13:15:00</option>
                            <option value="13:30:00">13:30:00</option>
                            <option value="14:00:00">14:00:00</option>
                            <option value="14:15:00">14:15:00</option>
                            <option value="14:30:00">14:30:00</option>
                        </select>
                    </div>
                    <div class="form-group time" id="time_table">
        
               
                   
                    <div class="form-group">
                        <label>End Time</label>
                        <select name="Time[]">
                          <option value="13:00:00">13:00:00</option>
                            <option value="13:15:00">13:15:00</option>
                            <option value="13:30:00">13:30:00</option>
                            <option value="14:00:00">14:00:00</option>
                            <option value="14:15:00">14:15:00</option>
                            <option value="14:30:00">14:30:00</option>
                        </select>
                    </div>              
     
      
     
      

     
      
      <div class="form-group submit-btn">
        <input type="submit" value="Submit">
      </div>
    </form>

    <script src="script.js"></script>
  </body>
</html>
