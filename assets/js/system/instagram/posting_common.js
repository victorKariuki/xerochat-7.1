$(function() {
	"use strict";
	
    var image_list = [];
	$("document").ready(function()	{
	
		var emoji_message_div =	$("#message").emojioneArea({
        	autocomplete: false,
			pickerPosition: "bottom"
     	 });

		var today = new Date();
		var next_date = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
		$('.datepicker_x').datetimepicker({
			theme:'light',
			format:'Y-m-d H:i:s',
			formatDate:'Y-m-d H:i:s',
			minDate: today,
			maxDate: next_date

		});

		setTimeout(function() {		
			$(".upload_block").niceScroll();
		}, 1000);

		

		$(document).on('click','.select_media',function(e){
        	e.preventDefault();
        	var media_src = $(this).attr('src');
        	if($(this).hasClass('image'))
        	{
        		$(".select_media.image").removeClass('active');
        		$(this).addClass('active');
        		$('#image_url').val(media_src).blur();
        	}
        	else
        	{
        		$(".select_media.video").removeClass('active');
        		$(this).addClass('active');
        		$('#video_url').val(media_src).blur();
        	}
        });

		$(document).on('click','.video_format_info',function(e){
        	e.preventDefault();
        	$("#video_format_info_modal").modal();
        });

        $("#image_url_upload").uploadFile({
	        url:base_url+"instagram_poster/image_video_upload_image_only",
	        fileName:"myfile",
	        maxFileSize:instragram_post_image_upload_limit*1024*1024,
	        showPreview:false,
	        returnType: "json",
	        dragDrop: true,
	        showDelete: false,
	        multiple:false,
	        acceptFiles:".jpg,.jpeg",
	        onSuccess:function(files,data,xhr,pd)
            {
               var data_modified = base_url+"upload_caster/image_video/"+user_id+"/"+data;
               var new_html = '<div class="col-4 col-md-4 col-lg-4 p-0 no-gutters"><img src="'+data_modified+'" width="100%" height="90px" class="pr-1 pb-1 select_media image pointer"></div>';
               $("#image_block .upload_block").prepend(new_html);
               $('.select_media.image[src="'+data_modified+'"]').click();
            }
	    });

	    $("#video_url_upload").uploadFile({
	        url:base_url+"instagram_poster/image_video_upload_video",
	        fileName:"myfile",
	        maxFileSize:100*1024*1024,
	        showPreview:false,
	        returnType: "json",
	        dragDrop: true,
	        showDelete: false,
	        multiple:false,
	        acceptFiles:".mov,.mp4",
	        onSuccess:function(files,data,xhr,pd)
            {
               var data_modified = base_url+"upload_caster/image_video/"+user_id+"/"+data;
               var new_html = '<div class="col-4 col-md-4 col-lg-4 p-0 no-gutters"><video src="'+data_modified+'" width="100%" height="90px" class="pr-1 pb-1 select_media video pointer"></video></div>';
               $("#video_block .upload_block").prepend(new_html);
               $('.select_media.video[src="'+data_modified+'"]').click();
            }
	    }); 

        $(document).on('click','.delete_media',function(e){
          e.preventDefault();
          swal({
            title: global_lang_are_you_sure,
            text: global_lang_delete_confirmation,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) 
            {
              var file_url = $(this).attr('data-src');
		      $(this).addClass('btn-progress');
		      $.ajax({
		       type:'POST' ,
		       context : this,
		       url: base_url+"instagram_poster/image_video_delete_file",
		       data: {file_url:file_url},
		       success:function(response)
		       {
		         $(this).removeClass('btn-progress');
		       	 $('.select_media[src="'+file_url+'"]').parent().remove();
		       	 if($(this).hasClass('image'))
		       	 {
		       	 	$("#image_url").val('').blur();
		       	 }
				 else
				 {
				 	$("#video_url").val('').blur();
				 }
		       }

		      });
            } 
          });

          
        });

        $(document).on('keyup','.emojionearea-editor',function(){
		
        	var message=$("#message").val();
			message=htmlspecialchars(message);
			message=message.replace(/[\r\n]/g, "<br />");
			
        	if(message!="")
        	{
        		message=message+"<br/><br/>";
        		$(".preview_message").html(message);
        		$(".demo_preview").hide();
        	}
        });

        $(document).on('blur','#image_url',function(){

	        var link=$("#image_url").val();
	        link = link.trim();    	        
        	$(".preview_only_img_block").show();
        	$(".preview_video_block").hide();
        	if(link!="")
        	{
        		$("#image_edit_block a").attr('data-src',link);
        		$("#image_edit_block").removeClass("d_none");
        	}
        	else
        	{
        		$("#image_edit_block a").attr('data-src','');
        		$("#image_edit_block").addClass("d_none");
        	}
        	if(link=='')  link = base_url+'assets/img/example-image.jpg';
            $(".only_preview_img").attr("src",link);

        });

        $(document).on('blur','#video_url',function(){
        	var link=$("#video_url").val();
        	link = link.trim();
            var write_html='<video width="100%" height="auto" controls><source src="'+$("#video_url").val()+'">Your browser does not support the video tag.</video>';
            $(".preview_video_block").html(write_html).show();
            $(".preview_only_img_block").hide();
            if(link!="")
            {
            	$("#video_edit_block a").attr('data-src',link);
            	$("#video_edit_block").removeClass("d_none");
            }
            else
        	{
        		$("#video_edit_block a").attr('data-src','');
        		$("#video_edit_block").addClass("d_none");
        	}

        });

        $(document).on('click','.post_type',function(){

        	var post_type=$(this).attr("id");
        	
        	if(post_type=="image_post")
        	{
        		$("#video_block").hide();
        		$("#image_block").show();
        		$('.post_type').removeClass("active");
        		$('#submit_post').attr("submit_type","image_submit");
        		$('#submit_post_hidden').val("image_submit");
                $("#image_url").blur();
                $("#video_edit_block").addClass("d_none");
        	}
        	else if(post_type=="video_post")
        	{
        		$("#image_block").hide();
        		$("#video_block").show();
        		$('.post_type').removeClass("active");
        		$('#submit_post').attr("submit_type","video_submit");
        		$('#submit_post_hidden').val("video_submit");
                $("#video_url").blur();
                $("#image_edit_block").addClass("d_none");
        	}
        	$(this).addClass("active");
        });


	    function htmlspecialchars(str) {
	    	 if (typeof(str) == "string") {
	    	  str = str.replace(/&/g, "&amp;"); /* must do &amp; first */
	    	  str = str.replace(/"/g, "&quot;");
	    	  str = str.replace(/'/g, "&#039;");
	    	  str = str.replace(/</g, "&lt;");
	    	  str = str.replace(/>/g, "&gt;");
	    	  }
	    	 return str;
	    }
	});
});