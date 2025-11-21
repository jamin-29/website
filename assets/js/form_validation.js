function validateForm() {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var message = document.getElementById('message').value;
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

    // Check if all fields are filled
    if (name === "" || email === "" || message === "") {
        alert("Please fill out all fields.");
        return false; // Prevent form submission
    }

    // Validate email format
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false; // Prevent form submission
    }

    return true; // Allow form submission if all checks pass
}
