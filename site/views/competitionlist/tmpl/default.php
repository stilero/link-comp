<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h2><?php echo $this->params->get('page_title');  ?></h2></div>

<div class="contentpane">
	<h3>Some Items, if present</h3>
	<ul>
<?php foreach ($this->items as $i => $item) : 
				//you may want to do this anywhere else				
				$item->slug	= $item->alias ? ($item->id.':'.$item->alias) : $item->id;				
				$link = JRoute::_('index.php?view=competition&id='. $item->slug);
				
	?>
	<li><a href="<?php echo $link ?>"><?php  echo $item->title ?></a></li>
<?php endforeach; ?>
</ul>		
</div>