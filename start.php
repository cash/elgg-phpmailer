<?php

  /**
   * PHPMailer Plugin
   * @package PHPMailer
   * @license Lesser General Public License (LGPL)
   * @author Cash Costello
   * @copyright Cash Costello 2008-2009
   **/
   
    global $CONFIG;
   
    // include phpmailer wrapper for other plugins to use
    include $CONFIG->pluginspath . 'phpmailer/mail.php';
  
    /**
     * initialize the phpmailer plugin
     */    
    function phpmailer_init() 
    {
      if (get_plugin_setting('phpmailer_override','phpmailer') != 'disabled')
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
      
      if (!$from)
        throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'from'));
       
      if (!$to)
        throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'to'));
    
      if ($to->email=="")
        throw new NotificationException(sprintf(elgg_echo('NotificationException:NoEmailAddress'), $to->guid));      
         
         
      
      $from_email = phpmailer_extract_from_email();
      
      $site = get_entity($CONFIG->site_guid);
      $from_name = $site->name;
      
		  
      return phpmailer_send($from_email, $from_name, $to->email, '', $subject, $message);
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
