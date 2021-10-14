 <section class="section">
  <div class="section-header">
    <?php if(($this->session->userdata('user_type') == 'Admin' || in_array(296,$this->module_access)) && $this->config->item('instagram_reply_enable_disable') == '1') : ?>
      <h1><i class="fas fa-share-square"></i> <?php echo $this->lang->line("Facebook/Instagram Poster"); ?></h1>
      <?php else : ?>
      <h1><i class="fas fa-share-square"></i> <?php echo $page_title; ?></h1>
    <?php endif; ?>
    <div class="section-header-button">
     <a class="btn btn-primary" href="<?php echo base_url('social_accounts/index'); ?>">
        <i class="fa fa-cloud-download-alt"></i> <?php echo $this->lang->line("Import Facebook Accounts"); ?></a> 
    </div>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><?php echo $page_title; ?></div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">

      <?php if($this->session->userdata('user_type') == 'Admin' || in_array(223,$this->module_access)) : ?>
        <div class="col-lg-4">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fas fa-paper-plane"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("Multimedia Post"); ?></h4>
              <p><?php echo $this->lang->line("Text, Link, Image, Video"); ?></p>
              <a href="<?php echo base_url("ultrapost/text_image_link_video"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>
      <?php endif; ?>


      <?php if($this->session->userdata('user_type') == 'Admin' || in_array(220,$this->module_access)) : ?>
        <div class="col-lg-4">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fas fa-hand-point-up"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("CTA Post"); ?></h4>
              <p><?php echo $this->lang->line("Call to Action"); ?></p>
              <a href="<?php echo base_url("ultrapost/cta_post"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>
      <?php endif; ?>

      
      <?php if($this->session->userdata('user_type') == 'Admin' || in_array(222,$this->module_access)) : ?>
        <div class="col-lg-4">
          <div class="card card-large-icons">
            <div class="card-icon text-primary">
              <i class="fas fa-video"></i>
            </div>
            <div class="card-body">
              <h4><?php echo $this->lang->line("Carousel/Video Post"); ?></h4>
              <p><?php echo $this->lang->line("Carousel, Slideshow"); ?></p>
              <a href="<?php echo base_url("ultrapost/carousel_slider_post"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </div>
      <?php endif; ?>


    </div>

    <div class="row">
      <?php if($this->basic->is_exist("add_ons",array("project_id"=>41))) : ?>
        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(252,$this->module_access)) : ?>
        <div class="col-lg-6">
            <div class="card card-large-icons">
              <div class="card-icon text-primary">
                <i class="fas fa-tv"></i>
              </div>
              <div class="card-body">
                <h4><?php echo $this->lang->line("Facebook Livestreaming"); ?></h4>
                <p><?php echo $this->lang->line("Go live with pre-recorded video"); ?></p>
                <a href="<?php echo base_url("vidcasterlive/live_scheduler_list"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <?php if($this->session->userdata('user_type') == 'Admin' || in_array(296,$this->module_access)) : ?>
      <?php if($this->config->item('instagram_reply_enable_disable') == '1') : ?>
        <div class="col-lg-6">
            <div class="card card-large-icons">
              <div class="card-icon text-primary">
                <i class="fab fa-instagram"></i>
              </div>
              <div class="card-body">
                <h4><?php echo $this->lang->line("Instagram Posts"); ?></h4>
                <p><?php echo $this->lang->line("Post on Instagram account..."); ?></p>
                <a href="<?php echo base_url("instagram_poster"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
      <?php endif; ?>
      <?php endif; ?>
    </div>

  </div>
</section><br><br>



