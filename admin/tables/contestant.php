<?php
/**
* @version		$Id:contestant.php  1 2012-08-28 19:17:39Z Stilero Webdesign $
* @package		Linkcomp
* @subpackage 	Tables
* @copyright	Copyright (C) 2012, Daniel Eliasson. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableContestant class
*
* @package		Linkcomp
* @subpackage	Tables
*/
class TableContestant extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar name  **/
   public $name = null;

   /** @var text description  **/
   public $description = null;

   /** @var datetime created  **/
   public $created = null;

   /** @var linkcompcompetition competition_id  **/
   public $competition_id = null;

   /** @var int userid  **/
   public $userid = null;

   /** @var varchar email  **/
   public $email = null;

   /** @var varchar site_name  **/
   public $site_name = null;

   /** @var varchar site_url  **/
   public $site_url = null;

   /** @var tinyint confirmed  **/
   public $confirmed = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__linkcomp_contestant', 'id', $db);
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
		if (trim($this->name) == '') {
			$this->setError(JText::_('Your Contestant must contain a name.')); 
			return false;
		}
		**/		

		return true;
	}
}
