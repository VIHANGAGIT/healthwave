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
                <li><a href="../users/landing" >Home</a></li>
                <li><a href="#ourservices" class="home-active">Our Services</a></li>
                <li><a href="#about">About us</a></li>
                <li><a href="#footer">Contact</a></li>
                <li><a href="../lab/test_appt_management"> Services</a><li>
            </ul>
            
            
            <div class="profile">
                <i class='uil uil-sun' id="darkLight"></i>
                <img src="<?php echo URLROOT;?>/img/profile.png" alt="">
                <span>Hemadri Perera</span>
                <i class='bx bx-caret-down'></i>
            </div>

        </header>

        <div class="page-header pic4">
            <div class="home-text">
                <h1>Pharmacy Management</h1>
            </div>
        </div>

        <br>

        <div class="s2">
        <section class="services-data">
        <img src="<?php echo URLROOT;?>/img/Medical prescription-amico.png" alt="">
            <div class="services-data-text">
                <h1>View prescription online</h1>
                <p>With the centralized app, patients across Sri Lanka benefit from unparalleled convenience and efficiency in managing their healthcare needs, particularly through its advanced doctor appointment booking system. No longer do patients need to endure lengthy phone calls or crowded waiting rooms. By simply logging into the platform, they can swiftly schedule appointments with their preferred doctors, ensuring timely access to the care they need. Whether it's for routine check-ups or urgent consultations, the intuitive interface streamlines the entire process, allowing patients to select convenient time slots. By eliminating the hassle of traditional appointment booking methods, the platform empowers patients to take control of their healthcare journey, ultimately leading to improved patient satisfaction and better health outcomes.</p>
            </div>
        </section>
        </div>
        
        <br>

        <div class="s1">
        <section class="services-data ">
            <div class="services-data-text">
                <h1>Uplaod bill online</h1>
                <p>With our centralized app, patients in Sri Lanka also benefit from streamlined lab test booking and result delivery, revolutionizing the way they manage their health. Gone are the days of long wait times and cumbersome paperwork. Through our platform, patients can conveniently schedule lab tests at their preferred facilities with just a few clicks. Once the tests are completed, patients can securely access their results online, eliminating the need for multiple visits or phone calls to the hospital. This seamless process not only saves valuable time but also ensures faster access to crucial medical information. By empowering patients to effortlessly monitor their health status from anywhere, our app promotes proactive healthcare management and enhances overall well-being.</p>
            </div>
            <img src="<?php echo URLROOT;?>/img/upload.png" alt="">
        </section>
        </div>

        <br>
        

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

        
        <!-- link to JS-->
        <script src="<?php echo URLROOT;?>/js/landing.js" defer></script>
        </section>
        <br>


    </body>
</html>