<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form.Net - {{ $mailData['user_name'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #4caf50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .body {
            padding: 20px;
        }

        .body p {
            margin: 0 0 10px;
            line-height: 1.6;
            color: #333333;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #ffffff;
            background-color: #4caf50;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #999999;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to Farmnet</h1>
        </div>
        <div class="body">
            <p>Dear {{ $mailData['user_name'] }},</p>
            <p>Thank you for signing up with Farmnet! We are thrilled to have you on board. </p>
            <p>Below is your 4-character verification code: </p>
            <p style="text-align: center; font-size: 24px; font-weight: bold; color: #4caf50;">
                {{ $mailData['verifictionCode'] }}
            </p>
            <p>Please enter this code on the verification page to complete your registration.</p>
            <p>If you have any questions feel free to reply to this email.</p>
            <p>We are here to help you.</p>
            <p>Best regards,<br>Team Farmnet.</p>
        </div>
        <div class="footer">
            &copy; 2024 Form.Net. All rights reserved.
        </div>
    </div>
</body>

</html>
