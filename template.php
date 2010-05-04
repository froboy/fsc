<?php
// $Id: template.php,v 1.19 2009/02/19 14:48:15 johnalbin Exp $

/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to fsc_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: fsc_breadcrumb()
 *
 *   where fsc is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/*
 * Add any conditional stylesheets you will need for this sub-theme.
 *
 * To add stylesheets that ALWAYS need to be included, you should add them to
 * your .info file instead. Only use this section if you are including
 * stylesheets based on certain conditions.
 */
/* -- Delete this line if you want to use and modify this code
// Example: optionally add a fixed width CSS file.
if (theme_get_setting('fsc_fixed')) {
  drupal_add_css(path_to_theme() . '/layout-fixed.css', 'theme', 'all');
}
// */


/**
 * Implementation of HOOK_theme().
 */
function fsc_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function *
function fsc_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function */
function fsc_preprocess_page(&$vars) {
  // Inject META tags to stop caching of catalog search results page
  if ($vars['node']->nid == '11')
  {
	  $vars['head'] = drupal_set_html_head('<META HTTP-EQUIV="expires" CONTENT="Wed, 03 Nov 1999 12:21:14 GMT">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Cache-Control" Content="no-cache">');
  }
  
  // Titles are ignored by content type when they are not desired in the design.
  // Code from http://drupal.org/node/426482
  $vars['original_title'] = $vars['title'];
  if (!empty($vars['node']) && in_array($vars['node']->type, array('event'))) {
	  // If the event is in the future, title "Upcoming Events", otherwise "Events"
	  $event_date = check_plain($vars['node']->field_date[0]['value']);
	  if (!empty($event_date)) {
		  $event_date = strtotime($event_date) - (3600*7);
		  $now=time();
		  if ( $event_date >= $now ) { $vars['title'] = 'Upcoming Events'; }
		  else { $vars['title'] = 'Events Archive'; }
	  }
  }
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function fsc_preprocess_node(&$vars, $hook) {
  // From http://11heavens.com/putting-some-order-in-your-terms
  // If we have any terms...
  if ($vars['node']->taxonomy) {
    // Let's iterate through each term.
    foreach ($vars['node']->taxonomy as $term) {
      // We will build a new array where there will be as many
      // nested arrays as there are vocabularies
      // The key for each nested array is the vocabulary ID.     
      $vocabulary[$term->vid]['taxonomy_term_'. $term->tid]  = array(
        'title' => $term->name,
        'href' => taxonomy_term_path($term),
        'attributes' => array(
          'rel' => 'tag', 
          'title' => strip_tags($term->description),
        ),
      );       
    }
	$vars['event_category']= theme('links',$vocabulary[2], array('class'=>'links inline'));
	$vars['event_header']= theme('links',$vocabulary[3], array('class'=>'links inline'));
	$vars['media_format']= theme('links',$vocabulary[4], array('class'=>'links inline'));
    // Making sure vocabularies appear in the same order.
    ksort($vocabulary, SORT_NUMERIC);
    // We will get rid of the old $terms variable.
    unset($vars['terms']);
    // And build a new $terms.
    foreach ($vocabulary as $vid => $terms) {
      // Getting the name of the vocabulary.
      $name = taxonomy_vocabulary_load($vid)->name;
      // Using the theme('links', ...) function to theme terms list.
      $terms = theme('links', $terms, array('class' => 'links inline'));
      // Wrapping the terms list.
      $vars['terms'] .= '<div class="vocabulary taxonomy_vid_';
      $vars['terms'] .= $vid;
      $vars['terms'] .= '">';
      $vars['terms'] .= $name;
      $vars['terms'] .= ':&nbsp;';
      $vars['terms'] .= $terms;
      $vars['terms'] .= '</div>';
    }
  }    

}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function fsc_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function fsc_preprocess_block(&$vars, $hook) {
  
  $block = $vars['block'];

  // Special classes for blocks.
  $classes = array('block');
  $classes[] = 'block-' . $block->module;
  $classes[] = 'region-' . $vars['block_zebra'];
  $classes[] = $vars['zebra'];
  $classes[] = 'region-count-' . $vars['block_id'];
  $classes[] = 'count-' . $vars['id'];
  $classes[] = zen_id_safe('block-subject-'. $block->subject);
  
  $vars['edit_links_array'] = array();
  $vars['edit_links'] = '';
  if (theme_get_setting('zen_block_editing') && user_access('administer blocks')) {
    include_once './' . drupal_get_path('theme', 'zen') . '/template.block-editing.inc';
    zen_preprocess_block_editing($vars, $hook);
    $classes[] = 'with-block-editing';
  }

  // Render block classes.
  $vars['classes'] = implode(' ', $classes);
}
// */

?>
