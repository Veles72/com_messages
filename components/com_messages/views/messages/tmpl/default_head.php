<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="5">
		<?php echo JText::_('COM_MESSAGES_MESSAGE_ID'); ?>
	</th>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>			
	<th>
		<?php echo JText::_('COM_MESSAGES_PRIORITY'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_MESSAGES_SUBJECT'); ?>
	</th>
	<th>
                <?php if($this->_direct):?>
                    <?php echo JText::_('COM_MESSAGES_USER_TO'); ?>
                <?php else:?>
                    <?php echo JText::_('COM_MESSAGES_USER_FROM'); ?>
                <?php endif?>
	</th>
	<th>
		<?php echo JText::_('COM_MESSAGES_DATE_TIME'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_MESSAGES_STATE'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_MESSAGES_MESSAGE'); ?>
	</th>
</tr>
