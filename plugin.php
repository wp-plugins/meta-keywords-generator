<?php
/*
Plugin Name: Meta Keywords Generator
Plugin URI: http://techphernalia.com/meta-keywords-generator/
Description: This plugin helps your SEO by adding meta keywords tag to each page and post. Plugin from one of the best coder <a href="http://techphernalia.com/" target="_blank">Durgesh Chaudhary</a>. For any support just leave your question at our <a href="http://techphernalia.com/forum/" target="_blank">discussion forum</a>.
Version: 1.02
Author: Durgesh Chaudhary
Author URI: http://techphernalia.com/
*/

function tp_notify () {
	echo '<p>SEO provided by <strong><a href="http://techphernalia.com/meta-keywords-generator/" target="_blank">Meta Keywords Generator</a></strong> from <a href="http://techphernalia.com/" target="_blank">techphernalia.com</a></p>';
}

function tp_parse ($str) {
	$str = str_replace("\"","'",$str);
	$done = str_replace(", "," ",$str);
	$done = str_replace(" ",", ",$done);
	if (strpos($str," ")) return $str.", ".$done;
	else return $str;
}

function tp_act () {
	$name = get_option("blogname");
	$desc = get_option("blogdescription");
	
	if (is_tag()) $title = single_tag_title('',false);
	if (is_category()) $title = single_cat_title('',false);
	if (is_single() || is_page()) {
		$add = "";
		$postid = get_query_var("p");
		$post = get_post($postid);
		$title = single_post_title('',false);
		
		$catlist = get_the_category($post->ID);
		if (is_array($catlist)) {
			foreach ($catlist as $catlist) {
				$add .= ", ".$catlist->name;
			}
		}
		
		$taglist = get_the_tags($post->ID);
		if (is_array($taglist)) {
			foreach ($taglist as $taglist) {
				$add .= ", ".$taglist->name;
			}
		}
		
		$description = substr(strip_tags($post->post_content),0,200);
	}
	if (!is_home()) {
		echo '<meta name="keywords" content="'.tp_parse($title).', '.tp_parse($name).$add.'" />';
		echo '<meta name="description" content="'.str_replace("\"","'",strip_shortcodes( $description )).'" />';
	} else {
		echo '<meta name="keywords" content="'.tp_parse($desc).', '.$name.'" />';
		echo '<meta name="description" content="'.str_replace("\"","'",strip_shortcodes( $desc )).'" />';
	}
}

add_action('wp_head','tp_act');
add_action('rightnow_end','tp_notify');

?>