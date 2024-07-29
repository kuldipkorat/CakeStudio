document.getElementById('registrationForm').addEventListener('submit', function(event) {
    var isValid = true;

    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;

    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Clear previous error messages
    document.getElementById('nameError').textContent = '';
    document.getElementById('emailError').textContent = '';
    document.getElementById('passwordError').textContent = '';
    document.getElementById('confirmPasswordError').textContent = '';

    if (!name) {
        document.getElementById('nameError').textContent = 'Please enter your name.';
        isValid = false;
    }

    if (!emailPattern.test(email)) {
        document.getElementById('emailError').textContent = 'Please enter a valid email address.';
        isValid = false;
    }

    if (password.length < 6) {
        document.getElementById('passwordError').textContent = 'Password should be at least 6 characters.';
        isValid = false;
    }

    if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
        isValid = false;
    }

    // Prevent form submission if any validation fails
    if (!isValid) {
        event.preventDefault();
    }
});
