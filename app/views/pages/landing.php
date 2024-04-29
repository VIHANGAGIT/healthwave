<?php 
    session_start();
    ?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Landing page </title>
        <link rel="stylesheet" href = "<?php echo URLROOT;?>/css/home_style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        
        <script src="<?php echo URLROOT;?>/js/light_mode.js" defer></script>
        <!-- Link Swiper's CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        
        


    </head>
    <body>
        <!-- navbar -->
    
        <header>
            <a href="../users/landing" class="logo_item">
                <img src="<?php echo URLROOT;?>/img/logo.png" alt=""> HealthWave
            </a>
            <ul class="prelog_navbar">
                <li><a href="#home" class="home-active">Home</a></li>
                <li><a href="#ourservices">Our Services</a></li>
                <li><a href="#about">About us</a></li>
                <li><a href="#footer">Contact</a></li>
                <li><a href="../lab/test_appt_management"> Services</a><li>
            </ul>
            
            <?php if(isset($_SESSION['userID'])): ?>
                
                <div class="profile" style="font-size: 18px;">
                    <i class='uil uil-sun' id="darkLight"></i>
                    <i class='uil uil-user'></i>
                    <span style="font-size: 15px; color: #181818;" ><?php echo $_SESSION['userName']?> </span>
                    <a href='../users/logout'><button class='button'>Logout</button></a>
                </div>
            <?php else: ?>
                    <div class="profile">
                        <a href='../users/login'><button class='button'>Login</button></a>
                    </div>

            <?php endif; ?>

        </header>

        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <div class="home-text">
                        <span>Get Quick </span>
                        <h1>Medical Services</h1>
                        <a href="#" class="btn">Get Services</a>
                    </div>
                    <img src="<?php echo URLROOT;?>/img/Health professional team-amico.png" alt="Slide 1">
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <div class="home-text">
                        <span>Get Quick </span>
                        <h1>Medical Services</h1>
                        <a href="#" class="btn">Get Services</a>
                    </div>
                    <img src="<?php echo URLROOT;?>/img/Hospital_building.png" alt="Slide 2">
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <div class="home-text">
                        <span>Get Quick </span>
                        <h1>Medical Services</h1>
                        <a href="#" class="btn">Get Services</a>
                    </div>
                    <img src="<?php echo URLROOT;?>/img/Pediatrician.png" alt="Slide 3">
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <!--Our services-->
        <section class="ourservices" id="ourservices">
            <div class="heading">
                <h1>We provide</h1>
            </div>

            <!--conatiner content-->
            <div class="ourservices-container">
                <!--box 1-->
                <div class="box">
                    <img src="<?php echo URLROOT;?>/img/patients.png" alt="">
                    <h2>Patient data management</h2>
                    <a href ="../users/about_patient_management"><i class="bx bx-right-arrow-alt"></i></a>
                </div>
                <!--box 2-->
                <div class="box">
                    <img src="<?php echo URLROOT;?>/img/doctor.png" alt="">
                    <h2>Doctor schedule management</h2>
                    <a href="../users/about_doctor_mgt"><i class="bx bx-right-arrow-alt"></i></a>
                </div>
                <!--box 3-->
                <div class="box">
                    <img src="<?php echo URLROOT;?>/img/hospital.png" alt="">
                    <h2>Hospital management</h2>
                    <a href="../users/about_hospital_mgt"><i class="bx bx-right-arrow-alt"></i></a>
                </div>
                <!--box 4-->
                <div class="box">
                    <img src="<?php echo URLROOT;?>/img/pharmacy.png" alt="">
                    <h2>Pharmacy orders</h2>
                    <a href="../users/about_pharmacy_mgt"><i class="bx bx-right-arrow-alt"></i></a>
                </div>
            </div>
        </section>

        <!--About us-->
        <section class="about" id="about">
            <img src="<?php echo URLROOT;?>/img/logo1.png" alt="">
            <div class="about-text">
                <span>About Us</span>
                <p>Our centralized app serves as a unified platform connecting patients, doctors, labs, and pharmacies across Sri Lanka.</p>
                <a href="../users/about_us" class="btn">Learn more</a>

            </div>
        </section>

        <!--Footer/contact-->
        <section class="footer" id="footer">
            <div class="footer-box">
                <a href="#" class="logo_item">
                    <img src="<?php echo URLROOT;?>/img/logo.png" alt=""> HealthWave
                </a>
                <p>No 35, Reid Avenue, Cololmbo 07</p>
                <div class="social">
                    <a href="#"><i class='bx bxl-facebook' ></i></a>
                    <a href="#"><i class='bx bxl-twitter' ></i></a>
                    <a href="#"><i class='bx bxl-instagram' ></i></a>
                    <a href="#"><i class='bx bxl-youtube' ></i></a>
                </div>
            </div>
            <div class="footer-box">
                <h2>Our services</h2>
                <a href="../users/about_patient_management">Patient data management</a>
                <a href="../users/about_doctor_mgt">Doctor schedule management</a>
                <a href="../users/about_hospital_mgt">Hospital management</a>
                <a href="../users/about_pharmacy_mgt">Pharmacy orders</a>
            </div>
            <div class="footer-box">
                <h2>Useful links</h2>
                <a href="#">Payment</a>
                <a href="../users/terms_and_cond">Terms Of Use</a>
            </div>
            <div class="footer-box">
                <h2>Newsletter</h2>
                <p>Get all discount news with Email Newsletter</p>
                <form action="">
                    <i class="bx bxs-envelope"></i>
                    <input type="email" name="" id="" placeholder="Enter your e-mail">
                    <i class='bx bx-arrow-back bx-rotate-180' ></i>

                </form>
            </div>
        </section>
        <br>

        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <!-- link to JS-->
        <script src="<?php echo URLROOT;?>/js/landing.js" defer></script>

    </body>
</html>