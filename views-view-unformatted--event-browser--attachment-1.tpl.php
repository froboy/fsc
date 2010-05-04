<?php
// $Id: date-navigation.tpl.php,v 1.1.4.10 2009/04/30 10:44:43 karens Exp $
/**
 * @file
 * Template to display date navigation links.
 *
 * $nav_title
 *   The formatted title for this view. In the case of block
 *   views, it will be a link to the full view, otherwise it will 
 *   be the formatted name of the year, month, day, or week.
 * 
 * $prev_url
 * $next_url
 *   Urls for the previous and next calendar pages. The links are 
 *   composed in the template to make it easier to change the text,
 *   add images, etc.
 * 
 * $prev_options
 * $next_options
 *   Query strings and other options for the links that need to
 *   be used in the l() function, including rel=nofollow.
 * 
 * $block: 
 *   Whether or not this view is in a block.
 * 
 * $view
 *   The view object for this navigation.
 * 
 * The &nbsp; in the prev and next divs is to be sure they are never
 * completely empty, needed in some browsers to prop the header open
 * so the title stays centered.
 * 
 $d = strtotime($node->field_date[0]['value']);
$y = date('Y',$d);
$m = date('n',$d);
$ay = 'Nothing';
//If the month is Sept or after, AY = thisYear-nextYear
if ($m>=9) { $yA = $y+1; $ay = $y . '-' . $yA; }
//If the month is before Sept, AY = lastYear-thisYear.
else { $yP = $y-1; $ay = $yP . '-' . $y; }
$node_field[0]['value'] = $ay;

if (strlen($argument)==9){
$arg_begin = substr($argument,0,4);
$arg_end = substr($argument,5,4);
$y = date('Y');
if (1992 <= $arg_begin && $arg_begin <= $y && 1993 <= $arg_end && $arg_end <= ($y+1) && $arg_begin == ($arg_end-1)) {return TRUE; }
}
else {return FALSE;}
 */
?>
<?php

// Do some validation to start...
$arg = $view->args[0];
if (strlen($arg)==9){
	$arg_begin = substr($arg,0,4);
	$arg_end = substr($arg,5,4);
	$y = date('Y');
	$v = '';
	if (1992 <= $arg_begin && 
		$arg_begin <= $y && 
		1993 <= $arg_end && 
		$arg_end <= ($y+1) && 
		$arg_begin == ($arg_end-1)) 
	{ $v=TRUE; }
}
else {$v=FALSE;}

if(!$v){ // Get the current AY
	$y = date('Y');
	$m = date('n');
	$ay = 'Nothing';
	//If the month is Sept or after, AY = thisYear-nextYear
	if ($m>=9) { $yA = $y+1; $ay = $y . '-' . $yA; }
	//If the month is before Sept, AY = lastYear-thisYear.
	else { $yP = $y-1; $ay = $yP . '-' . $y; }
	$arg = $ay;
}
/*print_r ($view->args);*/
	$block = ''; 
	$prev_options = $next_options = array();
	$prev_options['alias'] = $next_options['alias'] = TRUE;
	$prev_options['attributes'] = array('title' => 'Go to previous academic year');
  	$next_options['attributes'] = array('title' => 'Go to next academic year');
  	// Add nofollow for next/prev links.
  	$prev_options['attributes'] += array('rel' => 'nofollow');
  	$next_options['attributes'] += array('rel' => 'nofollow');
	$prev_url = $next_url = '';
	
	$nav_title = 'Academic Year '.$arg;
	$arg_begin = substr($arg,0,4);
	$arg_end = substr($arg,5,4);
	if($arg_begin>=1992){
		$prev_url = 'events/archive/'.($arg_begin-1).'-'.$arg_begin;
	}
	if((date('n')>=9 && $arg_end<=(date('Y')+1)) || (date('n')<9 && $arg_end<=date('Y'))){
	$next_url = 'events/archive/'.$arg_end.'-'.($arg_end+1);
	}

?>
<div class="date-nav clear-block">
  <div class="date-prev">
    <?php if (!empty($prev_url)) : ?>
      <span class="next"> <?php print l('« ' . ($block ? '' : date_t('Prev', 'date_nav')), $prev_url, $prev_options); ?></span>
    <?php endif; ?>
  &nbsp;</div>
  <div class="date-heading">
    <h3><?php print $nav_title ?></h3>
  </div>
  <div class="date-next">&nbsp;
    <?php if (!empty($next_url)) : ?>
      <span class="next"> <?php print l(($block ? '' : date_t('Next', 'date_nav')) . ' »', $next_url, $next_options); ?></span>
    <?php endif; ?>  
  </div>
</div>
