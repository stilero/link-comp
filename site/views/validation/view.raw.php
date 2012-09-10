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
JLoader::import('joomla.application.component.model'); 
JLoader::import( 'competition', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_linkcomp' . DS . 'models' );

 
class LinkcompViewValidation extends JView{
    public function display($tpl = null){
        print "hello";exit;
        $site_url = JRequest::getVar('site_url');
        $compId = JRequest::getInt('id');
        $model = JModel::getInstance( 'competition', 'LinkcompModel' );
        $model->setId($compId);
        $data = $model->getData();
        var_dump($data);exit;
                
		$app = &JFactory::getApplication('site');
		$document	= &JFactory::getDocument();
		$uri 		= &JFactory::getURI();
		$user 		= &JFactory::getUser();

                
                
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