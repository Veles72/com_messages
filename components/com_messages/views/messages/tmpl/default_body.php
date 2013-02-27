<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->message_id; ?>
		</td>
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->message_id); ?>
		</td>
		<td>
			<?php echo $this->_get_priority($item->priority); ?>
		</td>
		<td>
			<?php echo $item->subject; ?>
		</td>
		<td>
			<?php
                            if($this->_direct)
                            {
                                echo $this->_get_user_name($item->user_id_to); 
                            }
                            else 
                            {
                                echo $this->_get_user_name($item->user_id_from); 
                            }
                        ?>
		</td>
		<td>
			<?php echo $this->_get_date_time($item->date_time); ?>
		</td>
		<td style="text-align: center">
			<?php echo $this->_get_state($item->state); ?>
		</td>
		<td>
			<?php echo $item->message; ?>
		</td>
	</tr>
<?php endforeach; ?>
