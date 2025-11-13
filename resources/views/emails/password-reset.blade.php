<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif; color:#333333;">

<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="padding:40px 0; background-color:#f4f4f4;">
            <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

                <!-- Header -->
                <tr>
                    <td align="center" style="background-color:#0d6efd; padding:20px;">
                        <h1 style="margin:0; font-size:24px; color:#ffffff;">Password Reset Request</h1>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:40px 30px; text-align:left;">
                        <p style="margin:0 0 20px 0; font-size:16px; line-height:1.6;">
                            Hi {{ $user->name ?? 'there' }},
                        </p>

                        <p style="margin:0 0 20px 0; font-size:16px; line-height:1.6;">
                            We received a request to reset your password. If you didn’t make this request, you can safely ignore this email.
                        </p>

                        <p style="margin:0 0 30px 0; font-size:16px; line-height:1.6;">
                            To reset your password, click the button below:
                        </p>

                        <!-- Button -->
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:0 auto 30px auto;">
                            <tr>
                                <td align="center" bgcolor="#0d6efd" style="border-radius:6px;">
                                    <a href="{{ url("/reset-password?token=$token&email=$user->email") ?? '#' }}"
                                       style="display:inline-block; padding:12px 30px; font-size:16px; color:#ffffff; text-decoration:none; border-radius:6px; background-color:#0d6efd; font-weight:bold;"
                                    >
                                        Reset Password
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 20px 0; font-size:15px; line-height:1.6;">
                            Or copy and paste this link into your browser:
                        </p>

                        <p style="margin:0 0 20px 0; word-break:break-all; color:#0d6efd; font-size:14px;">
                            {{ url("/reset-password?token=$token&email=$user->email") ?? '#' }}
                        </p>

                        <p style="margin:30px 0 0 0; font-size:14px; line-height:1.6; color:#555555;">
                            This link will expire in 60 minutes.
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center" style="background-color:#f8f9fa; padding:20px; font-size:13px; color:#777777;">
                        <p style="margin:0;">If you have any questions, contact our support team at
                            <a href="mailto:support@yourapp.com" style="color:#0d6efd; text-decoration:none;">support@yourapp.com</a>.
                        </p>
                        <p style="margin:8px 0 0 0;">&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
