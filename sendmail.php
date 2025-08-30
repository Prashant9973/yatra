<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $phone   = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? 'New Contact Form Message';
    $message = $_POST['message'] ?? '';

    if (!$name || !$email || !$message) {
        exit('❌ Please fill all fields.');
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'prashantkumarbkmg789@gmail.com';  // Your Gmail
       $mail->Password   = 'juasdchjbnvmpxtg';               // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & Receiver
        $mail->setFrom('prashantkumarbkmg789@gmail.com', 'Website Contact Form');
        $mail->addAddress('prashantkumarbkmg789@gmail.com', 'Admin'); // Where you want to receive mails
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Contact Form: $subject";
        $mail->Body    = "
            <h2>New Contact Form Submission</h2>
            <p><b>Name:</b> $name</p>
            <p><b>Email:</b> $email</p>
            <p><b>Phone:</b> $phone</p>
            <p><b>Message:</b><br>$message</p>
        ";
        $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";

        $mail->send();
        echo '✅ Message has been sent successfully!';
    } catch (Exception $e) {
        echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
