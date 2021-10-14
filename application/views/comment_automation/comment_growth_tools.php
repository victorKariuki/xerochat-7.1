<section class="section">
 <div class="section-header">
   <h1><i class="fas fa-chart-pie"></i> <?php echo $page_title; ?></h1>
   <div class="section-header-breadcrumb">
     <div class="breadcrumb-item"><?php echo $page_title; ?></div>
   </div>
 </div>

 <div class="section-body">
 	<div class="row">
 		<div class="col-12">
 			<div class="row">
 				<?php if($this->session->userdata("user_type")=="Admin" || count(array_intersect($this->module_access, ['80','201','202','204','206','220','222','223','251','256'])) > 0 ) : ?>
	 				<div class="col-12 col-md-6">
	 					<div class="card">
	 						<div class="card-header">
	 							<h4><i class="fab fa-facebook-square"></i> <?php echo $this->lang->line("Facebook"); ?> </h4>
	 						</div>

	 						<div class="card-body">
	 							<ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
	 								<?php if($this->session->userdata("user_type")=="Admin" || in_array(251,$this->module_access)) : ?>
	 								<li class="media">
	 									<img alt="image" class="mr-3" width="50" src="<?php echo base_url('assets/img/icon/comment.png'); ?>">
	 									<div class="media-body">
	 										<a href="<?php echo base_url('comment_automation/comment_template_manager'); ?>"><div class="media-title"><?php echo $this->lang->line('Comment Template'); ?></div></a>
	 										<div class="text-job text-muted"><?php echo $this->lang->line('Comment template management...'); ?></div>
	 									</div>
	 									<div class="media-cta">
	 										<a href="<?php echo base_url('comment_automation/comment_template_manager'); ?>" class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
	 									</div>
	 								</li>
	 								<?php endif; ?>

	 								<?php if($this->session->userdata("user_type")=="Admin" || count(array_intersect($this->module_access, ['80','220','222','223','256'])) > 0 ) : ?>
	 								<li class="media">
	 									<img alt="image" class="mr-3" width="50" src="<?php echo base_url('assets/img/icon/reply.png'); ?>">
	 									<div class="media-body">
	 										<a href="<?php echo base_url('comment_automation/template_manager'); ?>"><div class="media-title"><?php echo $this->lang->line('Reply Template'); ?></div></a>
	 										<div class="text-job text-muted"><?php echo $this->lang->line('Reply template management...'); ?></div>
	 									</div>
	 									<div class="media-cta">
	 										<a href="<?php echo base_url('comment_automation/template_manager'); ?>" class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
	 									</div>
	 								</li>
	 								<?php endif; ?>


	 								<?php if($this->session->userdata("user_type")=="Admin" || count(array_intersect($this->module_access, ['80','204','206','251'])) > 0 ) : ?>
	 								<li class="media">
	 									<img alt="image" class="mr-3" width="50" src="<?php echo base_url('assets/img/icon/page.png'); ?>">
	 									<div class="media-body">
	 										<a href="<?php echo base_url('comment_automation/index'); ?>"><div class="media-title"><?php echo $this->lang->line('Automation Campaign'); ?></div></a>
	 										<div class="text-job text-muted"><?php echo $this->lang->line('Campaign Automation management...'); ?></div>
	 									</div>
	 									<div class="media-cta">
	 										<a href="<?php echo base_url('comment_automation/index'); ?>" class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
	 									</div>
	 								</li>
	 								<?php endif; ?>
	 								

	 								<?php 
	 									if($this->basic->is_exist("add_ons",array("project_id"=>29))) :
	 									if($this->session->userdata("user_type")=="Admin" || count(array_intersect($this->module_access, ['201','202'])) > 0 ) : 
	 								?>
	 								<li class="media">
	 									<img alt="image" class="mr-3" width="50" src="<?php echo base_url('assets/img/icon/single_tag.png'); ?>">
	 									<div class="media-body">
	 										<a href="<?php echo base_url('comment_reply_enhancers/post_list'); ?>"><div class="media-title"><?php echo $this->lang->line('Tag Campaign'); ?></div></a>
	 										<div class="text-job text-muted"><?php echo $this->lang->line('Tag campaign management...'); ?></div>
	 									</div>
	 									<div class="media-cta">
	 										<a href="<?php echo base_url('comment_reply_enhancers/post_list'); ?>" class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
	 									</div>
	 								</li>
	 								<?php 
	 									endif;
	 									endif; 
	 								?>

	 								<?php if($this->session->userdata("user_type")=="Admin" || count(array_intersect($this->module_access, ['80','201','202','204','206'])) > 0 ) : ?>
	 								<li class="media">
	 									<img alt="image" class="mr-3" width="50" src="<?php echo base_url('assets/img/icon/clock.png'); ?>">
	 									<div class="media-body">
	 										<a href="<?php echo base_url('comment_automation/comment_section_report'); ?>"><div class="media-title"><?php echo $this->lang->line('Report'); ?></div></a>
	 										<div class="text-job text-muted"><?php echo $this->lang->line('All campaign reports...'); ?></div>
	 									</div>
	 									<div class="media-cta">
	 										<a href="<?php echo base_url('comment_automation/comment_section_report'); ?>" class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
	 									</div>
	 								</li>
	 								<?php endif; ?>
	 							</ul>
	 						</div>
	 					</div>
	 				</div>
 				<?php endif; ?>
 				
 				<?php if($this->session->userdata("user_type")=="Admin" || count(array_intersect($this->module_access, ['278','279'])) > 0 ) : ?>
 				<?php if($this->config->item('instagram_reply_enable_disable') == '1') : ?>
	 				<div class="col-12 col-md-6">
	 					<div class="card">
	 						<div class="card-header">
	 							<h4><i class="fab fa-instagram"></i> <?php echo $this->lang->line("Instagram"); ?> </h4>
	 						</div>

	 						<div class="card-body">
	 							<ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
	 								<li class="media">
	 									<img alt="image" class="mr-3" width="50" src="<?php echo base_url('assets/img/icon/comment.png'); ?>">
	 									<div class="media-body">
	 										<a href="<?php echo base_url('comment_automation/comment_template_manager'); ?>"><div class="media-title"><?php echo $this->lang->line('Comment Template'); ?></div></a>
	 										<div class="text-job text-muted"><?php echo $this->lang->line('Comment template management...'); ?></div>
	 									</div>
	 									<div class="media-cta">
	 										<a href="<?php echo base_url('comment_automation/comment_template_manager'); ?>" class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
	 									</div>
	 								</li>
	 								<li class="media">
	 									<img alt="image" class="mr-3" width="50" src="<?php echo base_url('assets/img/icon/reply.png'); ?>">
	 									<div class="media-body">
	 										<a href="<?php echo base_url('instagram_reply/template_manager'); ?>"><div class="media-title"><?php echo $this->lang->line('Reply Template'); ?></div></a>
	 										<div class="text-job text-muted"><?php echo $this->lang->line('Reply template management...'); ?></div>
	 									</div>
	 									<div class="media-cta">
	 										<a href="<?php echo base_url('instagram_reply/template_manager'); ?>" class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
	 									</div>
	 								</li>
	 								<li class="media">
	 									<img alt="image" class="mr-3" width="50" src="<?php echo base_url('assets/img/icon/page.png'); ?>">
	 									<div class="media-body">
	 										<a href="<?php echo base_url('instagram_reply/get_account_lists'); ?>"><div class="media-title"><?php echo $this->lang->line('Automation Campaign'); ?></div></a>
	 										<div class="text-job text-muted"><?php echo $this->lang->line('Campaign Automation management...'); ?></div>
	 									</div>
	 									<div class="media-cta">
	 										<a href="<?php echo base_url('instagram_reply/get_account_lists'); ?>" class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
	 									</div>
	 								</li>
	 								<li class="media">
	 									<img alt="image" class="mr-3" width="50" src="<?php echo base_url('assets/img/icon/clock.png'); ?>">
	 									<div class="media-body">
	 										<a href="<?php echo base_url('instagram_reply/reports'); ?>"><div class="media-title"><?php echo $this->lang->line('Report'); ?></div></a>
	 										<div class="text-job text-muted"><?php echo $this->lang->line('All campaign reports...'); ?></div>
	 									</div>
	 									<div class="media-cta">
	 										<a href="<?php echo base_url('instagram_reply/reports'); ?>" class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
	 									</div>
	 								</li>
	 							</ul>
	 						</div>
	 					</div>
	 				</div>
 				<?php endif; ?>
 				<?php endif; ?>
 			</div>
 		</div>
 	</div>
 </div>
</section>