// Selecting form and input elements
const form = document.querySelector("form");
const passwordInput = document.getElementById("password");
const passToggleBtn = document.getElementById("pass-toggle-btn");

// Function to display error messages
const showError = (field, errorText) => {
    field.classList.add("error");
    const errorElement = document.createElement("small");
    errorElement.classList.add("error-text");
    errorElement.innerText = errorText;
    field.closest(".form-group").appendChild(errorElement);
}

// Function to handle form submission
const handleFormData = (e) => {
    e.preventDefault();

    // Retrieving input elements
    const fullnameInput = document.getElementById("fullname");
    const emailInput = document.getElementById("email");
    const dateInput = document.getElementById("date");
    const genderInput = document.getElementById("gender");

    // Getting trimmed values from input fields
    const fullname = fullnameInput.value.trim();
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
    const date = dateInput.value;
    const gender = genderInput.value;

    // Regular expression pattern for email validation
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

    // Clearing previous error messages
    document.querySelectorAll(".form-group .error").forEach(field => field.classList.remove("error"));
    document.querySelectorAll(".error-text").forEach(errorText => errorText.remove());

    // Performing validation checks
    if (fullname === "") {
        showError(fullnameInput, "Enter your full name");
    }
    if (!emailPattern.test(email)) {
        showError(emailInput, "Enter a valid email address");
    }
    if (password === "") {
        showError(passwordInput, "Enter your password");
    }
    if (date === "") {
        showError(dateInput, "Select your date of birth");
    }
    if (gender === "") {
        showError(genderInput, "Select your gender");
    }

    // Checking for any remaining errors before form submission
    const errorInputs = document.querySelectorAll(".form-group .error");
    if (errorInputs.length > 0) return;

    // Submitting the form
    form.submit();
}

function toggleOtherDuration() {
    // Get the duration select and other duration input elements
    var durationSelect = document.getElementById('durationSelect');
    var otherDurationInput = document.getElementById('otherDurationInput');

    // Check if the selected value is empty (indicating "Other (type manually)")
    if (durationSelect.value === '') {
        // If "Other (type manually)" is selected, show the input field
        otherDurationInput.style.display = 'block';
    } else {
        // If any other option is selected, hide the input field
        otherDurationInput.style.display = 'none';
    }
}

function addRow() {
    // Clone the original treatment row
    var originalRow = document.querySelector('.treatment-row');
    var newRow = originalRow.cloneNode(true);

    // Clear input values in the new row
    newRow.querySelectorAll('input[type="text"]').forEach(input => {
        input.value = '';
    });

    // Clear select values in the new row
    newRow.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0; // Assuming the default value is the first option
    });

    // Update input IDs to make them unique
    var inputs = newRow.querySelectorAll('input[id], select[id]');
    inputs.forEach(function(input) {
        var oldId = input.getAttribute('id');
        var index = parseInt(oldId.match(/\d+/)[0]) + 1;
        var newId = oldId.replace(/\d+/, index);
        input.setAttribute('id', newId);
    });
    
    // Append the new row after the last treatment row
    var container = document.getElementById('treatment_table');
    container.appendChild(newRow);
}

function deleteRow() {
    // Get the container element that holds all treatment rows
    var container = document.getElementById('treatment_table');
    
    // Get all treatment rows
    var rows = container.querySelectorAll('.treatment-row');
    
    // Check if there's at least one row to delete
    if (rows.length > 1) {
        // Get the last treatment row
        var lastRow = rows[rows.length - 1];
        
        // Remove the last treatment row
        container.removeChild(lastRow);
    } else {
        // Optionally, provide a message or action if there's only one row left and cannot be deleted
        console.log("Cannot delete the last row.");
    }
}

// List of all frequency options
const frequencyOptions = [
    "a.c.", "a.m.", "aa.", "ad lib.", "alt.", "alt. die.", "amp", "ante", "applic.", "aq. or aqua", "aur.", "aurist.",
    "b.", "b.d.", "b.i.d.",
    "c.", "calid.", "cap.", "cib.", "co.", "collut.", "collyr.", "conc.", "crem.",
    "d.", "dest.", "dil.", "div.", "dol.urg", "dolent.part.", "dos.",
    "ex aq.", "ext.", "extemp.",
    "fort.",
    "garg.", "gtt. or guttae",
    "h.", "h.s.",
    "i.c.", "IM", "inf", "inj", "IV",
    "m. or mane", "m.d.", "m.d.u.", "MDI", "mist.", "mitt. or mitte",
    "n. or nocte", "n.et m.", "narist.", "NP or n.p.",
    "o.alt.hor.", "o.d.", "o.m.", "o.n.", "oculent.",
    "p.a.", "p.aeq.", "p.c. p.m.", "p.r.n.", "part. dolent.", "past.", "PR", "pulv.", "PV",
    "q.d.", "q.d.s.", "q.i.d.", "q.q.h.", "q.s.", "q12h", "q4h", "q6h", "qq.",
    "Rx",
    "s.o.s.", "SC", "SL", "ss.", "stat.",
    "t.d.d.", "t.d.s.", "t.i.d.", "tinct.", "trit. or triturate",
    "u.a.", "ung. or unguentum", "ut. direct or ut. dict.",
    "WSP",
    "YSP"
];

// Function to suggest frequency options as user types
function suggestFrequency(input, index) {
    const inputValue = input.value.toLowerCase();
    const suggestionsElement = input.nextElementSibling; // Get the suggestions div relative to the input

    suggestionsElement.innerHTML = '';

    const suggestions = frequencyOptions.filter(option =>
        option.toLowerCase().startsWith(inputValue)
    );

    suggestions.forEach(suggestion => {
        const div = document.createElement('div');
        div.textContent = suggestion;
        div.onclick = function() {
            input.value = suggestion;
            suggestionsElement.innerHTML = '';
        };
        suggestionsElement.appendChild(div);
    });
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

// Function to add a new row in the Recommended Tests section
function addTestRow() {
    // Clone the original test row
    var originalRow = document.querySelector('#tests-container select');
    var newRow = originalRow.cloneNode(true);

    // Append the new row after the last test row
    var container = document.getElementById('tests-container');
    container.appendChild(newRow);
}

// Function to delete the last row in the Recommended Tests section
function deleteTestRow() {
    // Get the container element that holds all test rows
    var container = document.getElementById('tests-container');
    
    // Get all test rows
    var rows = container.querySelectorAll('select');
    
    // Check if there's at least one row to delete
    if (rows.length > 1) {
        // Get the last test row
        var lastRow = rows[rows.length - 1];
        
        // Remove the last test row
        container.removeChild(lastRow);
    } else {
        // Optionally, provide a message or action if there's only one row left and cannot be deleted
        console.log("Cannot delete the last row.");
    }
}





  


// Toggling password visibility
passToggleBtn.addEventListener('click', () => {
    passToggleBtn.className = passwordInput.type === "password" ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
});

// Handling form submission event
form.addEventListener("submit", handleFormData);