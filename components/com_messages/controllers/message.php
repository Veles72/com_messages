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
class MessagesControllerMessage extends JControllerForm
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
	public function getModel($name = 'Message', $prefix = 'MessagesModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
        
        /**
         * Запись сообщения
         */
        public function save()
        {
            // Check for request forgeries.
            JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
            
            $text = JTEXT::_('COM_MESSAGES_ERROR_SEND_MESSAGE');
            if ($this->_model->save())
            {
                $text = JTEXT::_('COM_MESSAGES_SUCCES_SEND_MESSAGE');
            }
            JFactory::getApplication()->redirect($this->_url, $text);
        }
}
