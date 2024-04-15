<?php session_start() ?>
<?php require_once('layout/header.php'); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
</head>
<style>
    form {
        display: flex;
        flex-flow: column;
        justify-content: center;
        align-items: center;
    }

    .form-group {
        padding: 10px;
        width: 650px;
    }

    .form-group input {
        padding: 5px 0;
        width: 100%;
    }

    textarea {
        width: 100%;
    }

    button {
        padding: 10px 50px;
        border-radius: 5px;
        color: white;
        background-color: red;
        border: none;
        outline: 0;
    }

    button:hover {
        opacity: 0.7;
        cursor: pointer;
    }

    center {
        font-size: 20px;
        font-weight: bold;
        color: green;
        padding: 20px;
    }
</style>

<body>
    <h2 style="text-align: center;">Hãy liên hệ với chúng tôi nếu các bạn gặp các vấn đề trên Website</h2>
    <form method="POST" action="" onsubmit="sendEmail(); reset(); return false;">
        <div class="form-group">
            <label>Tên của bạn:</label>
            <input type="text" name="name" required="required" />
        </div>
        <div class="form-group">
            <label>Tên Gmail:</label>
            <input type="email" name="email" required="required" />
        </div>
        <div class="form-group">
            <label>Nội dung email:</label>
            <textarea name="message" id="" cols="30" rows="10"></textarea>
        </div>
        <button name="send" type="submit"> Send</button>
    </form>

    <?php

    require_once('layout/header.php');

    // Include PHPMailer library
    require "PHPMailer-master/src/PHPMailer.php";
    require "PHPMailer-master/src/SMTP.php";
    require 'PHPMailer-master/src/Exception.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Assign form data to variables
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        // Create a new PHPMailer instance
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            // Configure SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nguyenvantan1k98@gmail.com';
            $mail->Password = 'iysormyrjnqjxybh';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Set sender
            $mail->setFrom('nguyenvantan1k98@gmail.com');

            // Add recipient
            $mail->addAddress($email);

            // Set email content as HTML
            $mail->isHTML(true);

            // Set email subject and body
            $mail->Subject = "Email Confirmation";
            $mail->Body = "Xin chào: $name,<br><br>Nội dung phản hồi: $message<br><br>Cảm ơn bạn đã đóng góp cho chúng tôi!";

            // Send email
            $mail->send();

            // Redirect after successful sending
            echo '<script>alert("Send Successfully"); document.location.href = "sendMail.php";</script>';
        } catch (Exception $e) {
            // Handle exceptions
            echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
        }
    }
    ?>
</body>
<?php require_once('layout/footer.php'); ?>

</html>