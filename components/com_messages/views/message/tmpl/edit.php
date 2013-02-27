<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_messages
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Include the HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'message.cancel' || document.formvalidator.isValid(document.id('message-form'))) {
			Joomla.submitform(task, document.getElementById('message-form'));
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_messages'); ?>" method="post" name="adminForm" id="message-form" class="form-validate">
	<div class="width-100">
		<fieldset class="adminform">
		<ul class="adminformlist">
			<li><?php echo $this->form->getLabel('subject'); ?>
			<?php echo $this->form->getInput('subject'); ?></li>

			<li><?php echo $this->form->getLabel('message'); ?>
			<?php echo $this->form->getInput('message'); ?></li>
		</ul>
		</fieldset>
	</div>
        <input type="hidden" name="jform[user_id_to]" value="<?=$this->user_id_to?>">
        <input type="hidden" name="jform[priority]" value="<?=$this->priority?>">
        <input type="hidden" name="task" value="message.save">
        <?php echo JHtml::_('form.token'); ?>
    <input type="button" name="message_form_submit" value="<?=JTEXT::_('COM_MESSAGES_SEND')?>" onclick="Joomla.submitbutton('message.save')">
</form>
