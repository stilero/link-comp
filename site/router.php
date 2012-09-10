<?php
  defined('_JEXEC') or die('Restricted access');

  function LinkcompBuildRoute( &$query )
  {
    $segments = array();

    if (isset($query['view'])) {
		$segments[0] = $query['view'];
  		unset($query['view']);
  	};

    if (isset($query['id'])) {
 			$segments[1] = $query['id'];
  		unset($query['id']);
  	};

    return $segments;
  } // End LinkcompBuildRoute function
  
  function LinkcompParseRoute( $segments )
  {
    $vars = array();
    
    if (count($segments) > 0) {

  		$vars['view'] = $segments[0];
      switch ($vars['view']) {
        case 'all':
      		$catid = explode(':', $segments[1]);
      		$vars['catid']= (int) $catid[0];
			break;
        case 'category':
      		$vars['id']   = (int) $segments[1];
			break;
        case 'competition':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'contestant':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'winner':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;

      };
      
    } else {
      $vars['view'] = $segments[0];
    } // End count(segments) statement

    return $vars;
  } // End LinkcompParseRoute

?>
