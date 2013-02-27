<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Messages list controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_messages
 * @since		1.6
 */
class MessagesControllerMessages extends JControllerForm
{
    private $_model;
    private $_url;
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->_model = $this->getModel();
        $this->_url = JRoute::_(JURI::base().'index.php?option=com_messages&view=messages');
    }

    /**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Messages', $prefix = 'MessagesModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
        
        /**
         * Установка статуса сообщений в не прочитанные
         */
        public function unpublish()
        {
            // Check for request forgeries.
            JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
            
            $text = JTEXT::_('COM_MESSAGES_ERROR_CHANGE_STATE');
            if ($this->_model->unpublish())
            {
                $text = JTEXT::_('COM_MESSAGES_SUCCES_CHANGE_STATE');
            }
            JFactory::getApplication()->redirect($this->_url, $text);
     
        }
        
        /**
         * Установка статуса сообщений в прочитанные
         */
        public function publish()
        {
            // Check for request forgeries.
            JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
            
            $text = JTEXT::_('COM_MESSAGES_ERROR_CHANGE_STATE');
            if ($this->_model->publish())
            {
                $text = JTEXT::_('COM_MESSAGES_SUCCES_CHANGE_STATE');
            }
            JFactory::getApplication()->redirect($this->_url, $text);
        }
        
        /**
         * Перемещение сообщений в корзину
         */
        public function trash()
        {
            // Check for request forgeries.
            JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
            
            $text = JTEXT::_('COM_MESSAGES_ERROR_CHANGE_STATE');
            if ($this->_model->trash())
            {
                $text = JTEXT::_('COM_MESSAGES_SUCCES_CHANGE_STATE');
            }
            JFactory::getApplication()->redirect($this->_url, $text);
        }
        
        /**
         * Ответ на входящее сообщение
         */
        public function replay()
        {
            // Check for request forgeries.
            JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
            $user_id_to = $this->_model->replay();
            if ($user_id_to)
            {
                $url = JURI::base()
                    .'index.php?option=com_messages&view=message&layout=edit&user_id_to='.$user_id_to;
                JFactory::getApplication()->redirect(JRoute::_($url));
            }
            
            $text = JTEXT::_('COM_MESSAGES_ERROR_REPLAY_MESSAGE');
            JFactory::getApplication()->redirect($this->_url, $text);
        }
}
