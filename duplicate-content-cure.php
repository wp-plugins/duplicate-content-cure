<?php
/*
Plugin Name: Duplicate Content Cure
Plugin URI: http://www.howtostartablog.org/duplicate-content-cure/
Description: Duplicate content cure is a very simple, yet effective SEO plugin that prevents search engines from indexing WordPress pages that contain duplicate content, like archives and category pages.
Version: 1.0
Author: Badi Jones
Author URI: http://www.howtostartablog.org/
*/

/*******************************************************************************
 * Wordpress Duplicate Content Cure
 *=============================================================================
Duplicate Content Cure is an extremely simple plugin that prevents
duplicate content from being indexed by the search engines.  This
is achieved by adding nofollow, noindex


******************************************************************************/
defined( 'ABSPATH' ) or die( 'Sorry!' );

add_action('admin_menu', 'dupContCure_admin_actions');

function dupContCure_admin_actions(){
	add_options_page('Duplicate Content Cure','Duplicate Content Cure','manage_options',__FILE__,'dupContCure_admin');
}

function dupContCure_admin(){

$dupContCure_noindex_categories = 'checked';
$dupContCure_options_categories = 'on';
$dupContCure_noindex_tags = 'checked';
$dupContCure_options_tags = 'on';
$dupContCure_soptions = 'on,on';
$dupContCure_oparr = array();

if(isset($_POST['update_dupContCure_options'])){


	if(isset($_POST['dupContCure_noindex_categories'])){
		$dupContCure_noindex_categories = 'checked';
		$dupContCure_options_categories = 'on';
	
	}else{
		$dupContCure_noindex_categories = '';
		$dupContCure_options_categories = 'off';
	}
	
	if(isset($_POST['dupContCure_noindex_tags'])){
		$dupContCure_noindex_tags = 'checked';
		$dupContCure_options_tags = 'on';
	
	}else{
		$dupContCure_noindex_tags = '';
		$dupContCure_options_tags = 'off';
	
	}
	
	
	$dupContCure_soptions = $dupContCure_options_categories.','.$dupContCure_options_tags;
	
	update_option('dupContCure_noindex_options',$dupContCure_soptions); // Store noindex prefrences
	#echo "Just set options from _POST:  $dupContCure_soptions";


}else if(get_option('dupContCure_noindex_options')){

    $dupContCure_soptions = get_option('dupContCure_noindex_options');
    #echo "Options alredy set:  $dupContCure_soptions";

    
    $dupContCure_oparr = explode(",", $dupContCure_soptions);
    $dupContCure_options_categories = $dupContCure_oparr[0];
    $dupContCure_options_tags = $dupContCure_oparr[1];

    
    if($dupContCure_options_categories == 'on')
    	$dupContCure_noindex_categories = 'checked';
    else
    	$dupContCure_noindex_categories = '';


    if($dupContCure_options_tags == 'on')
    	$dupContCure_noindex_tags = 'checked';
	else
    	$dupContCure_noindex_tags = '';



	
////TODO Make storage string and make checked variables



}else{

//Set initial options
update_option('dupContCure_noindex_options',$dupContCure_soptions); // Store default noindex prefrences as string


}



echo <<< EOL
<div class="wrap">
<h2>Duplicate Content Cure</h2>

<p>By default, this plugin adds <code>noindex,follow</code> tags to <b>Tag</b>, <b>Category</b>, <b>Archive</b> pages, any pages with pagination (after the first page), basicaly everything except for <b>Pages</b>, <b>Posts</b>, the <b>blog front page</b>, and the <b>home page</b>.</p>

<p>Some users prefer to optimize Tag and Category pages by adding content and minimizing duplicate content instead of noindexing.  If that is the case, you can opt to leave these pages alone below.</p>

<h3>Options</h3>



<form action='' method='POST'>


<input type="checkbox" value="on" name="dupContCure_noindex_categories" id="noindex_categories" class="checkbox" $dupContCure_noindex_categories >
<label for="noindex-category" class="checkbox">Noindex Category Pages:</label>
<label for="noindex-category" class="checkbox"><code>noindex, follow</code></label><br class="clear">

<input type="checkbox" value="on" name="dupContCure_noindex_tags" id="noindex_tags" class="checkbox" $dupContCure_noindex_tags >
<label for="noindex-tag" class="checkbox">Noindex Tag Pages:</label>
<label for="noindex-tag" class="checkbox"><code>noindex, follow</code></label><br class="clear">

<br /><br />
<input type="submit" name="update_dupContCure_options" value="Update" class="button-primary" />

</form>

</div>



EOL;



}

// Add hidden style to trick spam bots 297
function dupContCure_wp_head() {
$theseDupOptions = '';
$dupContCure_meta_robots = '';


if(get_option('dupContCure_noindex_options')){

    $theseDupOptions = get_option('dupContCure_noindex_options');
    $theseDupOptionsArr = explode(",", $theseDupOptions);
    $theseDupOptionsCat = $theseDupOptionsArr[0];
    $theseDupOptionsTag = $theseDupOptionsArr[1];


    if($theseDupOptions == 'off,off'){
    //Allow Categories and Tags
		if((is_single() || is_page() || is_home() || is_category() || is_tag()) && (!is_paged()) ){
			$dupContCure_meta_robots = "\n";
		}else{
			$dupContCure_meta_robots = "<meta name=\"robots\" content=\"noindex,follow\">\n";
		}
    
    
    }else if($theseDupOptions == 'off,on'){
    //Allow Categories
		if((is_single() || is_page() || is_home() || is_category()) && (!is_paged()) ){
			$dupContCure_meta_robots = "\n";
		}else{
			$dupContCure_meta_robots = "<meta name=\"robots\" content=\"noindex,follow\">\n";
		}
    
    }else if($theseDupOptions == 'on,off'){
    //Allow Tags
		if((is_single() || is_page() || is_home() || is_tag()) && (!is_paged()) ){
			$dupContCure_meta_robots = "\n";
		}else{
			$dupContCure_meta_robots = "<meta name=\"robots\" content=\"noindex,follow\">\n";
		}
    
    }else{
    //Allow None
		if((is_single() || is_page() || is_home()) && (!is_paged()) ){
			$dupContCure_meta_robots = "\n";
		}else{
			$dupContCure_meta_robots = "<meta name=\"robots\" content=\"noindex,follow\">\n";
		}
    
    }


}else{

	if((is_single() || is_page() || is_home()) && (!is_paged()) ){
		$dupContCure_meta_robots = "\n";
	}else{
		$dupContCure_meta_robots = "<meta name=\"robots\" content=\"noindex,follow\">\n";
	}
	
}
	


echo $dupContCure_meta_robots;

}


/*******************************************************************************
 * Apply Duplicate Content Cure
 ******************************************************************************/

add_action('wp_head', 'dupContCure_wp_head');

?>