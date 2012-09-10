<?php
/**
 * @version     $Id$
 * @copyright   Copyright 2011 Stilero AB. All rights re-served.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

//No direct access
defined('_JEXEC) or die;');


class BacklinkChecker extends Communicator{
    protected $urlToCheck;
    protected $postVarsFromUrlToCheck;
    protected $anchorTextToCheckFor;
    protected $backlinkToCheckFor;
    protected $isNoFollowAllowed;
    protected $links;
    protected $backlink;
    protected $backlinks = array();
    protected $linkHasNoFollow = false;
    protected $linkHasWrongAnchor = false;
    protected $linkIsNotFound = false;
    protected $linkPageHasNoFollow = false;
    protected $debug = true;
    
    public function __construct($urlToCheck, $backlinkToCheckFor, $anchorTextToCheckFor="", $config = "") {
        $this->_processURL($urlToCheck);
        parent::__construct($this->urlToCheck, $this->postVarsFromUrlToCheck, $config);
        $this->anchorTextToCheckFor = $anchorTextToCheckFor;
        $this->backlinkToCheckFor = $backlinkToCheckFor;
        $this->isNoFollowAllowed = false;
    }
    
    private function _processURL($url){
        $parsedURL = parse_url($url);
        $urlScheme = isset($parsedURL['scheme']) ? $parsedURL['scheme'] : '';
        $urlHost = isset($parsedURL['host']) ? $parsedURL['host'] : '';
        $urlPath = isset($parsedURL['path']) ? $parsedURL['path'] : '';
        $urlQuery = isset($parsedURL['query']) ? $parsedURL['query'] : '';
        $this->urlToCheck = $urlScheme.'://'.$urlHost.$urlPath;
        if($urlQuery != ''){
            parse_str($urlQuery, $this->postVarsFromUrlToCheck);
        }
    }
    
    public function validate(){
        $this->query();
        $this->_fetchLinks();
        $this->_findValidLinkInBacklinks();
        return $this->_isBacklinkValid();
    }
    
    private function _findValidLinkInBacklinks(){
        foreach ($this->backlinks as $backlink) {
            $this->backlink = $backlink;
            if($this->_isBacklinkValid()){
                $this->backlink = $backlink;
                break;
            }
            $this->backlink = null;
        }
    }
    
    private function _isBacklinkValid(){
        if(!$this->_isBacklinkFound()){
            if($this->debug) print "backlink not found<br/>";
            $this->linkIsNotFound = true;
            return false;
        }
        if($this->_isBacklinkViolatingNoFollow()){
            if($this->debug) print "backlink violating no follow<br/>";
$           $this->linkHasNoFollow = true;
            return false;
        }
        if(!$this->_isAnchorCorrect()){
            if($this->debug) print "backlink wrong anchor<br/>";
            $this->linkHasWrongAnchor = true;
            return false;
        }
        if($this->_hasPageNoIndexMeta()){
            if($this->debug) print "Page has no robot index<br/>";
            $this->linkPageHasNoFollow = true;
            return false;
        }
        return TRUE;
        
    }
    
    private function _isBacklinkFound(){
        if(!empty($this->backlink)){
            return true;
        }else{
            return false;
        }
    }
    
    private function _isBacklinkViolatingNoFollow(){
        if($this->isNoFollowAllowed){
            return false;
        }
        return $this->_hasBacklinkNoFollow();
    }
    
    private function _hasBacklinkNoFollow(){
        $backlinkRel = strtolower($this->backlink['rel']);
        if($backlinkRel == 'nofollow'){
            return true;
        }
        return FALSE;
    }
    
    private function _isAnchorCorrect(){
        if($this->backlink['anchortext'] == $this->anchorTextToCheckFor){
            return true;
        }
        if($this->debug) print "Anchor > Expected: ".$this->anchorTextToCheckFor." - Acutal: ".$this->backlink['anchortext']."<br/>";
        return false;
    }
    
    private function _hasPageNoIndexMeta(){
        $html = new DOMDocument();
        $html->recover = true;
        $html->strictErrorChecking = false;
        libxml_use_internal_errors(true);
        $html->loadHTML($this->response);
        libxml_clear_errors();
        foreach($html->getElementsByTagName('meta') as $metatag) {
                $metaname = strtolower($metatag->getAttribute('name'));
                $metacontent = strtolower($metatag->getAttribute('content'));
                if($metaname == 'robots'){
                    if(strpos($metacontent, 'noindex') || strpos($metacontent, 'nofollow')){
                        return true;
                        break;
                    }
                }
        }
        return FALSE;
    }
    
    private function _fetchLinks(){
        $html = new DOMDocument();
        $html->recover = true;
        $html->strictErrorChecking = false;
        libxml_use_internal_errors(true);
        $html->loadHTML($this->response);
        libxml_clear_errors();
        $links = array();
        foreach($html->getElementsByTagName('a') as $link) {
            $linkurl = array(
                'href' => $link->getAttribute('href'),
                'alt' => $link->getAttribute('alt'),
                'rel' => $link->getAttribute('rel'),
                'anchortext' => $link->nodeValue
            );
            $links[] = $linkurl;
            if($link->getAttribute('href') == $this->backlinkToCheckFor){
                $this->backlinks[] = $linkurl;
            }
        }
        $this->links = $links;
    }
    
    public function getLinks(){
        return $this->links;
    }
    
    public function getBacklinks(){
        return $this->backlinks;
    }
    
    public function isLinkNotFound(){
        return $this->linkIsNotFound;
    }
    
    public function hasLinkWrongAnchor(){
        return $this->linkHasWrongAnchor;
    }
    
    public function hasLinkPageNoFollow(){
        return $this->linkPageHasNoFollow;
    }
    
    public function hasLinkNoFollow(){
        return $this->linkHasNoFollow;
    }
}
?>