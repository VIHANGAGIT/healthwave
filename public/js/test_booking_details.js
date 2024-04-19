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

    var timeContainer = $(".container-radio[name='time']");
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
        var dayIndex = daysOfWeek.indexOf(day);
        var currentdayIndex = today.getDay();
        if (dayIndex <= currentdayIndex) {
            change = currentdayIndex - dayIndex;
            currentDate.setDate(today.getDate() + (7-change));
        } else if (dayIndex > currentdayIndex) {
            currentDate.setDate(today.getDate() + (dayIndex - currentdayIndex));
        } else {
            // currentDate.setDate(today.getDate());
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
    var timeContainer = $(".container-radio[name='time']");
    timeContainer.empty(); // Clear previous time slots

    // Find the schedule data for the selected day
    var selectedSchedule = scheduleData.find(schedule => schedule.day_of_week === selectedDay);

    if (selectedSchedule && selectedSchedule.time_slots) {
        
        // Loop through the time slots for the selected day and populate time 
        for (var slot in selectedSchedule.time_slots) {

            var startTime = selectedSchedule.time_slots[slot].start_time.slice(0, 5);
            var endTime = selectedSchedule.time_slots[slot].end_time.slice(0, 5);

            // Create radio button for time slot
            var timeRadio = $("<input>").attr({
                type: "radio",
                name: "time",
                id: "app-time",
                value: startTime + " - " + endTime // Set the value to the start and end time
            });

            var timeLabel = $("<span>").text(startTime + " - " + endTime); // Create span for time slot text

            var timeLabelContainer = $("<label>").append(timeRadio, timeLabel); // Combine radio and label

            timeContainer.append(timeLabelContainer); // Add time slot to container

        }
    }else {
        // No schedule data found for the selected day
        timeContainer.append("<span>No time slots available for this day</span>");
    }
}