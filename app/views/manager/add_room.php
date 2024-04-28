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

   <title><?php echo SITENAME?>: Add Room</title>
</head>
<body>
<div class="container-signup" style="height: 350px; overflow: hidden;">
    <header>Add Room - Hospital</header>

    <form action="<?php echo URLROOT; ?>/manager/add_room" method="POST" style="height: 500px;">
        <div class="form first">
            <div class="details personal">
                <span class="title">Room Details</span>

                <div class="fields">
                    <div class="input-field" style="width: calc(70%);">
                        <label>Room Name*</label>
                        <input type="text" name="room_name" value="<?php echo $data['Room_Name'] ?>" required>
                        <span class="err-msg"><?php echo $data['Room_Name_err']; ?></span>
                    </div>
                    <!-- <div class="input-field">
                    </div>
                    <div class="input-field">
                    </div> -->
                </div>
            </div>

            <div class="buttons">
            <button type="reset" onclick="window.history.back()" >
                        <span class="btnText">Back</span>
                    </button>
                <button class="submit">
                    <span class="btnText">Add</span>
                </button>
            </div>
        </div>
    </form>
</div>


    <script src="<?php echo URLROOT; ?>/js/signup.js"></script>
</body>
</html>