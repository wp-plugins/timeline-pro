<?php	
	if(empty($_POST['timeline_pro_hidden']))
		{
			$timeline_pro_maincolor = get_option( 'timeline_pro_maincolor' );
			$timeline_pro_bgcolor = get_option( 'timeline_pro_bgcolor' );
			$timeline_pro_posttype = get_option( 'timeline_pro_posttype' );
			$timeline_pro_hide_thumb = get_option( 'timeline_pro_hide_thumb' );
			$timeline_pro_content = get_option( 'timeline_pro_content' );
			$timeline_pro_excrept_length = get_option( 'timeline_pro_excrept_length' );
			$timeline_pro_excrept_readmore = get_option( 'timeline_pro_excrept_readmore' );			
			
			
		}
	elseif($_POST['timeline_pro_hidden'] == 'Y')
		{
			//Form data sent
			


			
			$timeline_pro_maincolor = $_POST['timeline_pro_maincolor'];
			update_option('timeline_pro_maincolor', $timeline_pro_maincolor);				
			
			$timeline_pro_bgcolor = $_POST['timeline_pro_bgcolor'];
			update_option('timeline_pro_bgcolor', $timeline_pro_bgcolor);			
			
			if(!empty($_POST['timeline_pro_posttype']))
				{
					$timeline_pro_posttype = $_POST['timeline_pro_posttype'];
				}
			else
				{
					$timeline_pro_posttype = "";
				}
				
			update_option('timeline_pro_posttype', $timeline_pro_posttype);
						
			if(isset($_POST['timeline_pro_hide_thumb']))
				{
					$timeline_pro_hide_thumb = $_POST['timeline_pro_hide_thumb'];
				
				}
			else
				{
					$timeline_pro_hide_thumb = "0";
				}
			
			update_option('timeline_pro_hide_thumb', $timeline_pro_hide_thumb);				
			
			
			$timeline_pro_content = $_POST['timeline_pro_content'];
			update_option('timeline_pro_content', $timeline_pro_content);				

			$timeline_pro_excrept_length = $_POST['timeline_pro_excrept_length'];
			update_option('timeline_pro_excrept_length', $timeline_pro_excrept_length);
			
			$timeline_pro_excrept_readmore = $_POST['timeline_pro_excrept_readmore'];
			update_option('timeline_pro_excrept_readmore', $timeline_pro_excrept_readmore);			
			


			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.' ); ?></strong></p>
            </div>

			<?php
		} else {
			//Normal page display
		
			

		}

?>


<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__('Kento Timeline Settings')."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="timeline_pro_hidden" value="Y">
        <?php settings_fields( 'timeline_pro_plugin_options' );
				do_settings_sections( 'timeline_pro_plugin_options' );

		?>

<table class="form-table">
               
	<tr valign="top">
		<th scope="row"><label for="timeline_pro-maincolor">TimeLine Main Color</label></th>
		<td style="vertical-align:middle;">

<input type="text" name="timeline_pro_maincolor" id="timeline_pro-maincolor" value ="<?php  if ( isset($timeline_pro_maincolor) ) echo $timeline_pro_maincolor; ?>"  ><br />
               
                     
		</td>
	</tr>


<tr valign="top">
		<th scope="row"><label for="timeline_pro-bgcolor">TimeLine Area Background Color</label></th>
		<td style="vertical-align:middle;">

<input type="text" name="timeline_pro_bgcolor" id="timeline_pro-bgcolor" value ="<?php  if ( isset($timeline_pro_bgcolor) ) echo $timeline_pro_bgcolor; ?>"  ><br />
               
                     
		</td>
	</tr>


<tr valign="top">
		<th scope="row">Display These Post Type</th>
		<td style="vertical-align:middle;">
        
<?php

$post_types = get_post_types( '', 'names' ); 

