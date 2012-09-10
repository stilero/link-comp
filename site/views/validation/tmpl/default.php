<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h1><?php echo $this->params->get('page_title');  ?></h1></div>
<h2><?php echo $this->item->title; ?></h2>
<div class="contentpane">
    <?php echo $this->item->description; ?>
	<div>
            <p>Copy the linktext in the box below and paste on your site.</p>
            <form>
                <textarea rows="3" cols="60" name="linktous" style="width:95%;">
<a href="<?php echo $this->item->linkurl; ?>"><?php echo $this->item->linktext; ?></a>
                </textarea>
            </form>
	</div>
        <?php
        if ($this->user->guest) {
                echo "<p>You must login to enter the contest.</p>";
        } else{
            echo $this->loadTemplate('form');
        } 
        ?>
</div>
