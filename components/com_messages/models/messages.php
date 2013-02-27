<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Messages Component Messages Model
 *
 * @package		Joomla.Administrator
 * @subpackage	com_messages
 * @since		1.6
 */
class MessagesModelMessages extends JModelList
{


    public function __construct($config = array()) {
        parent::__construct($config);
        // Статус сообщения
        $state = JRequest::getInt('message_state',NULL); // 9 - все сообщения
        if(isset($state))
        {
            JFactory::getApplication()->setUserState('com_messages.state',$state);
        }
        // Направление сообщения
        $direct = JRequest::getInt('message_direct',NULL); // 0 - входящиее сообщения
        if(isset($state))
        {
            JFactory::getApplication()->setUserState('com_messages.direct',$direct);
        }
    }


	/**
	 * Returns a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	*/
	public function getTable($type = 'Message', $prefix = 'MessagesTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

        /**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 */
	protected function getListQuery()
	{
            $state = JFactory::getApplication()->getUserState('com_messages.state',0);
            $direct = JFactory::getApplication()->getUserState('com_messages.direct',0);

		// Create a new query object.
		$query	= $this->_db->getQuery(true);
		$user	= JFactory::getUser();

		// Select the required fields from the table.
		$query->select('*');
		$query->from('#__messages');
                if($direct)
                {
                    $query->where('user_id_from = '.(int) $user->get('id'));
                }
                else 
                {
                    $query->where('user_id_to = '.(int) $user->get('id'));
                }
                if((int)$state != 9)
                {
                    $query->where('state = '.(int) $state);
                }
                $query->order('message_id DESC');
		return $query;
	}
        
        /**
         * Возвращаем тип сообщения
         * @param integer Приоритет
         * @return string
         */
        public function get_priority($priority)
        {
            $msg = '';
            switch ($priority) {
                case 9:
                    $msg = JTEXT::_('COM_MESSAGES_ZALOBA');
                    break;
                case 1:
                default:
                    $msg = JTEXT::_('COM_MESSAGES_NORMA');
            }
            return $msg;
        }
        
        /**
         * Возвращаем имя пользователя
         * @param integer ID пользователя
         * @return string
         */
        public function get_user_name($user_id)
        {
            $user = JFactory::getUser($user_id);
            return $user->get('name');
        }
        
        /**
         * Возвращаем дату и время в текстовом виде
         * @param datetime Дата и время
         * @return string
         */
        public function get_date_time($date_time)
        {
            preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/", $date_time, $regs);
            return $regs[3].'.'.$regs[2].'.'.$regs[1].' '.$regs[4].':'.$regs[5].':'.$regs[6];
        }
        
        /**
         * Возвращаем состояние сообщения
         * @param integer
         * @return string
         */
        public function get_state($state)
        {
            $src = 'media/com_messages/images/';
            switch ($state) {
                case 0:
                    $src .= 'mail_new-32.png';
                    break;
                case 1:
                    $src .= 'mail_get-32.png';
                    break;
                default:
                    $src .= 'mail_delete-32.png';
            }
            
            return '<img id="messages_message_state" src="'.$src.'" alt="" title="'
                    .JTEXT::_('COM_MESSAGES_STATUS').'">';
        }

        /**
         * Возвращаем список статусов сообщения
         * @param noting
         * @return array
         */
        public function getStatuses()
        {
            return array(
                array('key'=>'9', 'name'=>JText::_('COM_MESSAGES_ALL')),
                array('key'=>'0', 'name'=>JText::_('COM_MESSAGES_NEW')),
                array('key'=>'1', 'name'=>JText::_('COM_MESSAGES_READED')),
                array('key'=>'-2', 'name'=>JText::_('COM_MESSAGES_RECECLED')),
            );
        }
 
        /**
         * Установка статуса сообщений в не прочитанные
         * @return boolean 
         */
        public function unpublish()
        {
            return $this->_set_state('0');
        }
 
        /**
         * Установка статуса сообщений в прочитанные
         * @return boolean 
         */
        public function publish()
        {
            return $this->_set_state('1');
        }
 
        /**
         * Перемещение сообщений в корзину
         * @return boolean 
         */
        public function trash()
        {
            return $this->_set_state('-2');
        }
        
        /**
         * Установка статуса документа
         * @param intege (0,1,-2) $state
         * @return boolean 
         */
        private function _set_state($state)
        {
            $cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
            $row =& $this->getTable();
            if (!$row->publish($cids, $state)) 
            {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            return TRUE;
        }
        /**
         * Установка статуса документа
         * @param intege (0,1,-2) $state
         * @return boolean 
         */
        public function replay()
        {
            $cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
            $row =& $this->getTable();
            if (!$row->load($cids[0])) 
            {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            JFactory::getApplication()->setUserState('com_messages.subject',JText::_('COM_MESSAGES_RE').' '.$row->subject);
            JFactory::getApplication()->setUserState('com_messages.message',$row->message);
            return $row->user_id_from;
        }
}
