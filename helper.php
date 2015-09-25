<?php
/*
# mod_gdh_contact - Ajax based contact Module by Jorge Vega
# ------------------------------------------------------------------------
# Author    Jorge Vega jvega.perez86@gmail.com
# Copyright (C) 2015 Jorge Vega. All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

class modGDHcontactHelper
{
	public static function getAjax()
	{
		jimport('joomla.application.module.helper');
		$input  			= JFactory::getApplication()->input;
		$module 			= JModuleHelper::getModule('gdh_contact');
		$params 			= new JRegistry();
		$params->loadString($module->params);

		$mail 				= JFactory::getMailer();

		$success 			= JText::_('SUCCESS_NOTICE'); // $params->get('success');
		$failed 			= JText::_('FAILED_NOTICE'); // $params->get('failed');
		$recipient 			= $params->get('email');
		$failed_captcha 	= JText::_('WRONG_CAPTCHA'); // $params->get('failed_captcha');

		
		$captcha			= $params->get('captcha', 1);
		$capt_secret		= $params->get('captcha_secret_key');
		/*
		$captcha_question	= $params->get('captcha_question');
		$captcha_answer		= $params->get('captcha_answer');
		*/

		//inputs
		$inputs 			= $input->get('data', array(), 'ARRAY');

		foreach ($inputs as $input) {
			
			if( $input['name'] == 'email' )
			{
				$email 			= $input['value'];
			}

			if( $input['name'] == 'name' )
			{
				$name 			= $input['value'];
			}

			if( $input['name'] == 'subject' )
			{
				$subject 			= $input['value'];
			}

			if( $input['name'] == 'message' )
			{
				$message 			= nl2br( $input['value'] );
			}

			if($captcha) {
				if( $input['name'] == 'captcha' )
				{
					$captcha_answer		= $input['value'];
				}
				if( $input['name'] == 'capt_token' )
				{
					$capt_token 		= $input['value'];
				}
			}

		}

		if($captcha) {
			if (hash_hmac("sha1", $captcha_answer, $capt_secret) != $capt_token) {
				return '<p class="gdh_qc_warn">' . $failed_captcha . '</p>';
			}
		}

		$sender 		= array($email, $name);	
		$mail->setSender($sender);
		$mail->addRecipient($recipient);
		$mail->setSubject($subject);
		$mail->isHTML(true);
		$mail->Encoding = 'base64';	
		$mail->setBody($message);

		if ($mail->Send()) {

            $minNumber			= $params->get('captcha_random_min');
            $maxNumber			= $params->get('captcha_random_max');
            $number1			= rand($minNumber, $maxNumber);
            $number2			= rand($minNumber, $maxNumber);
            $answer 			= $number1 + $number2;
            $capt_secret		= $params->get('captcha_secret_key');
            $capt_token 		= hash_hmac("sha1", $answer, $capt_secret);
            $captcha			= $params->get('captcha', 1);
            $captcha_question	= $number1 . " + " . $number2 . " = ?";

            $result = '{'.
                '"nameCaption": "'. JText::_('NAME') .'", '.
                '"emailCaption": "'. JText::_('EMAIL') .'", '.
                '"subjectCaption": "'. JText::_('SUBJECT') .'", '.
                '"messageCaption": "'. JText::_('MESSAGE') .'", '.
                '"newCaptcha": "'. $captcha_question .'", '.
                '"newCaptchaToken": "'. $capt_token .'", '.
                '"successNotice": "'. '<p class=\"gdh_qc_success\">'. $success .'</p>' .'"}';

            return $result;
			// return '<p class="gdh_qc_success">' . $success . '</p>';
		} else {
			return '<p class="gdh_qc_warn">' . $failed . '</p>';
		}
	}
}