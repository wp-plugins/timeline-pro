<?php
/*
Plugin Name: Timeline Pro
Plugin URI: http://kentothemes.com
Description: Timeline Pro is pure HTML & CSS timeline style grid for WordPress.
Version: 1.1
Author: kentothemes
Author URI: http://kentothemes.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/




require_once( plugin_dir_path( __FILE__ ) . 'timeline-meta.php');


define('TIMELINE_PRO_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

function timeline_pro_init()
	{
	wp_enqueue_script('jquery');
	wp_enqueue_style('timeline_pro-css', TIMELINE_PRO_PLUGIN_PATH.'css/style.css');
	wp_enqueue_script('timeline_pro_ajax_js', plugins_url( '/js/timeline-pro-script.js' , __FILE__ ) , array( 'jquery' ));
	wp_localize_script( 'timeline_pro_ajax_js', 'timeline_pro_ajax', array( 'timeline_pro_ajaxurl' => admin_url( 'admin-ajax.php')));
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'timeline-pro-script', plugins_url('/js/timeline-pro-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	}
add_action('init', 'timeline_pro_init');



function timeline_pro_ajax_display()
		{	
			
			
			if(isset($_POST['offset'])) $offset = (int)$_POST['offset'];
			

				$postid = $_POST['timeline_id'];
				$timeline_pro_posttype = get_post_meta( $postid, 'timeline_pro_posttype', true );
				$timeline_pro_hide_thumb = get_post_meta( $postid, 'timeline_pro_hide_thumb', true );
				$timeline_pro_content = get_post_meta( $postid, 'timeline_pro_content', true );
				$timeline_pro_excrept_length = get_post_meta( $postid, 'timeline_pro_excrept_length', true );
				$timeline_pro_excrept_readmore = get_post_meta( $postid, 'timeline_pro_excrept_readmore', true );
				$timeline_pro_maincolor = get_post_meta( $postid, 'timeline_pro_maincolor', true );
				$timeline_pro_bgcolor = get_post_meta( $postid, 'timeline_pro_bgcolor', true );

			
			

			

	$posts_per_page = get_option('posts_per_page');	
			
			if($offset%2==0)
				{
				$last_class = 'even';
				}
			else
				{
				$last_class = 'odd';
				}



global $post;


		$query = new WP_Query( array( 'post_type' => $timeline_pro_posttype, 'posts_per_page' => $posts_per_page, 'offset' => $offset ) );
			


			








		if ( $query->have_posts() ) {
			
			if($last_class=="odd")
				{
					$i= 2;
				}
			elseif($last_class=="even")
				{
					$i= 1;
				}
			else
				{
					$i= 1;
				}


		if ( wp_is_mobile() ) {
			
				$even = "stic";
				$odd = "stic";
			}
		else
			{
				$even = "even";
				$odd = "odd";
			}
			$timeline_pro = "";
			
			while ($query->have_posts()) : $query->the_post();
			{	
				
			
			if($i%2==0)
				{	
							
							$timeline_pro .=  "<li class='".$even." new' data-class='even'>";
							$timeline_pro .=  "<div class='content'>";
							$timeline_pro .=   "<div class='arrow'></div>";
	
				}
			else
				{
							$timeline_pro .=  "<li class='".$odd." new' data-class='odd'>";
							$timeline_pro .=  "<div class='content'>";
							$timeline_pro .=  "<div class='arrow'></div>";

				}
				
				
				

				$timeline_pro .=  "<div class='zoom'></div>";


				$timeline_pro .=  "<div class='share'>";
				$timeline_pro .=  "<span class='fb'><a target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=".get_permalink()."'> </a></span>";
				$timeline_pro .=  "<span class='twitter'><a target='_blank' href='https://twitter.com/intent/tweet?text=".get_the_title()."&url=".get_permalink()."'> </a></span>";
				$timeline_pro .=  "<span class='gplus'><a target='_blank' href='https://plus.google.com/share?url=".get_permalink()."'> </a></span>";
				$timeline_pro .=  "</div>";	


				$timeline_pro .=  "<div class='thumb'>";
				$timeline_pro .=  get_avatar(get_the_author_meta('ID'), 100);
				$timeline_pro .=  "</div>";
				
				$timeline_pro .=  "<div class='meta'><div class='title'><a href='".get_permalink()."'>".get_the_title('', '', true, '40')."</a></div>";
				
$categories = get_the_category();
$separator = ', ';
$output = '';
if($categories){
	foreach($categories as $category) {
		$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
	}

}
				
				
				
				$timeline_pro .=  "<span class='date'>Date: ".get_the_date().",  By ".get_the_author()." Category - ".trim($output, $separator)."</span></div>";
				
				if($timeline_pro_content=="content")
					{
					$timeline_pro .=  "<div class='body'>".apply_filters('the_content', get_the_content())."</div>";
					}
				elseif($timeline_pro_content=="excrept")
					{
						$content =apply_filters('the_content', get_the_content());
						$timeline_pro .=  "<div class='body'>".wp_trim_words( $content , $timeline_pro_excrept_length, '<a class="read-more" href="'. get_permalink() .'">'.$timeline_pro_excrept_readmore.'</a>' )."</div>";
					}
				else
					{
						$content =apply_filters('the_content', get_the_content());
		
						$timeline_pro .=  "<div class='body'>".wp_trim_words( $content, $timeline_pro_excrept_length, '<a class="read-more" href="'. get_permalink() .'">'.$timeline_pro_excrept_readmore.'</a>' )."</div>";
					}
				


					if($timeline_pro_hide_thumb=="1")
						{
						$timeline_pro .=  "<div class='thumb-image'>";
						
						if ( has_post_thumbnail() ) { 
							  $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
							  $timeline_pro .=  "<img src='".$url."' />";
							} 
						
						$timeline_pro .=  "</div>";
				}




				
				$comments_count =  wp_count_comments($post->ID);
				
				
				$timeline_pro .=  "<div class='meta-count'><div class='comments-count' postid='".get_the_ID()."' >Total Comments: ". $comments_count->approved."</div><div class='comments-loading comments-loading-".get_the_ID()."'><span class='loading'></span></div>";
				$timeline_pro .=  "<div class='list-comments list-comments-".get_the_ID()."'></div>";
				$timeline_pro .=  "</div>";

					
					
				$timeline_pro .=  "</div>";	
				$timeline_pro .=  "</li>";

			$i++;
			}

			
			
			endwhile;

			echo $timeline_pro;
			
			
			
			
		}

		else {
?>
<script>
jQuery(document).ready(function(jQuery)
	{
		jQuery("#load-more").attr("has_post","no");

	})
</script>
<?php

		}



wp_reset_query();

		
			
		die();
		}
add_action('wp_ajax_timeline_pro_ajax_display', 'timeline_pro_ajax_display');
add_action('wp_ajax_nopriv_timeline_pro_ajax_display', 'timeline_pro_ajax_display');










function timeline_pro_display($atts,  $content = null ) {
		$atts = shortcode_atts(
			array(
				'id' => "",
				), $atts);
		$postid = $atts['id'];

	//Options
	$posts_per_page = get_option('posts_per_page');

	// Post Meta
	$timeline_pro_posttype = get_post_meta( $postid, 'timeline_pro_posttype', true );
	$timeline_pro_hide_thumb = get_post_meta( $postid, 'timeline_pro_hide_thumb', true );
	$timeline_pro_content = get_post_meta( $postid, 'timeline_pro_content', true );
	$timeline_pro_excrept_length = get_post_meta( $postid, 'timeline_pro_excrept_length', true );
	$timeline_pro_excrept_readmore = get_post_meta( $postid, 'timeline_pro_excrept_readmore', true );
	$timeline_pro_maincolor = get_post_meta( $postid, 'timeline_pro_maincolor', true );
	$timeline_pro_bgcolor = get_post_meta( $postid, 'timeline_pro_bgcolor', true );


	
	global $post;
		

	 
	 $timeline_pro = "";
	 

		
	$query = new WP_Query( array( 'post_type' => $timeline_pro_posttype, 'posts_per_page' => $posts_per_page ) );

	 

	 


		if ( $query->have_posts() ) {
			
			$timeline_pro .= "<div style='background:".$timeline_pro_bgcolor."' class='timeline-container'>";
			timeline_pro_style($postid);
			$timeline_pro .=  "<div class='v-line'></div>";
			
		if ( wp_is_mobile() ) {
			
				$even = "stic";
				$odd = "stic";
				$detect = "Mobile";
			}
		else
			{
				$even = "even";
				$odd = "odd";
				$detect = "PC";
			}


			
			$timeline_pro .=  "<ul class='timeline'>";
			
				$i= 1;		
			while ($query->have_posts()) : $query->the_post();
			{	
			
				
			
			
				if(is_sticky($post->ID))
					{
						$sticky ="stic";
					}
				else 
					{
					$sticky ="";
					}
				
			
			if($i%2==0)
				{	
					if(is_sticky($post->ID))
						{
							$timeline_pro .=  "<li class='stic' data-class='stic'>";
							$timeline_pro .=  "<div class='content'>";
							$timeline_pro .=  "<div class='featured' title='featured post'></div>";
						}
					else 
						{
							$timeline_pro .=  "<li class='".$even."' data-class='even'>";
							$timeline_pro .=  "<div class='content'>";
							$timeline_pro .=  "<div class='arrow'></div>";
							
						}
				}
			else
				{
					if(is_sticky($post->ID))
						{
							$timeline_pro .=  "<li class='stic' data-class='stic'>";
							$timeline_pro .=  "<div class='content'>";
							
							$timeline_pro .=  "<div class='featured' title='featured post'></div>";
							
						}
					else 
						{
							$timeline_pro .=  "<li class='".$odd."' data-class='odd'>";
							$timeline_pro .=  "<div class='content'>";
							$timeline_pro .=  "<div class='arrow'></div>";
							
						}
				}

				$timeline_pro .=  "<div class='zoom'></div>";
		
				

				

				$timeline_pro .=  "<div class='share'>";
				$timeline_pro .=  "<span class='fb'><a target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=".get_permalink()."'> </a></span>";
				$timeline_pro .=  "<span class='twitter'><a target='_blank' href='https://twitter.com/intent/tweet?text=".get_the_title()."&url=".get_permalink()."'> </a></span>";
				$timeline_pro .=  "<span class='gplus'><a target='_blank' href='https://plus.google.com/share?url=".get_permalink()."'> </a></span>";			
				$timeline_pro .=  "</div>";

				


				$timeline_pro .=  "<div class='thumb'>";
				
				$timeline_pro .=  get_avatar(get_the_author_meta('ID'), 100);
				$timeline_pro .=  "</div>";
				$timeline_pro .=  "<div class='meta'><div class='title'><a href='".get_permalink()."'>".get_the_title('', '', true, '40')."</a></div>";
				
$categories = get_the_category();
$separator = ', ';
$output = '';
if($categories){
	foreach($categories as $category) {
		$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
	}

}
				
				
				
				$timeline_pro .=  "<span class='date'>Date: ".get_the_date().",  By ".get_the_author()." Category - ".trim($output, $separator)."</span></div>";
				
			
				
				
				
				
				if($timeline_pro_content=="content")
					{
					
					$timeline_pro .=  "<div class='body'>".apply_filters('the_content', get_the_content())."</div>";
					}
				elseif($timeline_pro_content=="excrept")
					{
						$content =apply_filters('the_content', get_the_content());
		
						$timeline_pro .=  "<div class='body'>".wp_trim_words( $content, $timeline_pro_excrept_length, '<a class="read-more" href="'. get_permalink() .'">'.$timeline_pro_excrept_readmore.'</a>' )."</div>";
					}
				else
					{
						
						$content =apply_filters('the_content', get_the_content());
		
						$timeline_pro .=  "<div class='body'>".wp_trim_words( $content, $timeline_pro_excrept_length, '<a class="read-more" href="'. get_permalink() .'">'.$timeline_pro_excrept_readmore.'</a>' )."</div>";
					}
				
				


					if($timeline_pro_hide_thumb=="1")
						{
							$timeline_pro .=  "<div class='thumb-image'>";
							
							if ( has_post_thumbnail() ) { 
								  $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
								  $timeline_pro .=  "<img src='".$url."' />";
								} 
							$timeline_pro .=  "</div>";
						}
				
				
				$comments_count =  wp_count_comments($post->ID);
				
				
				$timeline_pro .=  "<div class='meta-count'><div class='comments-count' postid='".get_the_ID()."' >Total Comments: ". $comments_count->approved."</div><div class='comments-loading comments-loading-".get_the_ID()."'><span class='loading'></span></div>";

				$timeline_pro .=  "<div class='list-comments list-comments-".get_the_ID()."'></div>";
				$timeline_pro .=  "</div>";		//meta-count
				

				
				
				$timeline_pro .=  "</div>";	
				$timeline_pro .=  "</li>";

			$i++;
			}
			
			endwhile;

			$timeline_pro .=  "</ul>";

			
			$timeline_pro .=  "<div class='load-more' timeline_id='".$postid."' id='load-more' has_post='yes'  offset='".$posts_per_page."' per_page=".$posts_per_page."><div class='content '>Load More...</div></div>";
			$timeline_pro .=  "</div>";	
			
		}
	else
		{	
			$timeline_pro .= "<div style='background:".$timeline_pro_bgcolor."' class='timeline-container'>";
			timeline_pro_style($postid);
			$timeline_pro .=  "<div class='v-line'></div>";
		
		$timeline_pro .=  "<ul class='timeline'>";
			$timeline_pro .=  "<li class='stic' data-class='stic'>";
			$timeline_pro .=  "<div class='content'><br />No Post Found";
			$timeline_pro .=  "<div class='arrow'></div></div>";
			
			
			$timeline_pro .=  "</li>";
			$timeline_pro .=  "</ul>";
		
		}
			wp_reset_query();
			
			

			
			return $timeline_pro;
		
}


add_shortcode('timeline_pro', 'timeline_pro_display');


















function timeline_pro_comments()
	{
	$postid = (int)$_POST["postid"];


				$comments_count =  wp_count_comments($postid);

				$total_comments =$comments_count->approved;
				
				if($total_comments<=0)
					{
					echo "<div class=' no-comments'>No Comments Yet</div>";
					}
				else
					{

						$comments = get_comments(array(
							'post_id' => $postid,
							'status' => 'approve' 
						));
				
						//Display the list of comments
						echo "<ol class='commentlist'>";
						wp_list_comments(array(
							'per_page' => 10, //Allow comment pagination
							'max_depth'         => 2,
							'avatar_size'       => 80,
							'reverse_top_level' => false //Show the latest comments at the top of the list
						), $comments);
						echo "</ol>";
					}















	
	die();

	}

add_action('wp_ajax_timeline_pro_comments', 'timeline_pro_comments');
add_action('wp_ajax_nopriv_timeline_pro_comments', 'timeline_pro_comments');





function timeline_pro_style($postid)
	{
	
	$maincolor = $timeline_pro_maincolor = get_post_meta( $postid, 'timeline_pro_maincolor', true );
	$bgcolor = $timeline_pro_bgcolor = get_post_meta( $postid, 'timeline_pro_bgcolor', true );
	
	
	if($bgcolor=="none") $bgcolor = "#000";
		
		echo "<style type='text/css'>";
		echo "
				
			.timeline-container .v-line
				{
				background:none repeat scroll 0 0 ".$maincolor.";
				}
				
			.timeline > li.even:after
				{
				background:none repeat scroll 0 0 ".$maincolor.";
				border:6px solid ".$bgcolor.";
				}
		.timeline li.odd .content .arrow {
			border-left: 10px solid ".$maincolor.";
			}
		.timeline li.even .content .arrow{
			border-right:10px solid ".$maincolor.";
			}
		
			.timeline > li.odd:hover:after, .timeline > li.even:hover:after {
				background: none repeat scroll 0 0 ".$maincolor.";
				border:6px solid ".$maincolor.";
			}
		
			.timeline > li.odd:after{
				background:none repeat scroll 0 0 ".$maincolor.";
				border:6px solid ".$bgcolor.";
			}
		
			.timeline li.stic .content{
				border-top:2px solid ".$maincolor." !important;
			}
			.timeline li.stic .content:before
			{
				border-bottom-color:".$maincolor.";
			}


			.timeline li.even .content
			{
				border-left:2px solid ".$maincolor." !important;
			}


			.timeline li.odd .content
			{
				border-right:2px solid ".$maincolor.";
			}



			.timeline li .content .zoom {
			  background-color:".$maincolor.";
			}


			.timeline li .content .share
			{
				background: none repeat scroll 0 0 ".$maincolor.";
			}
			.timeline li .content .featured {
			  background-color:".$maincolor.";
			}
	
			.timeline li .content .meta .title a:hover {
			  color: ".$maincolor.";
			}
			.timeline li .content .meta-count {
			  background: none repeat scroll 0 0 ".$maincolor.";
			}
	
			.timeline-container .load-more .loading{
			background-color:".$maincolor.";
			}
	
			.timeline-container .load-more .no-post{
				background-color: ".$maincolor.";
			}
			.timeline li .content .body .read-more:hover{
				color: ".$maincolor.";
				}
	
	
			</style>";
	
	}








function  timeline_pro_ajaxComment($comment_ID, $comment_status) {
	// If it's an AJAX-submitted comment
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		// Get the comment data
		$comment = get_comment($comment_ID);
		// Allow the email to the author to be sent
		wp_notify_postauthor($comment_ID, $comment->comment_type);
		// Get the comment HTML from my custom comment HTML function
		$commentContent = getCommentHTML($comment);
		// Kill the script, returning the comment HTML
		die($commentContent);
	}
}

add_action('comment_post', 'timeline_pro_ajaxComment', 20, 2);



/* ********************************************************** */



add_action('admin_init', 'timeline_pro_option_init' );
add_action('admin_menu', 'timeline_pro_menu');



function timeline_pro_option_init(){
	register_setting( 'timeline_pro_plugin_options', 'timeline_pro_maincolor');
	register_setting( 'timeline_pro_plugin_options', 'timeline_pro_bgcolor');
	register_setting( 'timeline_pro_plugin_options', 'timeline_pro_posttype');
	register_setting( 'timeline_pro_plugin_options', 'timeline_pro_hide_thumb');	
	register_setting( 'timeline_pro_plugin_options', 'timeline_pro_content');	
	register_setting( 'timeline_pro_plugin_options', 'timeline_pro_excrept_length');
	register_setting( 'timeline_pro_plugin_options', 'timeline_pro_excrept_readmore');	

	

    }

function timeline_pro_menu() {
		add_submenu_page('edit.php?post_type=timeline_pro', __('Timeline Pro Info','timeline_pro'), __('Timeline Pro Info','timeline_pro'), 'manage_options', 'timeline_pro_settings_page', 'timeline_pro_settings_page');
}


function timeline_pro_settings_page(){
	include('tp-pro.php');	
}











?>