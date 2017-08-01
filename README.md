
INSTALLATION
==========================
- To use the plugin with composer, you only need install the plugin with composer:

```bash
composer require cash/elgg-phpmailer
```

The composer/installer package install the plugin in the elgg mod folder.

- Enable in the admin panel. It will override the default email
notification handler. There are smtp settings and an end of line marker override
in the admin plugin settings.


SETINGS
===========================
This plugin provides a complete set of parameters including:
1. Should this plugin override the default Elgg mail handler
2. Should this plugin use smtp to send mail rather than php's mail function
3. Should this plugin use authetication for smtp (username and password)
4. Should this plugin use a SSL connection for smtp
5. Is your Mail Transfer Agent non-standard in its line endings


TROUBLESHOOTING
===========================
If there are errors, they should be written to your server error log.


HOW TO CONFIRM THE PLUGIN IS WORKING
============================
Check the header of an email that was sent after the plugin was enabled. You
should see the sender as PHPMailer.


HOW TO USE THIS FROM ANOTHER PLUGIN
=============================
See the function phpmailer_send() in start.php.


PHPMailer can be found at https://github.com/PHPMailer/PHPMailer
