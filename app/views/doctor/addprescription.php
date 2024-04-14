<?php 
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  if(($_SESSION['userType']) != 'Doctor'){
    redirect("users/login");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Prescription Form</title>
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
      <h2>Doctor Prescription Form</h2>
      <div class="form-group fullname">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" placeholder="Enter patient's full name">
      </div>
      <div class="form-group age">
        <label for="patientAge">Patient's Age</label>
        <input type="text" id="patientAge" placeholder="Enter patient's age">
      </div>
     <!--- <div class="form-group medication">
        <label for="medication">Medication</label>
        <input type="text" id="medication" placeholder="Enter medication">
      </div>-->
      <div class="form-group diagnosis">
        <label for="diagnosis">Diagnosis</label>
        <input type="text" id="diagnosis" placeholder="Enter diagnosis">
      </div>
      <div class="form-group treatment" id="treatment_table">
        <label for="treatment">Treatment</label>
                <div id="treatment-row"  class="treatment-row">
                    <div class="form-group">
                        <label>Drug Name</label>
                        <input type="text" name="drug_name[]" placeholder="Enter drug name">
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" name="amount[]" placeholder="Enter amount" onkeypress="return isNumberKey(event)">
                    </div>
                    <div class="form-group">
                        <label>Unit</label>
                        <select name="amount_unit[]">
                          <option value="mg">mcg</option>
                            <option value="mg">mg</option>
                            <option value="g">g</option>
                            <option value="ml">ml</option>
                            <option value="tsp">tsp</option>
                            <option value="tsp">tablet</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Frequency</label>
                        <input type="text" name="frequency[]" id="frequency_input_0" placeholder="Enter frequency" onkeyup="suggestFrequency(this, 0)">
                        <div id="frequency_suggestions_0" class="suggestions"></div>
                    </div>
                    <div class="form-group">
                        <label>Duration</label>
                        <select name="duration[]">
                          <option value="3 days">1 day</option>
                          <option value="3 days">2 days</option>
                          <option value="3 days">3 days</option>
                            <option value="3 days">6 days</option>
                            <option value="1 week">1 week</option>
                            <option value="2 weeks">2 weeks</option>
                            <option value="2 weeks">3 weeks</option>
                            <option value="2 weeks">1 month</option>
                            <option value="2 weeks">2 months</option>
                            <option value="2 weeks">3 months</option>
                            <option value="2 weeks">4 months</option>
                            <option value="2 weeks">5 months</option>
                            <option value="2 weeks">6 months</option>
                        </select>
                      
                      
                    </div>
                </div>
                <!-- You can add more rows and delete newly added row dynamically if needed -->
              
      </div>

     
      <!-- <button type="button" onclick="addRow()">Add Row</button> -->
      
      <div class="button-container">
        <button id="add-row-btn" type="button" onclick="addRow()">Add Row</button>
        <button id="delete-row-btn" type="button" onclick="deleteRow()">Delete Row</button>
        
      </div>

      <div class="form-group tests" id="tests-container"> <!-- Correct ID here -->
        <label for="tests">Recommended Tests</label>
        <select name="tests[]" id="tests"> 
          <option value="blood test">Creatinine (with e GFR)</option>
          <option value="urine test">CRP</option>
          <option value="x-ray">Electrolytes</option>
          <option value="x-ray">ESR</option>
          <option value="x-ray">Fasting Blood Sugar</option>
          <option value="x-ray">Full Blood Count</option>
          <option value="x-ray">HBA1C</option>
          <option value="x-ray">Microalbumin (Urine)</option>
          <option value="x-ray">TSH</option>
          <option value="x-ray">Urea</option>
          <option value="x-ray">Urea & Electrolytes</option>
          <option value="x-ray">Urine FR</option>
          <option value="x-ray">Dengue Antigen</option>
        </select>
      </div>
      
      
      <div class="button-container">
        <button id="add-row-btn" type="button" onclick="addTestRow()">Add Row</button>
        <button id="delete-row-btn" type="button" onclick="deleteRow()">Delete Row</button>
        
      </div>
      
      <div class="form-group remarks">
        <label for="remarks">Remarks</label>
        <input type="text" id="remarks" placeholder="Enter remarks">
      </div>

      <div class="form-group referals">
        <label for="referals">Referals</label>
        <input type="text" id="referals" placeholder="Enter referals">
      </div>

      <div class="form-group date-signed">
        <label for="dateSigned">Date Signed</label>
        <input type="date" id="dateSigned">
      </div>
      <div class="form-group doctor-signature">
        <label for="doctorSignature">Doctor's Signature</label>
        <input type="text" id="doctorSignature" placeholder="Enter doctor's signature">
      </div>
      <div class="form-group submit-btn">
        <input type="submit" value="Submit">
      </div>
    </form>

    <script src="script.js"></script>
  </body>
</html>
