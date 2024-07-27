document.getElementById('registrationForm').addEventListener('submit', function(event) {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var email = document.getElementById('email').value;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        event.preventDefault();
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        event.preventDefault();
    }

    if (password.length < 6) {
        alert('Password should be at least 6 characters.');
        event.preventDefault();
    }
});

document.getElementById('signupForm').addEventListener('submit', function(event) {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var email = document.getElementById('email').value;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        event.preventDefault();
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        event.preventDefault();
    }

    if (password.length < 6) {
        alert('Password should be at least 6 characters.');
        event.preventDefault();
    }
});
