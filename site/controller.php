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
JLoader::import( 'backlinkvalidator', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_linkcomp' . DS . 'classes' );
JLoader::import( 'link', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_linkcomp' . DS . 'classes' );
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
                $language = JFactory::getLanguage();
                $language->load('com_linkcomp', JPATH_SITE, 'en-GB', true);
                $language->load('com_linkcomp', JPATH_SITE, null, true);
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
            $messageType = '';
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
                        $this->_msg .= JText :: _('Thanks for participating. ').'</ br>';
                    } else {
                        $this->_msg .= $model->getError(); 
                        $messageType = 'error';
                    }
                }else{
                    $messageType = 'error';
                }
            }else{
                $this->_msg .= JText :: _('You must be logged in to compete.').'</ br>';
                $messageType = 'error';
            }
            $link = 'index.php?option=com_linkcomp&view='.$this->_viewname.'&id='.JRequest::getVar('id').'&itemId='.JRequest::getInt('itemId') ;
            $this->setRedirect($link, $this->_msg, $messageType);
        }
        
        private function _validateBacklink(){
            $model = $this->getModel('competition');
            $competitionId = (int)JRequest::getInt('id');
            $data = $model->getItem($competitionId);
            $Link = new Link($data->linkurl, $data->linktext);
            $Linker = new Link(JRequest::getVar('site_url'));
            $this->_validator = new BacklinkValidator($Link, $Linker);
            $validationResult = $this->_validator->check();
            $this->_collectErrors();
            return $validationResult;
        }
        
        private function _collectErrors(){
            $errors = $this->_validator->getErrors();
            $msg = array();
            if(!$this->_validator->isFound() && empty($errors)){
                $msg[] = JText::_('Link Not Found');
            }
            if(in_array($this->_validator->getErrorCodeWrongAnchor(), $errors)){
                $msg[] = JText::_('Link text wrong');
            }
            if(in_array($this->_validator->getErrorCodeNoFollow(), $errors)){
                 $msg[] = JText::_('The Link has no Follow rel-attribute');
            }
            $this->_msg = implode('</li><li>', $msg);
        }
	

}// class
  	

  
?>