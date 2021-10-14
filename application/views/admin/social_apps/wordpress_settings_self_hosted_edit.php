<?php 

$module_path = APPPATH . 'modules/';
$post_view_path = $module_path . '/comboposter/views/posts/';
$social_accounts_view_path = $module_path . 'comboposter/views/posts/social_accounts/';

if (file_exists($post_view_path)) {
	include $post_view_path . 'universal_css.php';
}

?>
<style>
	.blue{
		color: #2C9BB3 !important;
	}
</style>

<section class="section">
	<div class="section-header">
		<h1><i class="fab fa-wordpress"></i> <?php echo $page_title; ?></h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item"><?php echo $this->lang->line("System"); ?></div>
			<div class="breadcrumb-item"><a href="<?php echo base_url('social_apps/settings'); ?>"><?php echo $this->lang->line("Social Apps"); ?></a></div>
			<div class="breadcrumb-item"><?php echo $page_title; ?></div>
		</div>
	</div>
	
	<div class="section-body">
		
		<?php if ($this->is_wp_social_sharing_exist) : ?>
			<div class="row">
				<div class="col-12">
		            <div class="card">
		              <div class="card-body">
		                  <b>Webhook URL</b> : <span class="blue"><?php echo base_url('wp_social_sharing/webhook'); ?></span><br>
		              </div>
		            </div>
	        	</div>
			</div>
		<?php endif; ?>

		<form method="post">
			<input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

			<div class="row">
				<div class="col-12">

					<?php if ($this->session->userdata('edit_wssh_error')): ?>
					<div class="alert alert-warning alert-dismissible show fade">
						<div class="alert-body">
							<button class="close" data-dismiss="alert">
								<span>×</span>
							</button>
							<?php echo $this->session->userdata('edit_wssh_error'); ?>
							<?php echo $this->session->unset_userdata('edit_wssh_error'); ?>
						</div>
					</div>
					<?php endif; ?>

					<!-- starts card -->
					<div class="card">

						<div class="card-header">
							<h4 class="card-title"><i class="fas fa-info-circle"></i> <?php echo $this->lang->line("App Details"); ?></h4>
						</div>

						<div class="card-body">              
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="campaign_name"><i class="fas fa-file-signature"></i> <?php echo $this->lang->line("Campaign name");?></label>
										<input id="campaign_name" name="campaign_name" value="<?php echo set_value('campaign_name', $wp_settings['campaign_name']); ?>" class="form-control" type="text">  
										<span class="red"><?php echo form_error('campaign_name'); ?></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="domain_name"><i class="fas fa-globe-americas"></i> <?php echo $this->lang->line("Wordpress blog URL");?></label>
										<span data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('Provide your wordpress blog URL.'); ?>"><i class="fas fa-info-circle"></i></span>
										<input id="domain_name" name="domain_name" value="<?php echo set_value('domain_name', $wp_settings['domain_name']); ?>" class="form-control" type="text">  
										<span class="red"><?php echo form_error('domain_name'); ?></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="user_key"><i class="fas fa-file-signature"></i> <?php echo $this->lang->line("User Key");?></label>
										<span data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('User Key can be achieved from the Wordpress Self-hosted Authentication section of the Wordpress > Users > Your Profile page.'); ?>"><i class="fas fa-info-circle"></i></span>
										<input id="user_key" name="user_key" value="<?php echo set_value('user_key', $wp_settings['user_key']); ?>" class="form-control" type="text">  
										<span class="red"><?php echo form_error('user_key'); ?></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="authentication_key"><i class="far fa-id-card"></i> <?php echo $this->lang->line("Authentication Key");?></label>
										<span data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('Authentication Key needs to be put on the Wordpress Self-hosted Authentication section of the Wordpress > Users > Your Profile page.'); ?>"><i class="fas fa-info-circle"></i></span>
										<input id="authentication_key" name="authentication_key" value="<?php echo set_value('authentication_key', $wp_settings['authentication_key']); ?>" class="form-control" type="text">  
										<span class="red"><?php echo form_error('authentication_key'); ?></span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="custom-switch mt-2">
									<input type="checkbox" name="status" value="1" class="custom-switch-input" <?php echo ('1' == $wp_settings['status']) ? 'checked' : ''; ?>>
									<span class="custom-switch-indicator"></span>
									<span class="custom-switch-description"><?php echo $this->lang->line('Active');?></span>
									<span class="red"><?php echo form_error('status'); ?></span>
								</label>
							</div>
						</div>

					</div>
					<!-- ends card -->

				</div>	
				<!-- ends col-12 -->
			</div>
			<!-- ends row -->

			<?php if ($this->is_wp_social_sharing_exist) : ?>
				<div class="row">
					<div class="col-12">

						<!-- starts card -->
						<div class="card">

							<div class="card-header">
								<h4 class="card-title"><i class="fas fa-info-circle"></i> <?php echo $this->lang->line("Social media settings"); ?></h4>
							</div>

							<div class="card-body">
								<div class="row">
									<?php if (is_dir($social_accounts_view_path)): ?>

										<?php 
											$facebook = $social_accounts_view_path . 'facebook.php';
											if (file_exists($facebook)): 
										?>	
											<div class="col-12 col-lg-12">
												<?php include $facebook; ?>
											</div>
										<?php endif; ?>

										<?php 
											$twitter = $social_accounts_view_path . 'twitter.php';
											if(($this->session->userdata('user_type') == 'Admin' 
												|| in_array(102,$this->module_access))
												&& file_exists($twitter)): 
										?>
											<!-- twitter -->
						                    <div class="col-12 col-lg-6">
						                      <?php include $twitter; ?>
						                    </div>
										<?php endif; ?>

										<?php
											$linkedin = $social_accounts_view_path . 'linkedin.php'; 
											if(($this->session->userdata('user_type') == 'Admin' 
												|| in_array(103,$this->module_access)) 
											&& file_exists($linkedin)): 
										?>
						                    <div class="col-12 col-lg-6">
						                      <?php include $linkedin; ?>
						                    </div>
										<?php endif; ?>

										<?php 
											$pinterest = $social_accounts_view_path . 'pinterest.php';
											if(($this->session->userdata('user_type') == 'Admin' 
												|| in_array(104,$this->module_access)) 
												&& file_exists($pinterest)):
										?>
						                    <div class="col-12 col-lg-12">
						                      <?php  include $pinterest; ?>
						                    </div>
										<?php endif; ?>

										<?php 
											$reddit = $social_accounts_view_path . 'reddit.php';
											if(($this->session->userdata('user_type') == 'Admin' 
												|| in_array(105,$this->module_access)) 
												&& file_exists($reddit)): 
										?>
						                    
						                    <div class="col-12 col-lg-12">
						                      <?php include $reddit; ?>
						                    </div>
										<?php endif; ?>
									<?php endif; ?>	
								</div>
								<!-- row -->
							</div>
						</div>
						<!-- ends card -->
					</div>
					<!-- ends col-12 -->
				</div>
				<!-- ends row -->
			<?php endif; ?>

			<div class="card-footer bg-whitesmoke">
				<button class="btn btn-primary btn-lg" id="save-btn" type="submit"><i class="fas fa-save"></i> <?php echo $this->lang->line("Update");?></button>
				<button class="btn btn-secondary btn-lg float-right" onclick='goBack("social_apps/index")' type="button"><i class="fa fa-remove"></i>  <?php echo $this->lang->line("Cancel");?></button>
			</div>
		</form>	
	</div>
	<!-- ends section-body -->
</section>

<?php

if (file_exists($post_view_path)) {
	include $post_view_path . 'universal_js.php';
}

?>