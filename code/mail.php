<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes manually
require 'E:\Xampp\htdocs\Example\PHPMailer-master\src\Exception.php';
require 'E:\Xampp\htdocs\Example\PHPMailer-master\src\PHPMailer.php';
require 'E:\Xampp\htdocs\Example\PHPMailer-master\src\SMTP.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';    // SMTP server for Gmail
    $mail->SMTPAuth   = true;                // Enable SMTP authentication
    $mail->Username   = 'khanjohnny465@gmail.com'; // SMTP username (your Gmail email)
    $mail->Password   = 'uvmj qugc aicc txyk'; // App password for Gmail
    $mail->SMTPSecure = 'tls';               // Enable TLS encryption (STARTTLS)
    $mail->Port       = 587;                 // TCP port to connect to

    // Recipients
    $mail->setFrom('khanjohnny465@gmail.com', 'Your Name');
    $mail->addAddress('muzzamilahmed7865@gmail.com'); // Add a recipient

    // Content
    $mail->isHTML(false);                                  // Set email format to plain text
    $mail->Subject = 'Random Message';
    $randomMessage = generateRandomMessage();
    $mail->Body    = $randomMessage;

    // Send the email
    $mail->send();
    echo 'Email sent successfully!';
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}

// Function to generate a random message
function generateRandomMessage() {
    $messages = array(
        "Hello, this is a random message!",
        "Just sending a quick message.",
        "How are you doing today?",
        "Did you know that elephants are the only animals that can't jump?",
        "Random fact: The longest word in the English language is pneumonoultramicroscopicsilicovolcanoconiosis."
    );

    $randomIndex = array_rand($messages);
    return $messages[$randomIndex];
}
?>
