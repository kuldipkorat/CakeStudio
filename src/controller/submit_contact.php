<?php
// Start session (if required for feedback messages)
session_start();

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve and sanitize the form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Validate the form data
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['error'] = 'All fields are required!';
        header('Location: ../../../../../CakeStudio/public/contact.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format!';
        header('Location: ../../../../../CakeStudio/public/contact.php');
        exit;
    }

    // Set up email details
    $to = "kudipkorat2@gmail.com";  // Replace with your actual email
    $subject = "New Contact Form Submission from $name";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $emailContent = "
        <h2>New Message from Contact Form</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Message:</strong><br>$message</p>
    ";

    // Attempt to send the email
    if (mail($to, $subject, $emailContent, $headers)) {
        // Success, redirect with success message
        $_SESSION['success'] = 'Your message was successfully sent!';
        header('Location: ../../../../../CakeStudio/public/contact.php');
        exit;
    } else {
        // Failure, redirect with error message
        $_SESSION['error'] = 'There was an issue sending your message. Please try again later.';
        header('Location: ../../../../../CakeStudio/public/contact.php');
        exit;
    }

} else {
    // If form not submitted, redirect to contact page
    header('Location: ../../../../../CakeStudio/public/contact.php');
    exit;
}
?>
