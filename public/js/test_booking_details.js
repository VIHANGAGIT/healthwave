$(document).ready(function() {
    $("#hospitalSelect").change(function() {
        var hospitalId = $(this).val();
        var testId = $("#testId").val();
        // var selectedDate = null;
        populateDatesForComingWeek();
        fetchPrices(hospitalId, testId, function(prices) {
            if (prices) {
                calculateTotalPrice(prices); // Moved this line inside the success callback
            } else {
                console.error("Invalid JSON response:", prices);
            }
        });

        // fetchScheduleDetails(hospitalId, testId, selectedDate, function(scheduleData) {
        //     if (scheduleData && Array.isArray(scheduleData)) {
        //         displayScheduleDetails(scheduleData);
        //         updateHospitalCharges(scheduleData);
        //         calculateTotalPrice();
        //     } else {
        //         console.error("Invalid JSON response:", scheduleData);
        //     }
        // });
    });

    // $(document).on('change', 'input[name="date"]', function() {
    //     var selectedDate = $(this).val();
    //     var selectedDay = selectedDate.split(',')[0];
    //     var hospitalId = $("#hospitalSelect").val();
    //     fetchScheduleDetails(hospitalId, doctorId, selectedDate, function(scheduleData) {
    //         updateTimeSlots(selectedDay, scheduleData);
    //     });
    // });
});

function populateDatesForComingWeek() {
    var dateContainer = $(".container-radio[name='date']");
    dateContainer.empty();

    var currentDate = new Date();
    currentDate.setDate(currentDate.getDate() + 1); // Start from tomorrow

    var daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    for (var i = 0; i < 7; i++) { // Loop for 7 days
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

        dateContainer.append(dateLabelContainer);

        currentDate.setDate(currentDate.getDate() + 1); // Move to the next day
    }
}

function fetchPrices(hospitalId, testId, callback) {
    $.ajax({
        url: "http://localhost/healthwave/patient/fetch_test_prices",
        type: "POST",
        data: { hospital_id: hospitalId, test_id: testId},
        dataType: "json",
        success: function(prices) {
            callback(prices); // Invoke the callback with the fetched data since javascript is asynchronous
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error fetching price details:", textStatus, errorThrown);
        }
    });
}

function calculateTotalPrice(prices) {
    var testCharges = parseFloat(prices.Price);
    $("#price-value-test").text("LKR " + testCharges.toFixed(2));

    var tax = parseFloat(prices.tax);
    $("#price-value-tax").text("LKR " + tax.toFixed(2));

    var totalPrice = parseFloat(prices.totalPrice);
    $("#price-value-total").text("LKR " + totalPrice.toFixed(2));
}

function fetchScheduleDetails(hospitalId, testId, selectedDate, callback) {
    $.ajax({
        url: "http://localhost/healthwave/patient/fetch_test_schedule_details",
        type: "GET",
        data: { hospital_id: hospitalId, test_id: testId, selected_date: selectedDate},
        dataType: "json",
        success: function(scheduleData) {
            callback(scheduleData); // Invoke the callback with the fetched data since javascript is asynchronous
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