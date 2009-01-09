<?php
	$nonstd_mta = $vars['entity']->nonstd_mta;
	if (!isset($nonstd_mta)) $nonstd_mta = 0;
	if ($nonstd_mta) $checked = elgg_echo('phpmailer:nonstd_mta');
?>
<p>
  <?php 
    echo elgg_view('input/hidden', array('internalname' => 'params[nonstd_mta]', 'js' => 'id="params[nonstd_mta]"', 'value' => $nonstd_mta )); 
    echo elgg_view('input/checkboxes', array('options' => array(elgg_echo('phpmailer:nonstd_mta')), 'internalname' => 'mtacheckbox', 'value' => $checked, 'js' => 'onclick="document.getElementById(\'params[nonstd_mta]\').value = 1 - document.getElementById(\'params[nonstd_mta]\').value;"')); 
  ?>
</p>



