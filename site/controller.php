<?php
/**
* @version		$Id:controller.php  1 2012-08-28Z Stilero Webdesign $
* @package		Linkcomp
* @subpackage 	Controllers
* @copyright	Copyright (C) 2012, Daniel Eliasson. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
JLoader::import('joomla.application.component.model'); 
JLoader::import( 'communicator', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_linkcomp' . DS . 'classes' );
JLoader::import( 'backlinkchecker', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_linkcomp' . DS . 'classes' );
//JLoader::import( 'model', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_linkcomp' . DS . 'models' );
//JLoader::import( 'competition', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_linkcomp' . DS . 'models' );


/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class LinkcompController extends JController
{

	protected $_viewname = 'item';
	protected $_mainmodel = 'item';
	protected $_itemname = 'Item';    
	protected $_context = "com_linkcomp";
        protected $_msg = '';
        protected $_validator;
	/**
	 * Constructor
	 */
		 
	public function __construct($config = array ()) {
		
		parent :: __construct($config);

		if(isset($config['viewname'])) $this->_viewname = $config['viewname'];
		if(isset($config['mainmodel'])) $this->_mainmodel = $config['mainmodel'];
		if(isset($config['itemname'])) $this->_itemname = $config['itemname']; 

		JRequest :: setVar('view', $this->_viewname);

	}

	public function display() {
		
		$document =& JFactory::getDocument();
	
		$viewType	= $document->getType();
		$view = & $this->getView($this->_viewname,$viewType);
		$model = & $this->getModel($this->_mainmodel);
	
		$view->setModel($model,true);		
		$view->display();
	}
        
        public function compete(){
            JLoader::import( 'contestant', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_linkcomp' . DS . 'models' );
            JRequest::checkToken() or jexit( 'Invalid Token' );
            $user =& JFactory::getUser();
            if(!$user->guest){
                if($this->_validateBacklink()){
                    $date =& JFactory::getDate();
                    $post = array(
                        'name' => $user->name,
                        'competition_id' => JRequest::getVar('id'),
                        'userid' => $user->id,
                        'email' => $user->email,
                        'site_name' => JRequest::getVar('site_name'),
                        'site_url' => JRequest::getVar('site_url'),
                        'confirmed' => 1,
                        'description' => JRequest::getVar('description'),
                        'created' => $date->toFormat()
                    ); 
                    $model = JModel::getInstance( 'contestant', 'LinkcompModel' );
                    if ($model->store($post)) {
                        $this->_msg .= JText :: _($this->_itemname .' Saved').'</ br>';
                    } else {
                        $this->_msg .= $model->getError(); 
                    }
                }
            }else{
                $this->_msg .= JText :: _('You must be logged in to compete.').'</ br>';
            }
            $link = 'index.php?option=com_linkcomp&view='.$this->_viewname.'&id='.JRequest::getVar('id').'&itemId='.JRequest::getInt('itemId') ;
            $this->setRedirect($link, $this->_msg);
        }
        
        private function _validateBacklink(){
            $model = $this->getModel('competition');
            $competitionId = (int)JRequest::getInt('id');
            $data = $model->getItem($competitionId);
            $urlToCheck = JRequest::getVar('site_url');
            $backlinkToLookFor = $data->linkurl;
            $anchorToLookFor = $data->linktext;
            $this->_validator = new BacklinkChecker($urlToCheck, $backlinkToLookFor, $anchorToLookFor);
            $validationResult = $this->_validator->validate();
            $this->_collectErrors();
            return $validationResult;
        }
        
        private function _collectErrors(){
            if($this->_validator->isLinkNotFound()){
                $this->_msg .= JText::_('Link Not Found').'</ br>';
            }
            if($this->_validator->hasLinkWrongAnchor()){
                $this->_msg .= JText::_('Link text wrong').'</ br>';
            }
            if($this->_validator->hasLinkPageNoFollow()){
                $this->_msg .= JText::_('The Link page has a meta tag with no follow').'</ br>';
            }
            if($this->_validator->hasLinkNoFollow()){
                $this->_msg .= JText::_('The Link has no Follow rel-attribute').'</ br>';
            }
        }
	

}// class
  	

  
?>