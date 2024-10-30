<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
Plugin Name: jBreadCrumb Aink
Plugin URI: http://www.classifindo.com/jbreadcrumb-aink/
Description: Adds a breadcrumb navigation showing the current location.
Author: Dannie Herdyawan a.k.a k0z3y
Version: 2.0
Author URI: http://www.classifindo.com/
*/


/*
   _____                                                 ___  ___
  /\  __'\                           __                 /\  \/\  \
  \ \ \/\ \     __      ___     ___ /\_\     __         \ \  \_\  \
   \ \ \ \ \  /'__`\  /' _ `\ /` _ `\/\ \  /'__'\        \ \   __  \
    \ \ \_\ \/\ \L\.\_/\ \/\ \/\ \/\ \ \ \/\  __/    ___  \ \  \ \  \
     \ \____/\ \__/.\_\ \_\ \_\ \_\ \_\ \_\ \____\  /\__\  \ \__\/\__\
      \/___/  \/__/\/_/\/_/\/_/\/_/\/_/\/_/\/____/  \/__/   \/__/\/__/

*/

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

global $jBreadCrumbAink_path;
$jBreadCrumbAink_path = get_settings('home').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));

/* When plugin is deactivation*/
register_deactivation_hook( __FILE__, 'hapus_jBreadCrumbAink' );
function hapus_jBreadCrumbAink()
{
	/* Deletes the database field */
	global $options;
	$options = get_option('jBreadCrumbAink_option');
	delete_option($options);
}

/* Call the html code */
add_action('admin_menu', 'jBreadCrumbAink_admin_menu');
function jBreadCrumbAink_admin_menu() {
	if((current_user_can('manage_options') || is_admin)) {
		global $jBreadCrumbAink_path;
		add_object_page('jBreadCrumb-Aink','jBreadCrumb',1,'jBreadCrumb-Aink','jBreadCrumbAink_page',$jBreadCrumbAink_path.'/images/favicon.png');
		add_submenu_page('jBreadCrumb-Aink','jBreadCrumb Settings','Settings',1,'jBreadCrumb-Aink','jBreadCrumbAink_page');
	}
}

function jBreadCrumbAink_page() {
	if (isset($_POST['save'])) {
		$options['jBreadCrumbAink_width']			= trim($_POST['jBreadCrumbAink_width'],'{}');
		$options['jBreadCrumbAink_link']			= trim($_POST['jBreadCrumbAink_link'],'{}');
		update_option('jBreadCrumbAink_option', $options);
		// Show a message to say we've done something
		echo '<div class="updated"><p>' . __("Save Changes") . '</p></div>';
	} else {		
		$options = get_option('jBreadCrumbAink_option');
	}
	echo jBreadCrumbAinkSettings();
}

function jBreadCrumbAinkSettings() { global $options; $options = get_option('jBreadCrumbAink_option'); ?>
<div class="wrap">
<div class="icon32" id="icon-tools"><br/></div>
<h2><?php echo __('jBreadCrumb Aink'); ?></h2>

<form method="post" id="mainform" action="">
<table class="widefat fixed" style="margin:25px 0;">
	<thead>
		<tr>
			<th scope="col" width="200px">jBreadCrumb Aink Settings</th>
			<th scope="col">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="titledesc">jBreadCrumb width:</td>
			<td class="forminp">
				<input name="jBreadCrumbAink_width" id="jBreadCrumbAink_width" style="width:100px;" value="<?php echo $options[jBreadCrumbAink_width]; ?>" type="text">
				<br /><small>ex: "500px" or "100%" (without quotes).</small>
			</td>
		</tr><tr>
			<td class="titledesc">jBreadCrumb Show Link:</td>
			<td class="forminp">
				<input name="jBreadCrumbAink_link" type="checkbox" <?php
				if($options[jBreadCrumbAink_link] == 'check') {
					echo 'checked="checked" value="check"';
				} else if($options[jBreadCrumbAink_link] != 'check') {
					echo 'value="check"';					
				} else {
					echo 'checked="checked" value="check"';
				}
				?> />
				<br /><small>Show jBreadCrumb Aink link.</small>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="<?php get_option($options) ?>" />
<p class="submit bbot"><input name="save" type="submit" value="<?php esc_attr_e("Save Changes"); ?>" /></p>
</form>
</div>

	<div class="wrap"><hr /></div>

		<p style="margin-left:9px;">Place the following code into your theme files where you want the menu to appear:</p>
		<p style="margin-left:9px;"><code>&lt;?php if(function_exists('jBreadCrumbAink')) { echo jBreadCrumbAink(); } ?&gt;</code></p>

	<div class="wrap"><hr /></div>

<div class="wrap">
<table class="widefat fixed" style="margin:25px 0;">
	<thead>
		<tr>
			<th scope="col" width="200px">Donate for jBreadCrumb Aink</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="forminp">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="KQGBRC7HMPDA4">
<img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/id_ID/i/scr/pixel.gif" width="1" height="1">
<p class="submit bbot"><input type="image" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/en_GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online."></p>
</form>					
			</td>
		</tr>
	</tbody>
</table>
</div>

<?php }

