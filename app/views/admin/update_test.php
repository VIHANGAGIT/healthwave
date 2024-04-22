<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title>Hospital Regisration</title>
</head>
<body>
    <div class="container-signup" style="height: 720px;" >
        <header>Update Test</header>

        <form action="<?php //echo URLROOT; ?>/admin/update_test" method="POST" style="height: 600px;">
            <div class="form first" >
                <div class="details personal">
                    <span class="title">Test Details</span>

                    <div class="fields">
                        <div class="input-field" style="width: calc(50% - 10px); margin-right: 10px;">
                            <label>Test Name*</label>
                            <input type="text" placeholder="Enter test name" name="testname" value="<?php //echo $data['T_name'] ?>" required>
                        </div>

                        

                        <div class="input-field" style="width: calc(50% - 10px);">
                            <label>Test Type*</label>

                            <select name="testtype" required>
                            <option selected value=" <?php //echo $data['T_type'] ?>" > <?php //echo ($data['T_type'] == '') ? 'Select test type' : $data['T_type'] ?></option>
                            <option>Blood Test</option>
                            <option>CT Scan</option>
                            <option>Urine Test</option>
                            <option>MRI Scan</option>
                                

                            </select>
                        </div>

                        

                       
                       
                    </div>
                </div>

                    <div class="buttons">
                        <button style="width: calc(50% - 10px);>
                            <span class="btnText">Clear</span>
                        </button>
                        
                        <button class="sumbit" style="width: calc(50% - 10px);  margin-left: 15px;">
                            <span class="btnText">Update</span>
                        </button>
                    </div>
                </div>
                   
                </div>
                
            </div>
        </form>
</div>

    <script src="<?php //echo URLROOT; ?>/js/signup.js"></script>
</body>
</html>