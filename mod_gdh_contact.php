<?php
/*
# mod_gdh_contact - Ajax based contact Module by Jorge Vega
# ------------------------------------------------------------------------
# Author    Jorge Vega jvega.perez86@gmail.com
# Copyright (C) 2015 Jorge Vega. All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
JHtml::_('jquery.framework');

$uniqid				= $module->id;
$name_text			= JText::_('NAME');
$email_text			= JText::_('EMAIL');
$subject_text		= JText::_('SUBJECT');
$msg_text			= JText::_('MESSAGE');
$send_msg			= JText::_('SEND_MESSAGE');

$minNumber			= $params->get('captcha_random_min');
$maxNumber			= $params->get('captcha_random_max');
$number1			= rand($minNumber, $maxNumber);
$number2			= rand($minNumber, $maxNumber);
$answer 			= $number1 + $number2;
$capt_secret		= $params->get('captcha_secret_key');
$capt_token 		= hash_hmac("sha1", $answer, $capt_secret);
$captcha			= $params->get('captcha', 1);
$captcha_question	= $number1 . " + " . $number2 . " = ?"; //$params->get('captcha_question');
//$captcha_answer		= $params->get('captcha_answer');

$document 			= JFactory::getDocument();
$document->addScript(JURI::base(true) . '/modules/mod_gdh_contact/assets/js/script.js');
$document->addStylesheet(JURI::base(true) . '/modules/mod_gdh_contact/assets/css/style.css');

// Include the helper.
require_once __DIR__ . '/helper.php';

require JModuleHelper::getLayoutPath('mod_gdh_contact', $params->get('layout', 'default'));