function jBreadCrumbAink_new()
{
	echo CreateNewjBreadCrumbAink();
}

add_action("wp_head", "jBreadCrumbAink_head");

function jBreadCrumbAink_head()
{
	global $jBreadCrumbAink_path;

	echo '<!-- jBreadCrumb Aink -->

		<link type="text/css" rel="stylesheet" href="'.$jBreadCrumbAink_path.'/css/jbreadcrumb-aink.css">

		<script type="text/javascript" language="JavaScript" src="'.$jBreadCrumbAink_path.'/js/jquery.easing.js"></script>
		<script type="text/javascript" language="JavaScript" src="'.$jBreadCrumbAink_path.'/js/jquery.jBreadCrumb.js"></script>
		<script type="text/javascript" language="JavaScript">
			jQuery(document).ready(function() {
				jQuery("#jBreadCrumbAink").jBreadCrumb();
			})
		</script>';
	
	echo '<!-- jBreadCrumb Aink -->';
}

function jBreadCrumbAink() {
	global $jBreadCrumbAink_path, $options, $userdata, $post;
	$options = get_option('jBreadCrumbAink_option'); ?>

<div class="module" style="display:block;">
	<div id="jBreadCrumbAink" class="jBreadCrumbAink module" style="display:block;width:<?php if(isset($options[jBreadCrumbAink_width])){echo $options[jBreadCrumbAink_width];}else{echo '100%';} ?>;">
		<ul style="display:block;"><?php

	if($options[jBreadCrumbAink_link] == 'check'){
		echo '<li><a href="http://www.classifindo.com/jbreadcrumb-aink/" target="_blank">'.get_bloginfo('name').'</a></li>';
	} else {
		echo '<li><a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a></li>';
	}

	

	$currentBefore = '<li><a>';
	$currentAfter = '</a></li>';
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo '<li>'.(get_category_parents($parentCat, TRUE)).'</li>'; // Giacomo Rabiti HAS MODIFIED THIS LINE //
      echo $currentBefore . '';
      single_cat_title();
      echo '' . $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<li><a href="'.get_year_link(get_the_time('Y')).'" title="'.get_the_time('Y').'">'.get_the_time('Y').'</a></li>';
      echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')).'" title="'.get_the_time('F').'">'.get_the_time('F').'</a></li>';
      echo $currentBefore.get_the_time('d').$currentAfter;
 
    } elseif ( is_month() ) {
      echo '<li><a href="'.get_year_link(get_the_time('Y')).'" title="'.get_the_time('Y').'">'.get_the_time('Y').'</a></li>';
      echo $currentBefore.get_the_time('F').$currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore.get_the_time('Y').$currentAfter;
 
    } elseif ( is_single() && !is_attachment() ) {
      $cat = get_the_category(); $cat = $cat[0];
	  $catstr = get_category_parents($cat, TRUE, '</li><li>'); // Giacomo Rabiti HAS MODIFIED THIS LINE //
	  echo '<li>'.substr($catstr, 0, strlen($catstr) -8 ).'</li>'; // Giacomo Rabiti HAS MODIFIED THIS LINE //
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo '<li>'.get_category_parents($cat, TRUE).'</li>';
      echo '<li><a href="'.get_permalink($parent).'" title="'.$parent->post_title.'">'.$parent->post_title.'</a></li>';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="'.get_permalink($page->ID).'" title="'.get_the_title($page->ID).'">'.get_the_title($page->ID).'</a></li>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . '';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore.'Search results for &#39; ' . get_search_query() . '&#39;'.$currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore.'Posts tagged &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore.'Articles posted by ' . $userdata->display_name .$currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore.'Error 404' .$currentAfter;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
 
  }
?>

		</ul>
	</div>
</div>
<?php } ?>