foreach ( $post_types as $post_type ) {

	if($post_type=='post')
		{
		   echo '<label for="timeline_pro-posttype['.$post_type.']"><input type="checkbox" name="timeline_pro_posttype['.$post_type.']" id="timeline_pro-posttype['.$post_type.']"  value ="1" ' ?> 
		   <?php if ( isset( $timeline_pro_posttype[$post_type] ) ) echo "checked"; ?>
		   <?php echo' >'. $post_type.'</label><br />' ;
	   
		}
	else
		{
		   echo '<label for="timeline_pro-posttype['.$post_type.']"><input type="checkbox" name="timeline_pro_posttype['.$post_type.']" id="timeline_pro-posttype['.$post_type.']"  value ="1" ' ?> 
		   <?php if ( isset( $timeline_pro_posttype[$post_type] ) ) echo "checked"; ?>
		   <?php echo' >'. $post_type.'</label><br />' ;
   
		}

}
?>
                           

		</td>
	</tr>


<tr valign="top">
		<th scope="row">Display Thumbnails</th>
		<td style="vertical-align:middle;">
        <label for="timeline_pro-hide-thumb">
        <input type="checkbox" name="timeline_pro_hide_thumb" id="timeline_pro-hide-thumb"  value ="1" <?php if (  $timeline_pro_hide_thumb=="1") echo "checked"; ?> >
        
		<?php if (  $timeline_pro_hide_thumb=="1") {echo "Hide";} else { echo "Dispaly"; } ?>
        
        </label>
        </td>
	</tr>



<tr valign="top">
		<th scope="row">Display Content</th>
		<td style="vertical-align:middle;">
        <select name="timeline_pro_content" class="timeline_pro_content" >
        	<option value="content" <?php if (  $timeline_pro_content=="content") echo "selected"; ?> >Full Content</option>
            <option   value="excrept" <?php if (  $timeline_pro_content=="excrept") echo "selected"; ?> >Excerpt</option>       
        </select>
        <br />
        <br />
        
        <script>
		jQuery(document).ready(function(jQuery){
			jQuery(".timeline_pro_content").change(function()
					{
						var timeline_pro_content = jQuery('.timeline_pro_content').val();
						
						
						
						if(timeline_pro_content=="excrept")
							{
								jQuery("#timeline_pro-excrept").css("display","block");
								
							}
						else
							{
								jQuery("#timeline_pro-excrept").css("display","none");
								
							}
						
						
						})
	})
		</script>
        
        
   
        
<div id="timeline_pro-excrept"  <?php if (  $timeline_pro_content=="excrept") {echo "style='display:block;'";} else {echo "style='display:none;'";} ?> >
        <label for="timeline_pro_excrept_length" >
      	 Excrept Length:<br />
        
        <input type="text" name="timeline_pro_excrept_length" id="timeline_pro_excrept_length"  value ="<?php if (!empty($timeline_pro_excrept_length)) { echo $timeline_pro_excrept_length; } else {echo "50";} ?>"  >
        </label>
        <br /><br />
        <label for="timeline_pro_excrept_readmore" >
        Read More Text: <br />
        <input type="text" name="timeline_pro_excrept_readmore" id="timeline_pro_excrept_readmore"  value ="<?php if (!empty($timeline_pro_excrept_readmore)) { echo $timeline_pro_excrept_readmore; } else {echo "Read More...";} ?>"  >        
        </label>
        
        
</div>








        </td>
	</tr>










<tr valign="top">
		<th scope="row">Need Help ?</th>
		<td style="vertical-align:middle;">
        
We will be happy to help you :) <br />
        Please report any issue via our support forum <a href="http://kentothemes.com/questions-answers/">kentothemes.com &raquo; Q&A</a> or aks any question if you need. <br />
        Check Documentation  <a href="http://kentothemes.com/documentation/">http://kentothemes.com/documentation/</a><br />
        
        
                           

		</td>
	</tr>













 <script>
 jQuery(document).ready(function()
	{
 		jQuery("#timeline_pro-maincolor, #timeline_pro-bgcolor").wpColorPicker();
	})
 </script>


</table>
                <p class="submit">
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes' ) ?>" />
                </p>
		</form>

   
</div>
