
INSTALLATION
==========================
Put into mod and enable in the admin panel. It will override the default email notification handler. There are smtp settings and an end of line marker override
in the admin plugin settings.


GMAIL SMTP
===========================
To use gmail's smtp server, open start.php and find the commented out lines that
include ssl://smtp.gmail.com. Set your username and password here making sure to
uncomment all the lines. Also make sure to turn smtp on in the admin plugin settings.


SMTP AUTHENTICATION
===========================
If your isp requires authentication for smtp, edit start.php to add your username and password and turn smtp auth on. This is in the gmail section. You have uncomment those three lines and set their values.


TROUBLESHOOTING
===========================
If there are errors, they should be written to your server error log.


HOW TO CONFIRM THE PLUGIN IS WORKING
============================
Check the header of an email that was sent after the plugin was enabled. You should see the sender as PHPMailer.


EXTENDING PLUGIN
===========================
This plugin can be easily expanded to handle html email or file attachments. See the PHPMailer code and documentation for information on that.


PHPMailer can be found at http://phpmailer.codeworxtech.com/