<?php if($this->session->userdata('user_type') == 'Admin' || in_array(100,$this->module_access)) : ?>
  <section class="section">
    <div class="section-header">
      <h1><i class="fa fa-tasks"></i> <?php echo $this->lang->line("Comboposter"); ?></h1>
      <div class="section-header-button">
       <a class="btn btn-primary" href="<?php echo base_url('comboposter/social_accounts'); ?>">
          <i class="fa fa-cloud-download-alt"></i> <?php echo $this->lang->line("Import Social Accounts"); ?></a> 
      </div>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><?php echo $this->lang->line("Comboposter"); ?></div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">

        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(110,$this->module_access)) : ?>
          <div class="col-lg-4">
            <div class="card card-large-icons">
              <div class="card-icon text-primary">
                <i class="fa fa-file-text fa-4x"></i>
              </div>
              <div class="card-body">
                <h4><?php echo $this->lang->line("Text Post"); ?></h4>
                <!-- <p><?php echo $this->lang->line("Text Poster"); ?></p> -->
                <a href="<?php echo base_url("comboposter/text_post/campaigns"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
        <?php endif; ?>


        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(111,$this->module_access)) : ?>
          <div class="col-lg-4">
            <div class="card card-large-icons">
              <div class="card-icon text-primary">
                <i class="fa fa-picture-o fa-4x"></i>
              </div>
              <div class="card-body">
                <h4><?php echo $this->lang->line("Image Post"); ?></h4>
                <!-- <p><?php echo $this->lang->line("Image Poster"); ?></p> -->
                <a href="<?php echo base_url("comboposter/image_post/campaigns"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
        <?php endif; ?>

        
        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(112,$this->module_access)) : ?>
          <div class="col-lg-4">
            <div class="card card-large-icons">
              <div class="card-icon text-primary">
                <i class="fas fa-video fa-4x"></i>
              </div>
              <div class="card-body">
                <h4><?php echo $this->lang->line("Video Post"); ?></h4>
                <!-- <p><?php echo $this->lang->line("Video Poster"); ?></p> -->
                <a href="<?php echo base_url("comboposter/video_post/campaigns"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
        <?php endif; ?>


        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(113,$this->module_access)) : ?>
          <div class="col-lg-4">
            <div class="card card-large-icons">
              <div class="card-icon text-primary">
                <i class="fa fa-link fa-4x"></i>
              </div>
              <div class="card-body">
                <h4><?php echo $this->lang->line("Link Post"); ?></h4>
                <!-- <p><?php echo $this->lang->line("Link Poster"); ?></p> -->
                <a href="<?php echo base_url("comboposter/link_post/campaigns"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
        <?php endif; ?>


        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(114,$this->module_access)) : ?>
          <div class="col-lg-4">
            <div class="card card-large-icons">
              <div class="card-icon text-primary">
                <i class="fa fa-html5 fa-4x"></i>
              </div>
              <div class="card-body">
                <h4><?php echo $this->lang->line("HTML Post"); ?></h4>
                <!-- <p><?php echo $this->lang->line("HTML Poster"); ?></p> -->
                <a href="<?php echo base_url("comboposter/html_post/campaigns"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
        <?php endif; ?>



        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(256,$this->module_access)) : ?>
          <div class="col-lg-4">
            <div class="card card-large-icons">
              <div class="card-icon text-primary">
                <i class="fas fa-sync-alt"></i>
              </div>
              <div class="card-body">
                <h4><?php echo $this->lang->line("Auto Post"); ?></h4>
                <!-- <p><?php echo $this->lang->line("WP, YT auto post..."); ?></p> -->
                
                <div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="no_hover" style="font-weight: 500;"><?php echo $this->lang->line("Actions"); ?> <i class="fas fa-chevron-right"></i></a>
                    <div class="dropdown-menu">
                        <div class="dropdown-title">
                            <?php echo $this->lang->line("Tools"); ?>
                        </div>

                        <a class="dropdown-item has-icon" href="<?php echo base_url('autoposting/settings'); ?>">
                            <i class="fas fa-rss"></i>
                            <?php echo $this->lang->line("RSS feed post"); ?>        
                        </a>
                        <?php if($this->basic->is_exist("add_ons",array("unique_name"=>"auto_feed_post"))) : ?>
                        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(269, $this->module_access)) : ?>
                                <a class="dropdown-item has-icon" href="<?php echo base_url('auto_feed_post/wordpress_settings'); ?>"><i class="fab fa-wordpress"></i> <?php echo $this->lang->line("WP feed post"); ?></a>
                        <?php endif; ?>

                        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(276, $this->module_access)) : ?>
                                <a class="dropdown-item has-icon" href="<?php echo base_url('auto_feed_post/youtube_settings'); ?>"><i class="fab fa-youtube"></i> <?php echo $this->lang->line("YouTube video post"); ?></a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

              </div>
            </div>
          </div>
        <?php endif; ?>

        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(223,$this->module_access)) : ?>
            <div class="col-lg-4">
                <div class="card card-large-icons">
                    <div class="card-icon text-primary">
                        <i class="fas fa-bars" aria-hidden="true"></i>
                    </div>

                    <div class="card-body">
                        <h4><?php echo $this->lang->line("Bulk Post Planner"); ?></h4>
                        <p><?php echo $this->lang->line("Upload Text, Image, Link posts via CSV file"); ?></p>
                        <a href="<?php echo base_url("post_planner"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>        


      </div>
    </div>
  </section>
<?php endif; ?>