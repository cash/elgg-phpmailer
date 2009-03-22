<?php

  /**
   * PHPMailer Plugin
   * @package PHPMailer
   * @license Lesser General Public License (LGPL)
   * @author Cash Costello
   * @copyright Cash Costello 2008
   **/
  
    /**
     * initialize the phpmailer plugin
     */    
    function phpmailer_init() 
    {
      register_notification_handler('email', 'phpmailer_notify_handler');        
    }
    
    /**
     * Send a notification via email using phpmailer
     *
     * @param ElggEntity $from The from user/site/object
     * @param ElggUser $to To which user?
     * @param string $subject The subject of the message.
     * @param string $message The message body
     * @param array $params Optional parameters (not used)
     * @return bool
     */
    function phpmailer_notify_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL) 
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
    
      if ($to->email=="")
        throw new NotificationException(sprintf(elgg_echo('NotificationException:NoEmailAddress'), $to->guid));      
         

      // set line ending if admin selected \n (if admin did not change setting, false is returned)
      if (get_plugin_setting('nonstd_mta','phpmailer'))
        $phpmailer->LE = "\n";
      else
        $phpmailer->LE = "\r\n";
         
      
      $to = $to->email;
      $from_email = phpmailer_extract_from_email();
		  $from_name = $site->name;
		  

      ////////////////////////////////////
      // Format message
      
      // need to revisit this
      $message = strip_tags($message); 

      $phpmailer->ClearAllRecipients();

      // Set the from name and email
      $phpmailer->From = $from_email;
      $phpmailer->FromName = $from_name;

      // Set destination address
      $phpmailer->AddAddress($to);
   
      $phpmailer->Subject = $subject;
      $phpmailer->Body = $message;
      
      $phpmailer->IsHTML(false);

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
    
    /**
     * Determine the best from email address
     *
     * @return string with email address
     */
    function phpmailer_extract_from_email()
    {
      global $CONFIG;
      
      $from_email = '';
      $site = get_entity($CONFIG->site_guid);
      // If there's an email address, use it - but only if its not from a user.
      if ((isset($from->email)) && (!($from instanceof ElggUser))) 
        $from_email = $from->email;
      // Has the current site got a from email address?
      else if (($site) && (isset($site->email))) 
        $from_email = $site->email;
      // If we have a url then try and use that.
      else if (isset($from->url)) 
      {
        $breakdown = parse_url($from->url);
        $from_email = 'noreply@' . $breakdown['host']; // Handle anything with a url
      }
      // If all else fails, use the domain of the site.
      else 
        $from_email = 'noreply@' . get_site_domain($CONFIG->site_guid); 

      return $from_email;      
    }
     
    register_elgg_event_handler('init','system','phpmailer_init');       
?>
