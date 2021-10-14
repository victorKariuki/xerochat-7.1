<style>
	.card {box-shadow: none !important;}
	.data-div {margin-left: 45px;}
	.margin-top {margin-top: 30px;}
	.flex-column .nav-item .nav-link.active
	{
	  background: #fff !important;
	  color: #3516df !important;
	  border: 1px solid #988be1 !important;
	}

	.flex-column .nav-item .nav-link .form_id, .flex-column .nav-item .nav-link .insert_date
	{
	  color: #608683 !important;
	  font-size: 12px !important;
	  padding: 0 !important;
	  margin: 0 !important;
	}
	.waiting {height: 100%;width:100%;display: table;}
  	.waiting i{font-size:60px;display: table-cell; vertical-align: middle;padding:30px 0;}
</style>

<section class="section section_custom">
	<div class="section-header">
		<h1><i class="fab fa-wordpress"></i> <?php echo $this->lang->line("Wordpress Settings (Self-Hosted)"); ?></h1>
		<div class="section-header-button">
	     	<a class="btn btn-primary" href="<?= base_url('social_apps/add_wordpress_settings_self_hosted') ?>">
	        <i class="fas fa-plus-circle"></i> <?php echo $this->lang->line('Add New Site'); ?></a>
	    </div>

	    <div class="section-header-breadcrumb">
	      <div class="breadcrumb-item active">
	      	<?php echo $this->lang->line('System'); ?>
	      </div>
	      <div class="breadcrumb-item">
	      	<a href="<?php echo base_url('social_apps/index'); ?>"><?php echo $this->lang->line("Social Apps"); ?></a>
	      </div>
	      <div class="breadcrumb-item active"><?php echo $page_title; ?></div>
	    </div>

	</div>
	<div class="section-body">
		<div class="row">
			<div class="col-12">

				<?php if ($this->session->userdata('edit_wssh_success')): ?>
				<div class="alert alert-success alert-dismissible show fade">
					<div class="alert-body text-center">
						<button class="close" data-dismiss="alert">
							<span>×</span>
						</button>
						<?php echo $this->session->userdata('edit_wssh_success'); ?>
					</div>
				</div>
				<?php $this->session->unset_userdata('edit_wssh_success'); ?>
				<?php endif; ?>

				<div class="card">
					<div class="card-header d-flex justify-content-end">
						<a class="btn btn-primary" href="<?php echo base_url('assets/wordpress-self-hosted/wp-self-hosted-authentication.zip'); ?>"><i class="fa fa-download"></i> <?php echo $this->lang->line('Download API Plugin'); ?></a>
					</div>
					<div class="card-body data-card">
						<div class="table-responsive">
							<table id="wssh-datatable" class="table table-bordered" style="width:100%">
						        <thead>
						            <tr>
						                <th>#</th>
						                <th><?php echo $this->lang->line('Domain Name'); ?></th>
						                <th><?php echo $this->lang->line('User Key'); ?></th>
						                <th><?php echo $this->lang->line('Authentication Key'); ?></th>
						                <th><?php echo $this->lang->line('Status'); ?></th>
						                <th><?php echo $this->lang->line('Actions'); ?></th>
						            </tr>
						        </thead>
						    </table>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="settings_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-cog"></i>&nbsp;
                    <?php echo $this->lang->line("Campaign Settings") ?>&nbsp;
                    <span id="put_feed_name"></span>
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body" id="feed_setting_container">
           
	           	<!-- form starts --> 	
	            <form action="#" id="wordpress-setttings" method="post" style="width: 100%;">
					<!-- Accounts -->
					<div class="col-12">
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
					<!-- col-12 -->
					<input type="hidden" name="wp_app_id" id="wp_app_id">
				</form>
				<!-- form ends -->

            </div>

            <div class="modal-footer pl-4 pr-4">
                <button type="button" class="btn-lg btn btn-default" data-dismiss="modal" id="close_settings">
                    <i class="fas fa-times"></i>&nbsp;
                    <?php echo $this->lang->line("Close");?>
                </button>
                <button type="button" class="btn-lg btn btn-primary ml-0" id="save_settings">
                    <i class="fas fa-paper-plane"></i>&nbsp;
                    <?php echo $this->lang->line("Create Campaign");?>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function() {
		var base_url = '<?php echo base_url(); ?>';

		var wssh_table = $('#wssh-datatable').DataTable({
	      	processing: true,
	      	serverSide: true,
			order: [[ 0, "desc" ]],
			pageLength: 10,	        
	        ajax: {
	        	url: '<?= base_url('social_apps/wordpress_settings_self_hosted_data') ?>',
	        	type: 'POST',
	        	dataSrc: function (json) {
	                $(".table-responsive").niceScroll();
	                return json.data;
	            },
	        },
	        columns: [
			    {data: 'id'},
			    {data: 'domain_name'},
			    {data: 'user_key'},
			    {data: 'authentication_key'},
			    {data: 'status'},
			    {data: 'actions'}
			],
			language: {
        		url: "<?= base_url('assets/modules/datatables/language/'.$this->language.'.json'); ?>"
  			},
      		columnDefs: [
				{ 
					'sortable': false, 
					'targets': [2,3,4,5]
				},
				{
				    targets: [0,1,2,3,4,5],
				    className: 'text-center'
				}
			],
			dom: '<"top"f>rt<"bottom"lip><"clear">',
		});

		// Loads categories
		$(document).on('click', '.update-categories', function(e) {
			e.preventDefault();

			var that = this;
			var wp_app_id = $(that).data('wp-app-id');
			
			// Handles spinner
			$(that).removeClass('btn-outline-primary');
			$(that).addClass('btn-primary btn-progress');

			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				data: { wp_app_id },
				url: base_url + 'social_apps/wordpress_settings_self_hosted_load_categories',
				success: function(res) {

					// Handles spinner
					$(that).addClass('btn-outline-primary');
					$(that).removeClass('btn-primary btn-progress');

					if (false === res.status) {
						swal('<?php echo $this->lang->line("Error"); ?>', res.message, 'error');
						return;
					}

					if (true === res.status) {
						swal('<?php echo $this->lang->line("Success"); ?>', res.message, 'success');
					}
				},
			});
		});

		// Attempts to delete wordpress site's settings
		$(document).on('click', '#delete-wssh-settings', function(e) {
			e.preventDefault()

			// Grabs site ID
			var site_id = $(this).data('site-id');
			var csrf_token = $(this).attr('csrf_token');

			swal({
				title: '<?php ('Are you sure?'); ?>',
				text: '<?php echo $this->lang->line('Once deleted, you will not be able to recover this wordpress site settings!'); ?>',
				icon: 'warning',
				buttons: true,
				dangerMode: true,
			}).then((yes) => {
				if (yes) {
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url('social_apps/delete_wordpress_settings_self_hosted') ?>',
						dataType: 'JSON',
						data: { site_id:site_id,csrf_token:csrf_token },
						success: function(res) {
							
							if ('ok' == res.status) {
								swal('<?php echo $this->lang->line("Success"); ?>', res.message, 'success').then((value) => {
								    location.reload();
								});
							} 
							else swal('<?php echo $this->lang->line("Error"); ?>', res.error, 'error');
							
						
						}
					})
				} else {
					return
				}
			});
		});
	});
</script>