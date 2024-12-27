<!DOCTYPE html>
resources/views/emails\customer_thank_you.blade.php
<html>
<head>
    <title>Welcome to Our Platform</title>
</head>
<body>
    <h1>Thank You for Registering!</h1>
    <p>Dear {{ $customer->displayName() }},</p>
    <p>We are excited to have you onboard. Here are your login details:</p>
    <ul>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Please keep this information secure and do not share it with anyone.</p>
    <p>Best regards,<br>The Team</p>
</body>
</html>
