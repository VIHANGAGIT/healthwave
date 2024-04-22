<?php 
  if(($_SESSION['userType']) != 'Doctor'){
    redirect("users/login");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo SITENAME; ?>: Past Consultations</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/style2.css" />
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
  </head>
  <body>

      <div class="popup-container-4 ">
        <div class="popup-box-4">
            <h1>Consultation Details</h1><br>
            <hr>
            <table style="width: 95%;">
              
              <tr>
                <td class="popup-data">
                  <br>
                  <span class="category" >Patient Name: </span><span id="patient-name-popup-4">Steven Spilberg</span>
                  <br>
                  <span class="category">Gender: </span> <span id="patient-gender-popup-4">Male</span>
                  <br>
                  <span class="category">Age: </span> <span id="patient-age-popup-4">55</span>
                  <br>
                </td>
                <td class="popup-data">
                  <span class="category">Blood Group: </span> <span id="patient-blood-popup-4">A+</span>
                  <br>
                  <span class="category">Allergies: </span> <span id="patient-allergies-popup-4">Penicillin antibiotics</span>
                  <br>
                  </td>
              </tr>
              <tr>
                <td class="popup-data" colspan="2">
                    <span class="category">Comments: </span> <span id="patient-comments-popup-4">He is making impressive progress and should continue with the current regimen for optimal results. Encouragement to maintain the good work is recommended.</span>
                </td>
              </tr>
              <tr>
                <td class="popup-data" colspan="2">
                    <br><button class="close-btn btn" id="pay" >Prescription</button>
                </td>
              </tr>
            </table>
        </div>
    </div>

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
              <a href="" class="link flex">
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
            <li class="item">
              <a href="../doctor/schedules" class="link flex">
                <i class="uil uil-calendar-alt"></i>
                <span>Schedules</span>
              </a>
            </li>
            <li class="item ">
              <a href="../doctor/consultations" class="link flex">
              <i class="uil uil-history"></i>

                <span>Past Consultations</span>
              </a>
            </li>

            <li class="item active">
              <a href="../doctor/ongoing_consults" class="link flex">
                <i class="uil uil-stethoscope"></i>
                <span>Ongoing Consultations</span>
              </a>
            </li>
          </ul>

          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="../doctor/profile" class="link flex">
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
        <section class="table-wrap" >
            <div class="table-container">
                <h1>Add Prescription</h1>
                <hr><br>
                <div class="prescription">
                    <form action="add_prescription" method="POST">
                    <table style="width: 100%;" >
                        <input type="hidden" name="patient_id" value="<?php echo $data['patient']->Patient_ID ?>">
                        <input type="hidden" name="res_id" value="<?php echo $data['res_id']?>">
                        <tr>
                            <td>
                                <div class="form-group fullname">
                                    <label>Patient Name</label>
                                    <input type="text" name="patientName" value="<?php echo $data['patient']->First_Name.' '.$data['patient']->Last_Name ?>" disabled>
                                </div>
                            </td>
                            <td>
                                <div class="form-group age">
                                    <label>Patient's Age</label>
                                    <input type="text" name="patientAge" value="<?php echo $data['patient']->Age ?>" disabled>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-group diagnosis">
                                    <label for="diagnosis">Diagnosis</label>
                                    <textarea id="diagnosis" name="diagnosis" placeholder="Enter Diagnosis" rows="4"></textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-group treatment" id="treatment_table">
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
                                              <?php foreach ($data['durations'] as $duration): ?>
                                                <option value="<?php echo $duration; ?>"><?php echo $duration; ?></option>
                                              <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="button-container">
                                    <button id="add-row-btn" type="button" class="button" onclick="addRow()">Add</button>
                                    <button id="delete-row-btn" type="button" class="button red" onclick="deleteRow()">Delete</button>
                                </div>
                                <div class="form-group tests" id="tests-container"> <!-- Correct ID here -->
                                    <label for="tests">Recommended Tests</label>
                                    <select name="tests[]" id="tests"> 
                                    <option value="">Select a test</option>
                                    <?php foreach ($data['tests'] as $test): ?>
                                        <option value="<?php echo $test->Test_ID; ?>"><?php echo $test->Test_Name; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="button-container">
                                    <button id="add-row-test-btn" type="button" class="button" >Add</button>
                                    <button id="delete-row-test-btn" type="button" class="button red">Delete</button>
                                </div>
                                
                                <div class="form-group remarks">
                                    <label for="remarks">Remarks</label>
                                    <textarea id="remarks" name="remarks" placeholder="Enter Remarks" rows="4"></textarea>
                                </div>

                                <div class="form-group referals">
                                    <label for="referals">Referrals</label>
                                    <textarea id="referals" name="referals" placeholder="Enter referals" rows="4"></textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-group submit-btn">
                                    <button class="button" >Submit</button>
                                    <button class="button" style="background-color: red;">Cancel</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </section><br>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?php echo URLROOT;?>/js/prescription.js" defer></script>
  </body>
</html>