<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$document =& JFactory::getDocument();
$cssFile = JURI::root(true).'/media/linkcontest/css/icons.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());
  JToolBarHelper::title( JText::_( 'Winner' ), 'winner.png' );
  JToolBarHelper::publishList();
  JToolBarHelper::unpublishList();
  JToolBarHelper::deleteList();
  JToolBarHelper::editListX();
  JToolBarHelper::addNewX();
  JToolBarHelper::preferences('com_linkcontest', '550');  
?>

<form action="index.php?option=com_linkcontest&amp;view=winner" method="post" name="adminForm">
    <table>
        <tr>
            <td align="left" width="100%">
                <?php echo JText::_( 'Filter' ); ?>:
                <input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
                <button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
                <button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
            </td>
            <td nowrap="nowrap">
            </td>
        </tr>		
    </table>
    <div id="editcell">
	<table class="adminlist">
            <thead>
                <tr>
                    <th width="5">
                        <?php echo JText::_( 'NUM' ); ?>
                    </th>
                    <th width="20">				
                        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
                    </th>			
                    <th class="title" width="40">
                        <?php echo JHTML::_('grid.sort', 'Created', 'a.created', $this->lists['order_Dir'], $this->lists['order'] ); ?>
                    </th>								
                    <th class="title">
                        <?php echo JHTML::_('grid.sort', 'Competition', 'a.competition_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
                    </th>	
                    <th class="title">
                        <?php echo JHTML::_('grid.sort', 'Contestant', 'a.contestant_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
                    </th>	
                    <th class="title" width="10">
                        <?php echo JHTML::_('grid.sort', 'Contacted', 'a.contacted', $this->lists['order_Dir'], $this->lists['order'] ); ?>
                    </th>	
                    <th class="title" width="5">
                        <?php echo JHTML::_('grid.sort', 'Id', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
                    </th>	
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="12">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
            </tfoot>
            <tbody>
            <?php
              $k = 0;
              if (count( $this->items ) > 0 ):
                for ($i=0, $n=count( $this->items ); $i < $n; $i++):
                    $row = &$this->items[$i];
                    $this->compModel->setId($row->competition_id);
                    $competition = $this->compModel->getItem();
                    $this->contModel->setId($row->contestant_id);
                    $contestant = $this->contModel->getItem();
                    $onclick = "";
                    if (JRequest::getVar('function', null)) {
                        $onclick= "onclick=\"window.parent.jSelectWinner_id('".$row->id."', '".$this->escape($row->id)."', '','id')\" ";
                    }  	
                    $link = JRoute::_( 'index.php?option=com_linkcontest&view=winner&task=edit&cid[]='. $row->id );
                    $contestantLink =  JRoute::_( 'index.php?option=com_linkcontest&view=contestant&task=edit&cid[]='. $contestant->id );
                    $row->id = $row->id; 	
                    $checked = JHTML::_('grid.id', $i, $row->id); 	
                    $contacted = JHTML::_('grid.boolean', $i, $row->contacted ); 	
                    ?>
                    <tr class="<?php echo "row$k"; ?>">
                        <td align="center"><?php echo $this->pagination->getRowOffset($i); ?>.</td>
                        <td><?php echo $checked  ?></td>	
                        <td>
                            <a <?php echo $onclick; ?>href="<?php echo $link; ?>">
                                <?php echo $row->created ?>
                            </a>
                        </td>
                        <td>
                            <a <?php echo $onclick; ?>href="<?php echo $link; ?>">
                                <?php echo $competition->title ?>
                            </a>
                        </td>
                        <td>
                            <a <?php echo $onclick; ?>href="<?php echo $contestantLink; ?>">
                                <?php echo $contestant->name ?>
                            </a>
                        </td>
                        <td><?php echo $contacted ?></td>
                        <td>
                            <a <?php echo $onclick; ?>href="<?php echo $link; ?>">
                                <?php echo $row->id; ?>
                            </a>
                        </td>		
                    </tr>
                    <?php
                    $k = 1 - $k;
                endfor;
            else: ?>
                <tr>
                    <td colspan="12">
                        <?php echo JText::_( 'There are no items present' ); ?>
                    </td>
                </tr>
                <?php
            endif;?>
        </tbody>
    </table>
</div>
<input type="hidden" name="option" value="com_linkcontest" />
<input type="hidden" name="task" value="winner" />
<input type="hidden" name="view" value="winner" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>  	