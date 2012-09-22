<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h1><?php echo $this->params->get('page_title');  ?></h1></div>
<h2><?php echo $this->item->title; ?></h2>
<div class="contentpane">
    <div class="linkcom_desc">
        <?php echo $this->item->description; ?>
    </div>    
	<div>
            <form>
                <fieldset>
                    <legend>
                       Copy the linktext in the box below and paste on your site.
                    </legend>
                    <textarea rows="2" cols="60" name="linktous" style="width:95%;">
<a href="<?php echo $this->item->linkurl; ?>"><?php echo $this->item->linktext; ?></a>
                    </textarea>
                </fieldset> 
            </form>
	</div>
        <?php
        if ($this->user->guest) {
                JFactory::getApplication()->enqueueMessage( 'You must login to enter the contest.', 'error');
        } else{
            echo $this->loadTemplate('form');
        } 
        ?>
    <div class="some_credit_please">
        <a href="http://www.stilero.com" target="_blank">Joomla extension</a>
        Powered by 
        <a href="http://www.stilero.com" target="_blank">Stilero Web design</a>
    </div>
</div>
