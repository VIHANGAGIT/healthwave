$("#show1").click(function (event) {
    console.log('Button clicked');
    event.preventDefault();

    const showPopup = document.querySelector('#show1');
    const popupContainer = document.querySelector('.popup-container-1');
    const popupBox = document.querySelector('.popup-box-1');
    const closeBtn = document.querySelector('.close-btn');

    // Function to show the popup
    function showAppointmentPopup() {
        // Get appointment data from the current page's form
        var patientName = document.getElementById('patient-name').value;
        var patientNIC = document.getElementById('patient-nic').value;
        var patientMobile = document.getElementById('patient-mobile').value;
        var patientEmail = document.getElementById('patient-email').value;
        var doctorName = document.getElementById('doctor-name').textContent;
        var doctorSpec = document.getElementById('doctor-spec').textContent;
        var hospitalSelect = document.getElementById('hospitalSelect');
        // var hospitalId = hospitalSelect.value;
        var hospitalName = hospitalSelect.options[hospitalSelect.selectedIndex].text;
        var appDate = document.querySelector('input[name="date"]:checked').value;
        var appTime = document.querySelector('input[name="time"]:checked').value;
        var totalPrice = document.getElementById('price-value-total').textContent;
    
        // Populate the appointment data in the popup
        document.getElementById('patient-name-popup').innerHTML = "<b>Patient Name:</b> " + patientName;
        document.getElementById('patient-nic-popup').innerHTML = "<b>Patient NIC:</b> " + patientNIC;
        document.getElementById('patient-mobile-popup').innerHTML = "<b>Mobile Number:</b> " + patientMobile;
        document.getElementById('patient-email-popup').innerHTML = "<b>Email Address:</b> " + patientEmail;
        document.getElementById('doctor-name-popup').innerHTML = "<b>Doctor Name:</b> " + doctorName;
        document.getElementById('doctor-spec-popup').innerHTML = "<b>Specialization:</b> " + doctorSpec;
        document.getElementById('hospital-name-popup').innerHTML = "<b>Hospital Name:</b> " + hospitalName;
        document.getElementById('app-date-popup').innerHTML = "<b>Date:</b> " + appDate;
        document.getElementById('app-time-popup').innerHTML = "<b>Time Slot:</b> " + appTime;
        document.getElementById('price-value-total-popup').innerHTML = "<b>Total Price:</b> " + totalPrice;
    
    }

    // Show popup when show button is clicked
    showPopup.onclick = () => {
        showAppointmentPopup();
        popupContainer.classList.add('active');

        // Add event listener to close popup when clicking outside
        document.addEventListener('click', closePopupOutside);
    }

    // Close popup function
    function closePopup() {
        popupContainer.classList.remove('active');
        document.removeEventListener('click', closePopupOutside); // Remove event listener
    }

    // Close popup when close button is clicked
    closeBtn.onclick = () => {
        closePopup();
    }

    // Close popup when clicking outside the popup box
    function closePopupOutside(event) {
        if (!popupBox.contains(event.target) && event.target !== showPopup) {
            closePopup();
        }
    }
});

$("#show2").click(function (event) {
    console.log('Button clicked');
    event.preventDefault();

    const showPopup = document.querySelector('#show2');
    const popupContainer = document.querySelector('.popup-container-2');
    const popupBox = document.querySelector('.popup-box-2');
    const closeBtn = document.querySelector('.close-btn');

    // Function to show the popup
    function showAppointmentPopup2() {
        // Get appointment data from the current page's for
        var doctorName = document.getElementById('doctor-name').textContent;
        var doctorSpec = document.getElementById('doctor-spec').textContent;
        var doctorGender = document.getElementById('doctorGender').value;
        var doctorSlmc = document.getElementById('doctorSLMC').value;


        document.getElementById('doctor-name-popup-2').value = doctorName;
        document.getElementById('doctor-spec-popup-2').value = doctorSpec;
        document.getElementById('doctor-gender-popup').value = doctorGender;
        document.getElementById('doctor-slmc-popup').value = doctorSlmc;
    
    }

    // Show popup when show button is clicked
    showPopup.onclick = () => {
        showAppointmentPopup2();
        popupContainer.classList.add('active');

        // Add event listener to close popup when clicking outside
        document.addEventListener('click', closePopupOutside);
    }

    // Close popup function
    function closePopup() {
        popupContainer.classList.remove('active');
        document.removeEventListener('click', closePopupOutside); // Remove event listener
    }

    // Close popup when close button is clicked
    closeBtn.onclick = () => {
        closePopup();
    }

    // Close popup when clicking outside the popup box
    function closePopupOutside(event) {
        if (!popupBox.contains(event.target) && event.target !== showPopup) {
            closePopup();
        }
    }
});

$("#cancel").click(function (event) {
    event.preventDefault();
    window.location.href = '/healthwave/patient/doc_booking';
});

