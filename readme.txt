Instructions:

Put into mod and enable in the admin panel. It will override the default email notification handler. There are smtp settings and an end of line marker override
in the admin plugin settings.

To use gmail's smtp server, open start.php and find the commented out lines that
include ssl://smtp.gmail.com. Set your username and password here making sure to
uncomment all the lines. Also make sure to turn smtp on in the admin plugin settings.

This plugin can be easily expanded to handle html email or file attachments. See the PHPMailer code and documentation for information on that.

PHPMailer can be found at http://phpmailer.codeworxtech.com/