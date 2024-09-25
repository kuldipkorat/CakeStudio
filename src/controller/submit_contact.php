<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // This loads PHPMailer and Dotenv libraries

session_start();

// Load .env variables using phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'); // Adjust the path to point to your .env file
$dotenv->load();

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

    // Set up email details using PHPMailer
    $mail = new PHPMailer(true);  // Enable PHPMailer exception handling

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = getenv('SMTP_HOST');                    // Get SMTP host from .env
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = getenv('SMTP_USER');                    // Get SMTP username from .env
        $mail->Password   = getenv('SMTP_PASS');                    // Get SMTP password from .env
        $mail->SMTPSecure = getenv('SMTP_SECURE');                  // Encryption method (tls)
        $mail->Port       = getenv('SMTP_PORT');                    // TCP port from .env

        //Recipients
        $mail->setFrom($email, $name);                              // Sender's email and name
        $mail->addAddress('kudipkorat2@gmail.com', 'Cake Studio');  // Recipient's email and name

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = "New Contact Form Submission from $name";
        $mail->Body    = "
            <h2>New Message from Contact Form</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong><br>$message</p>
        ";
        $mail->AltBody = "Name: $name\nEmail: $email\nMessage: $message"; // Plain text version

        // Send email
        if ($mail->send()) {
            // Success, redirect with success message
            $_SESSION['success'] = 'Your message was successfully sent!';
            header('Location: ../../../../../CakeStudio/public/contact.php');
            exit;
        } else {
            throw new Exception('Email could not be sent.');
        }

    } catch (Exception $e) {
        // Failure, redirect with error message
        $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header('Location: ../../../../../CakeStudio/public/contact.php');
        exit;
    }

} else {
    // If form not submitted, redirect to contact page
    header('Location: ../../../../../CakeStudio/public/contact.php');
    exit;
}
