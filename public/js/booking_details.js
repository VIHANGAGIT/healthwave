$(document).ready(function() {
    $("#hospitalSelect").change(function() {
        var hospitalId = $(this).val();
        var selectedDate = null;

        fetchScheduleDetails(hospitalId, doctorId, selectedDate, function(scheduleData) {
            if (scheduleData && Array.isArray(scheduleData)) {
                displayScheduleDetails(scheduleData);
                updateHospitalCharges(scheduleData);
                calculateTotalPrice();
            } else {
                console.error("Invalid JSON response:", scheduleData);
            }
        });
    });

    $(document).on('change', 'input[name="date"]', function() {
        var selectedDate = $(this).val();
        var selectedDay = selectedDate.split(',')[0];
        var hospitalId = $("#hospitalSelect").val();
        fetchScheduleDetails(hospitalId, doctorId, selectedDate, function(scheduleData) {
            updateTimeSlots(selectedDay, scheduleData);
        });
    });
});

function calculateTotalPrice() {
    var doctorCharges = parseFloat(docCharges);
    var hospitalCharges = parseFloat($("#hospital_charge").text().replace("LKR ", ""));
    var serviceCharges = parseFloat("100.00"); // Assuming service charges are fixed
    var taxes = (doctorCharges + hospitalCharges + serviceCharges)*0.05 ; // Assuming taxes are fixed
    $("#price-value-tax").text("LKR " + taxes.toFixed(2));

    var totalPrice = doctorCharges + hospitalCharges + serviceCharges + taxes;
    $("#price-value-total").text("LKR " + totalPrice.toFixed(2));
}

function fetchScheduleDetails(hospitalId, doctorId, selectedDate, callback) {
    $.ajax({
        url: "http://localhost/healthwave/patient/fetch_schedule_details",
        type: "GET",
        data: { hospital_id: hospitalId, doctor_id: doctorId, selected_date: selectedDate},
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

    // var timeContainer = $(".container-radio[name='time']");
    // timeContainer.empty(); // Clear previous time slots
    var numContainer = $(".app_no");
    numContainer.empty(); // Clear previous app no

    var timeContainer = $(".time_slot");
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
        var currentTime = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dayIndex = daysOfWeek.indexOf(day);
        var currentdayIndex = today.getDay();
        if (dayIndex < currentdayIndex) {
            change = currentdayIndex - dayIndex;
            currentDate.setDate(today.getDate() + (7-change));
        } else if (dayIndex > currentdayIndex) {
            currentDate.setDate(today.getDate() + (dayIndex - currentdayIndex));
        } else {
            if(currentTime < startTime){
            currentDate.setDate(today.getDate());
            }else{
                currentDate.setDate(today.getDate() + 7);
            }
        }

        // Format the date as "Day, DD/MM/YYYY" (e.g., "Tue, 16/04/2024")
        var formattedDate = daysOfWeek[currentDate.getDay()] + ", " +
            currentDate.getDate().toString().padStart(2, "0") + "/" +
            (currentDate.getMonth() + 1).toString().padStart(2, "0") + "/" +
            currentDate.getFullYear();

        // Create radio button for date option
        var dateRadio = $("<input>").attr({
            type: "radio",
            name: "date",
            id: "app-date",
            value: formattedDate // Set the value to the formatted date
        });

        var dateLabel = $("<span>").text(formattedDate); // Create span for date text

        var dateLabelContainer = $("<label>").append(dateRadio, dateLabel); // Combine radio and label

        dateContainer.append(dateLabelContainer); // Add date option to container
    }
}

function updateHospitalCharges(scheduleData) {
    var hospitalCharge = scheduleData[0].hospital_charge; // Assuming hospital charges are the same for all schedules
    $("#hospital_charge").text("LKR " + hospitalCharge + ".00"); // Update hospital charges in the HTML
}


function updateTimeSlots(selectedDay, scheduleData) {
    // var numContainer = $(".app_no");
    // numContainer.empty(); // Clear previous app no

    // var timeContainer = $(".time_slot");
    // timeContainer.empty(); // Clear previous time slots
    var appNoSpan = document.querySelector('.app_no');
    var timeSlotSpan = document.querySelector('.time_slot');
    var timeContainer = $(".container[name='time']");

    // Find the schedule data for the selected day
    var selectedSchedule = scheduleData.find(schedule => schedule.day_of_week === selectedDay);

    if (selectedSchedule && selectedSchedule.next_appointment_number && selectedSchedule.next_slot) {

        var startTime = selectedSchedule.next_slot.start_time.slice(0, 5);
        var endTime = selectedSchedule.next_slot.end_time.slice(0, 5);

        var nextAppNo = selectedSchedule.next_appointment_number;

        appNoSpan.innerHTML = nextAppNo;
        timeSlotSpan.innerHTML = startTime + ' - ' + endTime;


        // // Create radio button for time slot
        // var timeRadio = $("<input>").attr({
        //     type: "radio",
        //     name: "time",
        //     id: "app-time",
        //     value: startTime + " - " + endTime // Set the value to the start and end time
        // });

        // var timeLabel = $("<span>").text(startTime + " - " + endTime); // Create span for time slot text

        // var timeLabelContainer = $("<label>").append(timeRadio, timeLabel); // Combine radio and label

        // timeContainer.append(timeLabelContainer); // Add time slot to container

        
    }else {
        // No schedule data found for the selected day
        timeContainer.append("<span>All Apoointments are booked</span>");
    }
}