<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h2><?php echo $this->params->get('page_title');  ?></h2></div>
<h3><?php echo $this->item->name; ?></h3>
<div class="contentpane">
	<div><h4>Some interesting informations</h4></div>
	
	<div>
		Name: <?php echo $this->item->name; ?>
	</div>
	<div>
		Email: <?php echo $this->item->email; ?>
	</div>
	<div>
		Site_name: <?php echo $this->item->site_name; ?>
	</div>
	<div>
		Site_url: <?php echo $this->item->site_url; ?>
	</div>
	<div>
		Created: <?php echo $this->item->created; ?>
	</div>
	<div>
		Id: <?php echo $this->item->id; ?>
	</div>

</div>
