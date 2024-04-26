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
    });

    $(document).on('change', 'input[name="date"]', function() {
        var selectedDate = $(this).val();
        var testId = $("#testId").val();
        var hospitalId = $("#hospitalSelect").val();
        fetchScheduleDetails(hospitalId, testId, selectedDate, function(scheduleData) {
            updateTimeSlots(scheduleData);
        });
    });
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
        type: "POST",
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

function updateTimeSlots(scheduleData) {
    var timeContainer = $(".container-radio[name='time']");
    timeContainer.empty(); // Clear previous time slots

    // Check if scheduleData is an object or an array
    if (Array.isArray(scheduleData)) {
        // If scheduleData is an array, iterate over each time slot object
        for (var i = 0; i < scheduleData.length; i++) {
            var timeSlot = scheduleData[i];
            var startTime = timeSlot.start_time;
            var endTime = timeSlot.end_time;

            // Create radio button for time slot
            var timeRadio = $("<input>").attr({
                type: "radio",
                name: "time",
                id: "app-time-",
                value: startTime + " - " + endTime
            });

            var timeLabel = $("<span>").text(startTime + " - " + endTime); 

            var timeLabelContainer = $("<label>").append(timeRadio, timeLabel);

            timeContainer.append(timeLabelContainer);
        }
    } else {
        // If scheduleData is an object, like in this format {"0": {...}, "1": {...}}
        // Iterate over each key in the object and access the corresponding time slot object
        Object.keys(scheduleData).forEach(function(key) {
            var timeSlot = scheduleData[key];
            var startTime = timeSlot.start_time;
            var endTime = timeSlot.end_time;

            // Create radio button for time slot
            var timeRadio = $("<input>").attr({
                type: "radio",
                name: "time",
                id: "app-time-",
                value: startTime + " - " + endTime 
            });

            var timeLabel = $("<span>").text(startTime + " - " + endTime); 

            var timeLabelContainer = $("<label>").append(timeRadio, timeLabel); 

            timeContainer.append(timeLabelContainer);
        });
    }
}