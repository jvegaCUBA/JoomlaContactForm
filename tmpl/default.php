<?php
/*
# mod_gdh_contact - Ajax based contact Module by Jorge Vega
# ------------------------------------------------------------------------
# Author    Jorge Vega jvega.perez86@gmail.com
# Copyright (C) 2015 Jorge Vega. All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div id="gdh_contact<?php echo $uniqid ?>" class="gdh_contact">
	<div id="gdh_qc_status"></div>
	<form id="gdh-contact-form">
		<div class="row-fluid">
			<div class="span4">
                <div class="input_wrap">
                    <input type="text" name="name" id="name" onfocus="if (this.value=='<?php echo $name_text ?>') this.value='';"
                    onblur="if (this.value=='') this.value='<?php echo $name_text ?>';" value="<?php echo $name_text ?>" required />
                </div>
            </div>
			<div class="span4">
                <div class="input_wrap">
                    <input type="email" name="email" id="email" onfocus="if (this.value=='<?php echo $email_text ?>') this.value='';"
                    onblur="if (this.value=='') this.value='<?php echo $email_text ?>';" value="<?php echo $email_text ?>" required />
			    </div>
			</div>
			<div class="span4">
                <div class="input_wrap">
                    <input type="text" name="subject" id="subject" onfocus="if (this.value=='<?php echo $subject_text ?>') this.value='';"
                    onblur="if (this.value=='') this.value='<?php echo $subject_text ?>';" value="<?php echo $subject_text ?>" />
			    </div>
			</div>
		</div>
		<div class="row-fluid" style="margin-bottom: 0">
			<div class="span12">
                <div class="input_wrap">
                    <textarea name="message" id="message" onfocus="if (this.value=='<?php echo $msg_text ?>') this.value='';"
                    onblur="if (this.value=='') this.value='<?php echo $msg_text ?>';" cols="" rows="" required ><?php echo $msg_text ?></textarea>
			    </div>
			</div>
		</div>
        <div class="row-fluid">
            <div class="span6">
                <div class="input_wrap">
                    <?php if($captcha) { ?>
                        <input type="text" id="captcha" name="captcha" placeholder="<?php echo $captcha_question ?>" required class="gdh_contact_captcha" />
                        <input type="hidden" id="capt_token" name="capt_token" value="<?php echo $capt_token ?>" />
                    <?php } ?>
                </div>
            </div>
            <div class="span6">
                <div class="input_wrap">
                    <input id="gdh_qc_submit" class="button" type="submit" value="<?php echo $send_msg ?>" />
                </div>
            </div>
        </div>
	</form>
</div>