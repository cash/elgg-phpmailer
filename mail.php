<?php

  /**
   * PHPMailer Plugin - Wrapper functions for using PHPMailer
   * @package PHPMailer
   * @license Lesser General Public License (LGPL)
   * @author Cash Costello
   * @copyright Cash Costello 2008-2009
   **/

  /**
   * Send an email using phpmailer
   *
   * @param string $from       From address 
   * @param string $from_name  From name
   * @param string $to         To address
   * @param string $to_name    To name
   * @param string $subject    The subject of the message.
   * @param string $body       The message body
   * @param array  $bcc        Array of address strings
   * @param bool   $html       Set true for html email, also consider setting 
   *                           altbody in $params array
   * @param array  $files      Array of file descriptor arrays, each file array 
   *                           consists of full path and name 
   * @param array  $params     Additional parameters
   * @return bool
   */   
  function phpmailer_send($from, $from_name, $to, $to_name, $subject, $body, array $bcc = NULL, $html = false, array $files = NULL, array $params = NULL)
  {
      global $CONFIG;
      
      static $phpmailer;
    
      // Ensure phpmailer object exists
      if (!is_object($phpmailer) || !is_a($phpmailer, 'PHPMailer')) 
      {
        require_once $CONFIG->pluginspath . '/phpmailer/lib/class.phpmailer.php';
        require_once $CONFIG->pluginspath . '/phpmailer/lib/class.smtp.php';
        $phpmailer = new PHPMailer();
      }

      if (!$from)
        throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'from'));
       
      if (!$to)
        throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'to'));         

      if (!$subject)
        throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'subject'));         

      // set line ending if admin selected \n (if admin did not change setting, false is returned)
      if (get_plugin_setting('nonstd_mta','phpmailer'))
        $phpmailer->LE = "\n";
      else
        $phpmailer->LE = "\r\n";
         

      ////////////////////////////////////
      // Format message
      
      $phpmailer->ClearAllRecipients();
      $phpmailer->ClearAttachments();

      // Set the from name and email
      $phpmailer->From = $from;
      $phpmailer->FromName = $from_name;

      // Set destination address
      $phpmailer->AddAddress($to, $to_name);
      
      // set bccs if exists
      if ($bcc && is_array($bcc))
      {
        foreach ($bcc as $address)
          $phpmailer->AddBCC($address);
      }
      
      $phpmailer->Subject = $subject;

      if (!$html)
      {
        $body = strip_tags($body); 
        $phpmailer->IsHTML(false);
        if ($param && array_key_exists('altbody', $param))
          $phpmailer->AltBody = $param['altbody'];
      }
      else
      {
        $phpmailer->IsHTML(true);      
      }

      $phpmailer->Body = $body;
            
      if ($files && is_array($files))
      {
        foreach ($files as $file)
        {
          if (isset($file['path']))
            $phpmailer->AddAttachment($file['path'], $file['name']);
        }
      }

      $is_smtp   = get_plugin_setting('phpmailer_smtp','phpmailer');
      $smtp_host = get_plugin_setting('phpmailer_host','phpmailer');
      if ($is_smtp && isset($smtp_host))
      {
        $phpmailer->IsSMTP();
        $phpmailer->Host = $smtp_host;
        
        // uncomment these lines for gmail support and set username and password
        //$phpmailer->Host = "ssl://smtp.gmail.com";
        //$phpmailer->Port = 465;
        //$phpmailer->SMTPAuth = true;
        //$phpmailer->Username = ""; // gmail username (full email address?)
        //$phpmailer->Password = ""; // gmail password
      }
      else
      {
        // use php's mail      
        $phpmailer->IsMail();         
      }
      
      $return = $phpmailer->Send();
      if (!$return )
      {
        trigger_error('PHPMailer error: ' . $phpmailer->ErrorInfo, E_USER_WARNING);
      }   
      return $return;           
  } 

?>
