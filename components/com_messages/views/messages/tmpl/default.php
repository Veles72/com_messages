<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<style type="text/css">
    div.messages-toolbar{ 
        float: right; 
        width: auto; 
        border: solid activeborder 1px;
        border-radius: 5px;
        margin: 5px;
        padding: 5px;
    }
    div.messages-toolbar-item{ float: left; margin: 0 5px}
    span.messages_icon{cursor: pointer}
    div.divider{border-left: 1px solid activeborder;  margin: 5px; height: 35px}
    div.messages_selections{padding: 5px 0}
    div.clear{clear: both;}
</style>
<!--Toolbar-->
<?php if(!$this->_direct):?>
<div class="messages-toolbar">
    <div class="messages-toolbar-item">
        <span onclick="if (document.adminForm.boxchecked.value==0){alert('<?=JText::_('COM_MESSAGES_SELECT_MESSAGE')?>');}else{ Joomla.submitbutton('messages.publish')}" class="messages_icon">            
            <image src="media/com_messages/images/mail_get.png" alt="<?=JText::_('COM_MESSAGES_SET_AS_READED')?>" title="<?=JText::_('COM_MESSAGES_SET_AS_READED')?>"/>
        </span>
    </div>
    <div class="messages-toolbar-item">
        <span class="messages_icon" onclick="if (document.adminForm.boxchecked.value==0){alert('<?=JText::_('COM_MESSAGES_SELECT_MESSAGE')?>');}else{ Joomla.submitbutton('messages.unpublish')}">
            <image src="media/com_messages/images/mail_new.png" alt="<?=JText::_('COM_MESSAGES_SET_AS_NEW')?>" title="<?=JText::_('COM_MESSAGES_SET_AS_NEW')?>"/>
        </span>
    </div>
    <div class="messages-toolbar-item divider"></div>
    <div class="messages-toolbar-item">
        <span onclick="if (document.adminForm.boxchecked.value==0){alert('<?=JText::_('COM_MESSAGES_SELECT_MESSAGE')?>');}else{ Joomla.submitbutton('messages.trash')}" class="messages_icon">
            <image src="media/com_messages/images/mail_delete.png" alt="<?=JText::_('COM_MESSAGES_SET_AS_DELETED')?>" title="<?=JText::_('COM_MESSAGES_SET_AS_DELETED')?>"/>
        </span>
    </div>
    <div class="messages-toolbar-item divider"></div>
    <div class="messages-toolbar-item">
        <span onclick="if (document.adminForm.boxchecked.value==0){alert('<?=JText::_('COM_MESSAGES_SELECT_MESSAGE')?>');}else{ Joomla.submitbutton('messages.replay')}" class="messages_icon">
            <image src="media/com_messages/images/mail_replyall.png" alt="<?=JText::_('COM_MESSAGES_SET_AS_REPLAY')?>" title="<?=JText::_('COM_MESSAGES_SET_AS_REPLAY')?>"/>
        </span>
    </div>
</div>
<?php endif;?>
<!--/Toolbar-->

<div class="clear"></div>
<form id="admin_form" action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm">
    <div class="form-header">
        <div class="messages_selections"><?=$this->select_status?></div>
        <div class="messages_selections"><?=$this->select_directions?></div>
    </div>
	<table class="adminlist">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="option" value="com_messages" />
		<input type="hidden" name="view" value="messages" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
    