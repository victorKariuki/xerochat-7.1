<div class="col-12 col-md-4 col-lg-3 collef">
	<div class="card main_card">
		<div class="card-header pb-0 px-2">
			<h4 class="w-100 m-0 pr-0">
				<i class="fas fa-image"></i> <?php echo $this->lang->line("Media"); ?>
				<a href="#" class="video_format_info badge badge-danger font_size_9px font-weight-normal py-1 px-2 float-right no_radius mt-2"><i class='fa fa-warning'></i> <?php echo $this->lang->line('Restrictions');?></a>
			</h4>
		</div>
		<div class="card-body p-2">

			<div id="image_block">
				<div class="form-group mb-1">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <?php echo $this->lang->line('URL');?>		                            
                      </div>
                    </div>
                    <input class="form-control" name="image_url" id="image_url" type="text" value="<?php if(set_value('image_url')) echo set_value('image_url');else {if(isset($all_data[0]['image_url'])) echo $all_data[0]['image_url'];}?>">
                  </div>
                </div>
				<div class="form-group mb-1">
                    <div id="image_url_upload"><?php echo $this->lang->line('Upload');?></div>
				</div>
				<div class="card mr-1 mb-0 no_shadow d_none" id="image_edit_block">
	              <div class="card-footer px-2 py-2 bg-primary no_radius">
	                <a href="#" data-src="" class="btn btn-light btn-sm float-left edit_media image no_radius"><i class="fas fa-images"></i> <?php echo $this->lang->line("Editor");?></a>
	                <a href="#" data-src="" class="btn btn-danger btn-sm float-right delete_media image no_radius"><i class="fas fa-trash-alt"></i> <?php echo $this->lang->line("Delete");?></a>
	              </div>
	            </div>
				<div class="col-12">
					<div class="row upload_block"> 
						 <?php
						 $i=0;
						 if(set_value('image_url')) $current_media = set_value('image_url');
                         else if(isset($all_data[0]['image_url'])) $current_media = $all_data[0]['image_url'];
                         else $current_media = "";
						 foreach ($files as $key => $value)
						 {
						 	$src_exp = explode('upload_caster', $value["file"]);
						 	$src = isset($src_exp[1]) ? $src_exp[1] : '';
						 	$src = base_url("upload_caster".$src);
						 	$rest = strtolower(substr($src, -4));
						 	if($rest!='.jpg' && $rest!='jpeg') continue;
						 	$active  = $current_media==$src ? 'active' : '';
						 	echo '
						 	<div class="col-4 col-md-4 col-lg-4 p-0 no-gutters">
						 		<img src="'.$src.'" width="100%" height="90px" class="pr-1 pb-1 select_media image pointer'.$active.'">
						 	</div>';
						 	$i++;
						 	if($i==21) break;
						 }
						 ?>
					</div>
				</div>
			</div>

			<div id="video_block">
				<div class="row">
					<div class="col-12">
						<div class="form-group mb-1">
	                      <div class="input-group">
	                        <div class="input-group-prepend">
	                          <div class="input-group-text">
	                            <?php echo $this->lang->line('URL');?>				                            
	                          </div>
	                        </div>
	                        <input class="form-control" name="video_url" id="video_url" type="text" value="<?php if(set_value('video_url')) echo set_value('video_url');else {if(isset($all_data[0]['video_url'])) echo $all_data[0]['video_url'];}?>">
	                      </div>
	                    </div>
						<div class="form-group mb-1">
                            <div id="video_url_upload"><?php echo $this->lang->line('Upload');?></div>
                        </div>           			

                        <div class="card mr-1 mb-0 no_shadow d_none" id="video_edit_block">
                          <div class="card-footer px-2 py-2 bg-primary no_radius">
                          	 <a href="#" data-src="" class="btn btn-light btn-sm float-left edit_media video disabled no_radius"><i class="fas fa-images"></i> <?php echo $this->lang->line("Editor");?></a>
                            <a href="#" data-src="" class="btn btn-danger btn-sm float-right delete_media video no_radius"><i class="fas fa-trash-alt"></i> <?php echo $this->lang->line("Delete");?></a>
                          </div>
                        </div>

                        <div class="col-12">
                        	<div class="row upload_block"> 
                        		 <?php
                        		 $i=0;
                        		 if(set_value('video_url')) $current_media = set_value('video_url');
                        		 else if(isset($all_data[0]['video_url'])) $current_media = $all_data[0]['video_url'];
                        		 else $current_media = "";
                        		 foreach ($files as $key => $value)
                        		 {
                        		 	$src_exp = explode('upload_caster', $value["file"]);
                        		 	$src = isset($src_exp[1]) ? $src_exp[1] : '';
                        		 	$src = base_url("upload_caster".$src);
                        		 	$rest = strtolower(substr($src, -4));
                        		 	if($rest!='.mov' && $rest!='.mp4') continue;
                        		 	$active  = $current_media==$src ? 'active' : '';
                        		 	echo '
                        		 	<div class="col-4 col-md-4 col-lg-4 p-0 no-gutters">
                        		 		<video src="'.$src.'"  width="100%" height="90px" class="pr-1 pb-1 select_media video pointer'.$active.'"></video>
                        		 	</div>';
                        		 	$i++;
                        		 	if($i==12) break;
                        		 }
                        		 ?>
                        	</div>
                        </div>
					</div>
				</div>	
			</div>			
		</div>
	</div>
</div>