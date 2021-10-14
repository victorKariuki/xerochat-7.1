<div class="col-12 col-md-5 col-lg-4 colrig">
	<div class="card main_card">
		<div class="card-header pb-0 px-2">
			<h4><i class="fas fa-eye"></i> <?php echo $this->lang->line("Preview"); ?></h4>
		</div>
      	<div class="card-body p-0 padding_top_18">
          	<?php $profile_picture=(isset($account_list[0]['page_profile']) && $account_list[0]['page_profile']!="")?$account_list[0]['page_profile']:base_url('assets/img/avatar/avatar-1.png'); ?>
			<ul class="list-unstyled list-unstyled-border mb-0 px-2 mb-2">
				<li class="media">
				  <img class="mr-3 rounded-circle" width="30" src="<?php echo $profile_picture;?>" alt="avatar">
				  <div class="media-body">
				    <h6 class="media-title mt-1"><a href="#"><?php echo isset($account_list[0]['insta_username'])?$account_list[0]['insta_username']:"Username";?></a></h6>
				  </div>
				</li>
			</ul>

          	<span class="preview_message d_none"><br/></span>

          	<div class="preview_video_block d_none">
      			<video controls="" width="100%" height="290"><source  src=""></source></video>
      			<br/>
          		<div class="video_preview_og_info_desc inline-block">
          		</div>
          	</div>			          	

          	<div class="preview_only_img_block">
          		<img src="<?php echo base_url('assets/img/example-image.jpg');?>" class="only_preview_img border" alt="No Image Preview">
          	</div>
          	<img src="<?php echo base_url('assets/img/post_button.png');?>" class="img-fluid">
      	</div>          
    </div>
</div>
