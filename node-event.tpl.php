<?php
// $Id: node.tpl.php,v 1.4 2008/09/15 08:11:49 johnalbin Exp $

/**
 * @file node.tpl.php
 *
 * Theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $picture: The authors picture of the node output from
 *   theme_user_picture().
 * - $date: Formatted creation date (use $created to reformat with
 *   format_date()).
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $name: Themed username of node author output from theme_user().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $submitted: themed submission information output from
 *   theme_node_submitted().
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $teaser: Flag for the teaser state.
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 */
 global $base_path;
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"><div class="node-inner">

  <?php print $picture; ?>
  <?php if ($page == 0) {// is 'teaser' ?>
  <?php print $field_content_image[0][view]; ?>
  <?php } ?>
  <?php //if (!$page): ?>
    <!--h2 class="title">
      <a href="<?php //print $node_url; ?>" title="<?php //print $title ?>"><?php //print $title; ?></a>
    </h2-->
  <?php //endif; ?>

  <?php if ($unpublished): ?>
    <div class="unpublished"><?php print t('Unpublished'); ?></div>
  <?php endif; ?>

  <?php if ($submitted or $terms): ?>
    <div class="meta">
      <?php if ($submitted): ?>
        <div class="submitted">
          <?php print $submitted; ?>
        </div>
      <?php endif; ?>

      <?php if ($terms): ?>
        <!--<div class="terms terms-inline"><?php //print $terms; ?></div-->
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="content">
  
  	  <?php if ($page == 0) {// is 'teaser' ?>
	<div class="vocabulary">
    <div class="terms event_category"><?php print $event_category; ?></div>
    <div class="terms event_header"><?php print $event_header; ?></div>
    </div>
    <p class="event_title"><?php print '<a href="'.$base_path.$path.'">'.$title.'</a>'; ?></p>
	<?php if ($field_title_2[0][value]){print '<p class="event_title_2">'.$field_title_2[0][value].'</p>';} ?>
    <div class="event_date"><?php print $field_date[0][view]; ?></div>
    
	<?php } else { // Is main page ?>
     <?php /*<pre style="background:#eee;border:1px solid black;clear:both;"><?php print_r($node) ?></pre>*/ ?>
     <div id="col3">
	 	<div class="module photo">
			<?php print $field_content_image[0][view] ?>
			<?php print $field_image_caption[0][view] ?>
        </div>
    </div>
    <div class="vocabulary">
    <div class="terms event_category"><?php print $event_category; ?></div>
    <div class="terms event_header"><?php print $event_header; ?></div>
    </div>
    <p class="event_title"><?php print $title; ?></p>
	<?php if ($field_title_2[0][value]){print '<p class="event_title_2">'.$field_title_2[0][value].'</p>';} ?>
    <div class="event_date"><?php print $field_date[0][view] ?></div>
    
    <hr class="clearall" />
	<?php //if ($terms): ?>
        <!--div class="terms terms-inline"><?php //print $terms; ?></div-->
      <?php //endif; ?>
    <?php //print $field_image_caption[0][value]; ?>
    
    <?php //print $field_attach[0][view]; ?>
    <?php if ($field_media[0][view] || $field_attach[0][view]) {
        print ('<div id="col3">');
        if ($field_media[0][view]) {
            print '<div class="module photo">'.$field_media[0][view].'<div class="image-caption">Watch a clip from the event.</div></div>';
            }
        if ($field_attach[0][view]) {
            print '<div class="module notes"><h3>Program Notes</h3>';
            foreach ($field_attach as $attach) print $attach[view];
            print '</div>';
			}
        print ('</div>');
		} ?>

    <?php print $content; ?>
    <?php /*if ($media_format) { print '<div class="vocabulary terms media_format">' . $media_format .'</div>'; } */?>
    <?php if ($field_sponsors[0][value]) { print '<div id="sponsors"><p>' . $field_sponsors[0][value] . '</p></div>'; } ?>

    <?php }; ?>
  </div>

  <?php //print $links; ?>

</div></div> <!-- /node-inner, /node -->
