<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap');
    </style>
</head>
<body style="background-color: #f3f4f6; font-family: 'Fredoka', 'Verdana', sans-serif; margin: 0; padding: 0;">
    
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f3f4f6;">
        <tr>
            <td style="padding: 20px 0;">
                
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 600px; width: 100%;">

                    <tr>
                        <td style="padding: 30px; background-color: #56B1F3; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;">IQRAIN</h1>
                            <p style="color: rgba(255,255,255,0.9); margin: 5px 0 0; font-size: 14px;">Reset Password Mentor</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px; color: #333333;">
                            <p style="font-size: 16px; margin-bottom: 20px;">
                                Halo, <strong>Mentor Hebat!</strong> 👋
                            </p>
                            <p style="font-size: 15px; line-height: 1.6; color: #555555; margin-bottom: 30px;">
                                Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda. Klik tombol di bawah ini untuk membuat kata sandi baru:
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}" style="display: inline-block; background-color: #FF87AB; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: bold; padding: 14px 30px; border-radius: 12px; box-shadow: 0 2px 4px rgba(255, 135, 171, 0.4);">
                                            Atur Ulang Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 14px; color: #999999; margin-top: 30px; text-align: center;">
                                Tautan ini hanya berlaku selama 60 menit.<br>
                                Jika ini bukan permintaan Anda, abaikan saja email ini.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px; background-color: #f9fafb; text-align: center; border-top: 1px solid #eeeeee;">
                            <p style="font-size: 12px; color: #aaaaaa; margin: 0;">
                                &copy; {{ date('Y') }} IQRAIN Education Platform.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>
</html>