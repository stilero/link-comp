<?php
/**
 * $Id$
 *  @package	Joomla
 *  @author Daniel Eliasson
* 	@copyright	Copyright (C) 2010 Stilero. All rights reserved.
* 	@license	GNU/GPL, see LICENSE.php
* 	Joomla! is free software. This version may have been modified pursuant
* 	to the GNU General Public License, and as distributed it includes or
* 	is derivative of works licensed under the GNU General Public License or
* 	other free or open source software licenses.
*/

// no direct access
defined('_JEXEC') or die('Restricted access'); 
JHTML::_('behavior.formvalidation');
$jScript = '<script language="javascript">
function myValidate(f) {
   if (document.formvalidator.isValid(f)) {
      f.check.value='.JUtility::getToken().'; //send token
      return true; 
   }
   else {
      var msg = "Some values are not acceptable.  Please retry.";
      //Example on how to test specific fields
      if($(\'email\').hasClass(\'invalid\')){msg += \'\n\n\t* Invalid E-Mail Address\';}
 
      alert(msg);
   }
   return false;
}
</script>';
	$script = '<!--
		function validateForm( frm ) {
			var valid = document.formvalidator.isValid(frm);
			if (valid == false) {
				// do field validation
				if (frm.email.invalid) {
					alert( "' . JText::_( 'Please enter a valid e-mail address.', true ) . '" );
				} else if (frm.text.invalid) {
					alert( "' . JText::_( 'CONTACT_FORM_NC', true ) . '" );
				}
				return false;
			} else {
				frm.submit();
			}
		}
		// -->';
	$document =& JFactory::getDocument();
	$document->addScriptDeclaration($jScript);
?>
<form action="<?php echo JRoute::_( 'index.php' );?>" method="post" name="competitionForm" id="competitionForm" class="form-validate" onSubmit="return myValidate(this);">
    <label for="contestant_name"><?php echo JText::_( 'Enter your name' );?>:</label>
    <br />
    <input type="text" name="name" id="contestant_name" size="30" class="inputbox" value="<?php echo $this->user->name;?>" />
    <br />
    <label id="contestant_emailmsg" for="contestant_email"><?php echo JText::_( 'Email address' );?>:</label>
    <br />
    <input type="text" id="contestant_email" name="email" size="30" value="<?php echo $this->user->email;?>" class="inputbox required validate-email" maxlength="100" />
    <br />
    <label for="site_url"><?php echo JText::_( 'Link' );?>:</label>
    <br />
    <input type="text" name="site_url" id="site_url" size="30" class="inputbox required" value="<?php echo $this->site_url;?>" />
<br />
    <label for="site_name"><?php echo JText::_( 'Site Name' );?>:</label>
    <br />
    <input type="text" name="site_name" id="site_name" size="30" class="inputbox required" value="<?php echo $this->site_name;?>" />
    <br /><br />
    <label id="contestant_comment" for="description">
    &nbsp;<?php echo JText::_( 'Enter your message' );?>:
    </label>
    <br />
    <textarea cols="50" rows="10" name="description" id="description" class="inputbox"><?php echo $this->description;?></textarea>
    <br />
    <br />
    <button class="button validate" type="submit"><?php echo JText::_('Send'); ?></button>

    <input type="hidden" name="option" value="com_linkcomp" />
    <input type="hidden" name="view" value="competition" />
    <input type="hidden" name="id" value="<?php echo JRequest::getVar('id');?>" />
    <input type="hidden" name="itemId" value="<?php echo JRequest::getVar('itemId');?>" />
    <input type="hidden" name="task" value="compete" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>