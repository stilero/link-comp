<?php
/**
* @version		$Id: default_viewfrontend.php 96 2011-08-11 06:59:32Z michel $
* @package		Linkcomp
* @subpackage 	Views
* @copyright	Copyright (C) 2012, Daniel Eliasson. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

 
class LinkcompViewValidation  extends JView 
{
	public function display($tpl = null)
	{
		
		$app = &JFactory::getApplication('site');
		$document	= &JFactory::getDocument();
		$uri 		= &JFactory::getURI();
		$user 		= &JFactory::getUser();
		$pagination	= &$this->get('pagination');
		$params		= $app ->getParams();				
		$menus	= &JSite::getMenu();
		
		$menu	= $menus->getActive();
		if (is_object( $menu )) {
			$menu_params = $menus->getParams($menu->id) ;
			if (!$menu_params->get( 'page_title')) {
				$params->set('page_title', 'Competition');
			}
		}		

                $user =& JFactory::getUser();
                $this->assignRef('user', $user);
		$item = $this->get( 'Item' );
		$this->assignRef( 'item', $item );
                $site_url = (JRequest::getVar('site_url') == "") ? 'http://' : JRequest::getVar('site_url');
                $this->assignRef('site_url', $site_url);
                $site_name = JRequest::getVar('site_name');
                $this->assignRef('site_name', $site_name);
                $description = JRequest::getVar('description');
                $this->assignRef('description', $description);
		$this->assignRef('params', $params);
		$this->assignRef('pagination', $pagination);
		
		parent::display($tpl);
	}
}
?>