<section class="section">
 <div class="section-header">
   <h1><i class="fas fa-chart-pie"></i> <?php echo $page_title; ?></h1>
   <div class="section-header-breadcrumb">
   	<div class="breadcrumb-item"><a href="<?php echo base_url('comment_automation/comment_growth_tools'); ?>"><?php echo $this->lang->line("Comment Growth Tools"); ?></a></div>
     <div class="breadcrumb-item"><?php echo $this->lang->line("Instagram Reply");?></div>
     <div class="breadcrumb-item"><?php echo $page_title; ?></div>
   </div>
 </div>

 <div class="section-body">
 	<div class="row">
 		<?php if($this->session->userdata('user_type') == 'Admin' || in_array(251,$this->module_access)) : ?>
 		<div class="col-lg-6">
 		  <div class="card card-large-icons">
 		    <div class="card-icon text-primary">
 		      <i class="far fa-comment-dots"></i>
 		    </div>
 		    <div class="card-body">
 		      <h4><?php echo $this->lang->line("Auto Comment Report"); ?></h4>
 		      <p><?php echo $this->lang->line("Report of auto comment on instagram accounts's post."); ?></p>
 		      <a href="<?php echo base_url("comment_automation/all_auto_comment_report/0/0/1"); ?>" class="card-cta"><?php echo $this->lang->line("See Report"); ?> <i class="fas fa-chevron-right"></i></a>
 		    </div>
 		  </div>
 		</div>
 		<?php endif; ?>
 		<div class="col-lg-6">
 		  <div class="card card-large-icons">
 		    <div class="card-icon text-primary">
 		      <i class="fas fa-reply"></i>
 		    </div>
 		    <div class="card-body">
 		      <h4><?php echo $this->lang->line("Auto Comment Reply Report"); ?></h4>
 		      <p><?php echo $this->lang->line("Report of auto comment reply on instagram accounts's post."); ?></p>
 		      <a href="<?php echo base_url("instagram_reply/instagram_autoreply_report/post"); ?>" class="card-cta"><?php echo $this->lang->line("See Report"); ?> <i class="fas fa-chevron-right"></i></a>
 		    </div>
 		  </div>
 		</div>
 		<?php if($instagram_reply_enhancers_access == 1) : ?>
 		<div class="col-lg-6">
 		  <div class="card card-large-icons">
 		    <div class="card-icon text-primary">
 		      <i class="fas fa-briefcase"></i>
 		    </div>
 		    <div class="card-body">
 		      <h4><?php echo $this->lang->line("Full Account Reply Reports"); ?></h4>
 		      <p><?php echo $this->lang->line("Report of Posts comment reply of Instagram Full Account."); ?></p>
 		      <a href="<?php echo base_url("instagram_reply/instagram_autoreply_report/full"); ?>" class="card-cta"><?php echo $this->lang->line("See Report"); ?> <i class="fas fa-chevron-right"></i></a>
 		    </div>
 		  </div>
 		</div>
 		<div class="col-lg-6">
 		  <div class="card card-large-icons">
 		    <div class="card-icon text-primary">
 		      <i class="fas fa-tags"></i>
 		    </div>
 		    <div class="card-body">
 		      <h4><?php echo $this->lang->line("Mention Reply Report"); ?></h4>
 		      <p><?php echo $this->lang->line("Report of Mention of instagram accounts's post."); ?></p>
 		      <a href="<?php echo base_url("instagram_reply/instagram_autoreply_report/mention"); ?>" class="card-cta"><?php echo $this->lang->line("See Report"); ?> <i class="fas fa-chevron-right"></i></a>
 		    </div>
 		  </div>
 		</div>
	 	<?php endif; ?>
 	</div>
 	
 </div>
</section>