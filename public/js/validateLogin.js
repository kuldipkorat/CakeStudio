document.getElementById('loginForm').addEventListener('submit', function(event) {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var emailError = document.getElementById('emailError');
    var passwordError = document.getElementById('passwordError');
    var isValid = true;

    emailError.textContent = '';
    passwordError.textContent = '';

    // Validate email
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        emailError.textContent = 'Please enter a valid email address.';
        isValid = false;
    }

    // Validate password
    if (password.length < 6) {
        passwordError.textContent = 'Password should be at least 6 characters.';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});
