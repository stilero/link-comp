<?php
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		Linkcomp
* @subpackage 	Controllers
* @copyright	Copyright (C) 2012, Daniel Eliasson. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * LinkcompCompetition Controller
 *
 * @package    Linkcomp
 * @subpackage Controllers
 */
class LinkcompControllerCompetition extends LinkcompController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'competition'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}		
	public function publish() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);

		if (count($cid) < 1) {
			JError :: raiseError(500, JText :: _('Select an item to publish'));
		}

		$model = $this->getModel('competition');
		if (!$model->publish($cid, 1)) {
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option=com_linkcomp&view=competition');
	}

	public function unpublish() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);

		if (count($cid) < 1) {
			JError :: raiseError(500, JText :: _('Select an item to unpublish'));
		}

		$model = $this->getModel('competition');
		if (!$model->publish($cid, 0)) {
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option=com_linkcomp&view='.$this->_viewname);
	}	
	
}// class
?>