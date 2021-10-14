$(function() {
    "use strict";
	$("document").ready(function()	{

		var makeScheduleValEmptyifscheduleisNow = $("input[name=schedule_type]:checked").val();
		if(makeScheduleValEmptyifscheduleisNow == 'now') $("#schedule_time").val("");

        $("#video_block,.schedule_block_item,.preview_video_block,.preview_img_block").hide();       

        $(document).on('change','input[name=schedule_type]',function(){

        	var scheduleType = $("input[name=schedule_type]:checked").val();

        	if(typeof(scheduleType) =="undefined")
        		$(".schedule_block_item").show();
        	else
        	{
        		$("#schedule_time").val("");
        		$("#time_zone").val("");
        		$("#repeat_times").val("");
        		$("#time_interval").val("");
        		$(".schedule_block_item").hide();
        	}
        });                        


	    $(document).on('click','#submit_post',function(){

        	var post_type=$(this).attr("submit_type");

        	if(post_type=="image_submit")
        	{
        		if($("#image_url").val()=="")
        		{
        			swal(global_lang_warning, instragram_post_warning_upload_image, 'warning');
        			return;
        		}
        	}

        	else if(post_type=="video_submit")
        	{
        		if($("#video_url").val()=="")
        		{
        			swal(global_lang_warning, instragram_post_warning_upload_video, 'warning');
        			return;
        		}
        	}


        	var post_to_profile = $("input[name=post_to_profile]:checked").val();
        	var post_to_pages = $("#post_to_pages").val();

        	if((post_to_pages=='' || typeof(post_to_pages) =='undefined'))
        	{
        		swal(global_lang_warning, instragram_post_warning_select_account, 'warning');
        		return;
        	}

        	var schedule_type = $("input[name=schedule_type]:checked").val();
        	var schedule_time = $("#schedule_time").val();
        	var time_zone = $("#time_zone").val();

        	if(typeof(schedule_type)=='undefined' && (schedule_time=="" || time_zone==""))
        	{
        		swal(global_lang_warning, instragram_post_warning_schedule_timezone, 'warning');
        		return;
        	}

        	$(this).addClass('btn-progress')
        	var that = $(this);

		      var queryString = new FormData($("#auto_poster_form")[0]);
		      $.ajax({
		       type:'POST' ,
		       url: base_url+"instagram_poster/image_video_add_auto_post_action",
		       data: queryString,
		       dataType : 'JSON',
		       cache: false,
		       contentType: false,
		       processData: false,
		       success:function(response)
		       {
		       		$(that).removeClass('btn-progress');

		         	var report_link="<a href='"+base_url+"instagram_poster/image_video'> "+instragram_post_message_see_report+"</a>";

		         	if(response.status=="1")
			        {
			        	var span = document.createElement("span");
			        	span.innerHTML = report_link;
			        	swal({ title:response.message, content:span,icon:'success'}).then((value) => {window.location.replace(base_url+"instagram_poster")});
			        }
			        else
			        {
			        	var span = document.createElement("span");
			        	span.innerHTML = report_link;
			        	swal({ title:response.message, content:span,icon:'error'});
			        }

		       }

		      });

        });


    });
});