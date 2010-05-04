<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<div class="slide" id="feat<?php print $id; ?>" style="background-image:url(<?php print $fields[field_content_image_fid]->content; ?>);">
<?php if ($fields['type']->content=='Announcement'){
		print '<h3>'.$fields['field_title_2_value']->content.'</h3>';
		$fields['title']->content=strip_tags($fields['title']->content);
		}
	  else if ($fields['type']->content=='Event'){
	      $event_date = check_plain($fields['field_date_value']->raw);
		  $event_date = strtotime($event_date) - (3600*7);
		  $now=time();
		  $a = FALSE;
		  if ( $event_date >= $now ) { print '<h3>Upcoming Event</h3>'; }
		  else { print '<h3>Archived Event</h3>'; $a = TRUE; }
		  }

	print('<h4>'.$fields['title']->content.'<br />');
	if ($fields['type']->content!='Announcement' && !$a){ print($fields['field_date_value']->content.'</h4>');}
	else { print '</h4>'; }
	print($fields['field_teaser_value']->content);
?>


<?php /*foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>
  <?php //print $id; ?> 
  <?php switch ($id) {
	  		case "title":
				print('<h4>'.$field->content.'<br />');
				break;
			case "field_date_value":
				print('<span>'.$field->content.'</span></h4>');
				break;
			case "field_teaser_value":
				print('<span>'.$field->content.'</span></h4>');
				break;
  		}
  ?>

<?php /*

  <<?php print $field->inline_html;?> class="views-field-<?php print $field->class; ?>">
    <?php if ($field->label): ?>
      <label class="views-label-<?php print $field->class; ?>">
        <?php print $field->label; ?>:
      </label>
    <?php endif; ?>
      <?php
      // $field->element_type is either SPAN or DIV depending upon whether or not
      // the field is a 'block' element type or 'inline' element type.
      ?>
      <<?php print $field->element_type; ?> class="field-content"><?php print $field->content; ?></<?php print $field->element_type; ?>>
  </<?php print $field->inline_html;?>>

<?php endforeach; ?>*/ ?>
</div>