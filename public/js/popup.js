$("#show").click(function (event) {
    console.log('Button clicked');
    event.preventDefault();

    const showPopup = document.querySelector('#show');
    const popupContainer = document.querySelector('.popup-container');
    const closeBtn = document.querySelector('.close-btn');
    showPopup.onclick = () => {
        showAppointmentPopup();
        popupContainer.classList.add('active');
    }
    closeBtn.onclick = () => {
        popupContainer.classList.remove('active');
    }
});

// Function to show the popup and populate appointment data
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

// // Event listener for showing the popup when needed
// document.getElementById('show-popup-btn').addEventListener('click', showAppointmentPopup);
