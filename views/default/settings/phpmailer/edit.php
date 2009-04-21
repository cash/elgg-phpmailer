<?php
	$phpmailer_smtp = $vars['entity']->phpmailer_smtp;
	if (!isset($phpmailer_smtp)) $phpmailer_smtp = 0;
  $smtp_disabled = '';
	if (!$phpmailer_smtp) $smtp_disabled = 'disabled="disabled"';

	$phpmailer_host = $vars['entity']->phpmailer_host;
	if (!isset($phpmailer_host)) $phpmailer_host = '';

	$phpmailer_smtp_auth = $vars['entity']->phpmailer_smtp_auth;
	if (!isset($phpmailer_smtp_auth)) $phpmailer_smtp_auth = 0;
  $auth_disabled = '';
	if (!$phpmailer_smtp_auth) $auth_disabled = 'disabled="disabled"';


	$phpmailer_username = $vars['entity']->phpmailer_username;
	$phpmailer_password = $vars['entity']->phpmailer_password;

	$nonstd_mta = $vars['entity']->nonstd_mta;
	if (!isset($nonstd_mta)) $nonstd_mta = 0;

  // SMTP Settings
  echo '<p>'; 
  echo elgg_view('input/hidden', array('internalname' => 'params[phpmailer_smtp]', 'js' => 'id="params[phpmailer_smtp]"', 'value' => $phpmailer_smtp )); 
  echo "<input class='input-checkboxes' type='checkbox' value='' name='smtpcheckbox' onclick=\"phpmailer_smtp();\" ";
  if ($phpmailer_smtp) echo "checked='yes'";
  echo " />";
  echo ' ' . elgg_echo('phpmailer:smtp') . '<br/>';
  
  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . elgg_echo('phpmailer:host') . ': ';
	echo elgg_view('input/text', array(
								    'internalname' => 'params[phpmailer_host]',
									  'value' => $phpmailer_host,
									  'class' => ' ',
									  'js' => "id='params[phpmailer_host]' $smtp_disabled"
													) );

  echo '<br /><br />';
  echo elgg_view('input/hidden', array('internalname' => 'params[phpmailer_smtp_auth]', 'js' => 'id="params[phpmailer_smtp_auth]"', 'value' => $phpmailer_smtp_auth )); 
  echo "<input class='input-checkboxes' type='checkbox' value='' name='smpthauthcheckbox' id='smpthauthcheckbox' onclick=\"phpmailer_smtp_auth();\" ";
  if ($phpmailer_smtp_auth) echo "checked='yes'";
  echo " $smtp_disabled />";
  echo ' ' . elgg_echo('phpmailer:smtp_auth') . '<br/>';

  echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . elgg_echo('phpmailer:username') . ':&nbsp;&nbsp;';
	echo elgg_view('input/text', array(
								    'internalname' => 'params[phpmailer_username]',
									  'value' => $phpmailer_username,
									  'class' => ' ',
									  'js' => "id='params[phpmailer_username]' $auth_disabled"
													) );

  echo '<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . elgg_echo('phpmailer:password') . ':&nbsp;&nbsp;';
	echo elgg_view('input/text', array(
								    'internalname' => 'params[phpmailer_password]',
									  'value' => $phpmailer_password,
									  'class' => ' ',
									  'js' => "id='params[phpmailer_password]' $auth_disabled"
													) );
  echo '</p><br /><p>';
  
  // Non-standard MTA Settings
  echo elgg_view('input/hidden', array('internalname' => 'params[nonstd_mta]', 'js' => 'id="params[nonstd_mta]"', 'value' => $nonstd_mta )); 
  echo "<input class='input-checkboxes' type='checkbox' value='' name='mtacheckbox' onclick=\"document.getElementById('params[nonstd_mta]').value = 1 - document.getElementById('params[nonstd_mta]').value;\" ";
  if ($nonstd_mta) echo "checked='yes'";
  echo " />";
  echo ' ' . elgg_echo('phpmailer:nonstd_mta');
  echo '</p>';  
?>

<script type="text/javascript">
function phpmailer_smtp() {
 var state = document.getElementById('params[phpmailer_smtp]').value;
 state = 1 - state;
 document.getElementById('params[phpmailer_smtp]').value = state;

 if (state == 0) { 
  document.getElementById('params[phpmailer_host]').disabled = true;
  document.getElementById('smpthauthcheckbox').disabled = true;
  document.getElementById('params[phpmailer_username]').disabled = true;
  document.getElementById('params[phpmailer_password]').disabled = true;
 } else {
  document.getElementById('params[phpmailer_host]').disabled = false;
  document.getElementById('smpthauthcheckbox').disabled = false;
  if (document.getElementById('params[phpmailer_smtp_auth]').value == 1) {
   document.getElementById('params[phpmailer_username]').disabled = false;
   document.getElementById('params[phpmailer_password]').disabled = false;    
  }   
 }
}

function phpmailer_smtp_auth() {
document.getElementById('params[phpmailer_smtp_auth]').value = 1 - document.getElementById('params[phpmailer_smtp_auth]').value; 

document.getElementById('params[phpmailer_username]').disabled=!document.getElementById('params[phpmailer_username]').disabled;
document.getElementById('params[phpmailer_password]').disabled=!document.getElementById('params[phpmailer_password]').disabled;
}

</script>
