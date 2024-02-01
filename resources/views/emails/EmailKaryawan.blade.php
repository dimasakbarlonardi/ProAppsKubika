<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProApps Access Information</title>
    <style>
        body {
            box-sizing: border-box;
            margin: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            text-align: left;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-top: 6px solid #3498db;
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 15px;
            color: #555;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        .credentials {
            margin-top: 20px;
        }

        .credentials ul {
            list-style-type: none;
            padding: 0;
        }

        .credentials li {
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>ProApps Access Information</h1>

        <p>Dear Bapak/Ibu,</p>


        <p>You can access ProApps through the web using any browser, such as Internet Explorer, Mozilla Firefox, Safari, or Google Chrome. The web address is <a href="https://proapps.id" target="_blank">https://proapps.id</a>. Alternatively, you can download the app from the Play Store for Android or the App Store for iOS.</p>
        <div class="credentials">
            <p>Below is your ProApps login information:</p>
            <ul>
                <li><strong>Email:</strong> {{ $karyawan->email_karyawan }}</li>
                <li><strong>Password:</strong> password</li>
                <li><strong>Site:</strong> Kubikahomy</li>
                <li><strong>Access Role:</strong> Building Management</li>
            </ul>
            <p>(Please note: The password is the default; for security reasons, please change your password after the first login.)</p>
        </div>

        <p>Please let us know if you need any assistance.</p>

        <p>Thank you,</p>
        <p><strong>Regards,</strong><br>Tenant Relation</p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply.</p>
    </div>
</body>

</html>