<?php
/**
* @version		$Id:winner.php  1 2012-08-28 19:17:39Z Stilero Webdesign $
* @package		Linkcontest
* @subpackage 	Tables
* @copyright	Copyright (C) 2012, Daniel Eliasson. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableWinner class
*
* @package		Linkcontest
* @subpackage	Tables
*/
class TableWinner extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var datetime created  **/
   public $created = null;

   /** @var linkcontestcontestant contestant_id  **/
   public $contestant_id = null;

   /** @var linkcontestcompetition competition_id  **/
   public $competition_id = null;

   /** @var datetime contacted  **/
   public $contacted = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__linkcontest_winner', 'id', $db);
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/
	public function bind($array, $ignore = '')
	{ 
		
		return parent::bind($array, $ignore);		
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function check()
	{		
		if (!$this->created) {
			$date = JFactory::getDate();
			$this->created = $date->toFormat("%Y-%m-%d %H:%M:%S");
		}

		/** check for valid name */
		/**
		if (trim($this->id) == '') {
			$this->setError(JText::_('Your Winner must contain a id.')); 
			return false;
		}
		**/		

		return true;
	}
}
