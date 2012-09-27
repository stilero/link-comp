<?php
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		Linkcontest
* @subpackage 	Controllers
* @copyright	Copyright (C) 2012, Daniel Eliasson. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * LinkcontestWinner Controller
 *
 * @package    Linkcontest
 * @subpackage Controllers
 */
class LinkcontestControllerWinner extends LinkcontestController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'winner'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	

	
	
}// class
?>