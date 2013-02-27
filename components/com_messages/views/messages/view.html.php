<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a list of messages.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_messages
 * @since		1.6
 */
class MessagesViewMessages extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	private $_model;
	protected $_direct;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->_model		= $this->getModel();
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
                $statuses               = $this->get('Statuses');
                $this->select_status    = $this->_build_select_statuses($statuses);
                $this->_direct =  JFactory::getApplication()->getUserState('com_messages.direct',0);
                $this->select_directions    = $this->_build_select_directions();


		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
                
		parent::display($tpl);
	}

        /**
         * Возвращаем тип сообщения
         * @param integer Приоритет
         * @return string
         */
        protected function _get_priority($priority)
        {
            return $this->_model->get_priority($priority);
        }
        
        /**
         * Возвращаем имя пользователя
         * @param integer ID пользователя
         * @return string
         */
        protected function _get_user_name($user_id)
        {
            return $this->_model->get_user_name($user_id);
        }
        
        /**
         * Возвращаем дату и время в текстовом виде
         * @param datetime Дата и время
         * @return string
         */
        protected function _get_date_time($date_time)
        {
            return $this->_model->get_date_time($date_time);
        }
        
        /**
         * Возвращаем состояние сообщения
         * @param integer
         * @return string
         */
        protected function _get_state($state)
        {
            return $this->_model->get_state($state);
        }
        /**
         * Возвращаем список статусов документов
         * @return type HTML select
         */
        public function _build_select_statuses($statuses)
        {
            $stus = JFactory::getApplication()->getUserState('com_messages.state',0);
            $state = array();
                foreach ($statuses as $status)
                {
                    $state[] = JHTML::_('select.option'
                            , $status['key']
                            , JText::_($status['name'])
                    );
                }
                return JHTML::_('select.genericlist'
                                , $state
                                , 'message_state'
                                , array('onchange'=>'this.form.submit()') // attributes
                                , 'value'
                                , 'text'
                                , $stus  // selected
                                , 'message_status' // DOOM tag ID
                                , false );
            
        }
        /**
         * Возвращаем выбор входящих или исходящих документов
         * @return type HTML select
         */
        public function _build_select_directions()
        {
            $state[] = JHTML::_('select.option', 0, JText::_('MESSAGE_IN'));
            $state[] = JHTML::_('select.option', 1, JText::_('MESSAGE_OUT'));
            return JHTML::_('select.radiolist'
                    , $state
                    , 'message_direct' // DOOM tag name
                    , array('onchange'=>'this.form.submit()') // attributes
                    , 'value'
                    , 'text'
                    , $this->_direct  // selected
                    , 'message_direct' // DOOM tag ID
                    , false );
            
        }

}
