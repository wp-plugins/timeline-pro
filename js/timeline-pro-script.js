jQuery(document).ready(function(jQuery)
	{	


	
	
	jQuery(document).on('click', '.zoom', function()

				{	
					
					var data_class = jQuery(this).parent().parent().attr("data-class");
					if(data_class=="odd")
						{
							jQuery(this).parent().parent().toggleClass("stic odd");
						}
					else if(data_class=="even")
						{
							jQuery(this).parent().parent().toggleClass("stic even");
						}
				});


	jQuery(document).on('click', '.comments-count', function()
		{	
			
			var postid = jQuery(this).attr("postid");
			
			jQuery('.comments-loading-'+postid+" .loading").css("display","block");
			
		jQuery.ajax(
			{
		type: 'POST',
		url:timeline_pro_ajax.timeline_pro_ajaxurl,
		data: {"action": "timeline_pro_comments", "postid":postid, },
		success: function(data)
				{	
					jQuery('.list-comments-'+postid).html(data);
					
				jQuery('.comments-loading-'+postid+" .loading").fadeOut("Fast");
				}
			});

		})
	
	
	
		jQuery(".timeline_pro_taxonomy_reset").click(function()
			{
				jQuery('input[name=timeline_pro_taxonomy]').attr('checked', false);
				jQuery('.timeline_pro_taxonomy_category').attr('checked', false);
				})
	
	
	
	
	
		jQuery(".timeline_pro_posttype").click(function()
			{
				
			jQuery('.timeline_pro_taxonomy').attr('checked', false);	
	
			})
	
		jQuery(".timeline_pro_taxonomy").click(function()
			{
				
			jQuery('.timeline_pro_posttype').attr('checked', false);
				
				
				
				var taxonomy = jQuery(this).val();
				jQuery(".timeline_pro_loading_taxonomy_category").css('display','block');

						jQuery.ajax(
							{
						type: 'POST',
						url: timeline_pro_ajax.timeline_pro_ajaxurl,
						data: {"action": "timeline_pro_get_taxonomy_category","taxonomy":taxonomy},
						success: function(data)
								{	
									jQuery(".timeline_pro_taxonomy_category").html(data);
									jQuery(".timeline_pro_loading_taxonomy_category").fadeOut('slow');
								}
							});

		
			})
	
	
	
	
	
	jQuery(".load-more").click(function()
			{	

		jQuery("#load-more .content").addClass("loading");


				var timeline_id = jQuery(this).attr("timeline_id");
				
				
				
				var per_page = parseInt(jQuery(this).attr("per_page"));
				var offset = parseInt(jQuery(this).attr("offset"));
				var has_post = jQuery(this).attr("has_post");

				
				jQuery("#load-more .content").html("loading...");
				
				if(has_post=="no")
					{

						jQuery("#load-more .content").text("No more post.");
						jQuery("#load-more .content").removeClass("loading");
						jQuery("#load-more .content").addClass("no-post");
					}
				else if(has_post=="yes")
					{
					
						jQuery.ajax(
							{
						type: 'POST',
						url: timeline_pro_ajax.timeline_pro_ajaxurl,
						data: {"action": "timeline_pro_ajax_display","timeline_id":timeline_id,"offset":offset},
						success: function(data)
								{	
									jQuery("ul.timeline").append(data);
									jQuery("#load-more .content").removeClass("loading");
									jQuery("#load-more .content").html("Load More...");
									var offest_last = parseInt(offset+per_page);
									jQuery("#load-more").attr("offset",offest_last);
									
									


									jQuery("ul.timeline li.new").hide();
								
									jQuery("ul.timeline li.new").fadeIn(1000);
									setTimeout(function(){
										jQuery("ul.timeline li").removeClass("new");
										}, 5000)
	
									
								}
							});
					
					}					

				
				
				  
		});















/********/




	

    jQuery('document').ready(function(jQuery){
            var commentform=jQuery('#commentform'); // find the comment form
            commentform.prepend('<div id="comment-status" ></div>'); // add info panel before the form to provide feedback or errors
            var statusdiv=jQuery('#comment-status'); // define the infopanel
           
            commentform.submit(function(){
                            //serialize and store form data in a variable
                            var formdata=commentform.serialize();
                            //Add a status message
                            statusdiv.html('<p>Processing...</p>');
                            //Extract action URL from commentform
                            var formurl=commentform.attr('action');
                            //Post Form with data
                            jQuery.ajax({
                                    type: 'post',
                                    url: formurl,
                                    data: formdata,
                                    error: function(XMLHttpRequest, textStatus, errorThrown){
                                            statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
                                    },
                                    success: function(data, textStatus){
                                            if(data=="success")
                                                    statusdiv.html('<p class="ajax-success" >Thanks for your comment. We appreciate your response.</p>');
                                            else
                                                    statusdiv.html('<p class="ajax-error" >Comment Submitted</p>');
                                            commentform.find('textarea[name=comment]').val('');
                                    }
                            });
                            return false;
                   
            });
    });























		
	});