  <?php if( (($this->session->userdata("user_type")=="Admin" || in_array(79,$this->module_access)) && strtotime(date("Y-m-d")) <= strtotime("2020-3-15")) || $this->is_broadcaster_exist || ($this->session->userdata("user_type")=="Admin" || in_array(275,$this->module_access)) ) { ?>
  <section class="section">
  <div class="section-header">
    <h1>
      <i class="fab fa-facebook-messenger"></i> 
      <?php echo $this->lang->line("Messenger Broadcasting"); ?>
     <!--  <?php if($this->is_broadcaster_exist) { ?>
        <a data-toggle="collapse" href="#collapseExample" title='<?php echo $this->lang->line("Conversation Vs Subscriber Broadcasting"); ?>' role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-info-circle"></i></a>
      <?php } ?> -->
     </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><?php echo $page_title; ?></div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <?php if(($this->session->userdata("user_type")=="Admin" || in_array(79,$this->module_access)) && strtotime(date("Y-m-d")) <= strtotime("2020-3-15")) { ?>
      <div class="col-12 col-lg-6">
        <div class="card card-large-icons">
          <div class="card-icon text-primary">
            <i class="fas fa-comments"></i>
          </div>
          <div class="card-body">
            <h4><?php echo $this->lang->line("Conversation Broadcast"); ?></h4>
            <p><?php echo $this->lang->line("Promotional text-only broadcasting to all page conversation. Needs delay between each message send."); ?></p>
            <a href="<?php echo base_url("messenger_bot_broadcast/conversation_broadcast_campaign"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if($this->is_broadcaster_exist) { ?>
      <!-- <div class="col-lg-6">
        <div class="card card-large-icons">
          <div class="card-icon text-primary">
            <i class="fas fa-paper-plane"></i>
          </div>
          <div class="card-body">
            <h4><?php echo $this->lang->line("Quick Broadcast"); ?></h4>
            <p><?php echo $this->lang->line("Non-promo structured message broadcasting in seconds. Subscription messaging permission is needed."); ?></p>
            <a href="<?php echo base_url("messenger_bot_enhancers/quick_broadcast_campaign"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </div> -->
      <?php } ?>

      <?php if($this->is_broadcaster_exist) { ?>
      <div class="col-12 col-lg-6">
        <div class="card card-large-icons">
          <div class="card-icon text-primary">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-body">
            <h4><?php echo $this->lang->line("Subscriber Broadcast"); ?></h4>
             <p><?php echo $this->lang->line("Non-promo with tag, 24H structured message broadcast to messenger bot subscribers"); ?></p>
            <a href="<?php echo base_url("messenger_bot_enhancers/subscriber_broadcast_campaign"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if($this->session->userdata("user_type")=="Admin"  || in_array(275,$this->module_access)) : ?>
      <div class="col-12 col-lg-6">
        <div class="card card-large-icons">
          <div class="card-icon text-primary">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-body">
            <h4><?php echo $this->lang->line("OTN Subscriber Broadcast"); ?> </h4>
             <p><?php echo $this->lang->line("One-Time Notification request follow-up message broadcasting."); ?></p>
            <a href="<?php echo base_url("messenger_bot_broadcast/otn_subscriber_broadcast_campaign"); ?>" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
      <?php endif; ?>


      <!-- deprecated -->
      <!-- <?php if($this->is_broadcaster_exist && ($this->session->userdata("user_type")=="Admin"  || in_array(256,$this->module_access)) ) { ?>
      <div class="col-12 col-lg-6">
        <div class="card card-large-icons">
          <div class="card-icon text-primary">
            <i class="fas fa-rss"></i>
          </div>
          <div class="card-body">
            <h4><?php echo $this->lang->line("RSS Auto Subscriber Broadcast"); ?></h4>
            <p><?php echo $this->lang->line("Broadcast new RSS feed link as generic template to messenger subscribers using subscriber broadcast."); ?></p>
            <a href="" class="card-cta"><?php echo $this->lang->line("Campaign List"); ?> <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
      <?php } ?> -->


      <?php if($this->is_broadcaster_exist) { ?>  
      <div class="col-12">
        <div class="collapse" id="collapseExample">      
          <div class="card data-card">
            <div class="card-header">
              <h4><i class="fas fa-adjust"></i> <?php echo $this->lang->line("Comparision Among Different Broadcasts"); ?></h4>
            </div>
            <div class="card-body">
             <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th><?php echo $this->lang->line("Feature"); ?></th>
                      <th><?php echo $this->lang->line("Conversation Broadcast"); ?></th>
                      <!-- <th><?php echo $this->lang->line("Quick Broadcast"); ?></th> -->
                      <th><?php echo $this->lang->line("Subscriber Broadcast"); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th><?php echo $this->lang->line("Message type"); ?></th>
                      <td><?php echo $this->lang->line("Promotional"); ?></td>
                      <!-- <td><?php echo $this->lang->line("Non-promotional"); ?></td> -->
                      <td><?php echo $this->lang->line("Promotional & Non-promotional"); ?></td>
                    </tr>
                    <tr>
                      <th><?php echo $this->lang->line("Message structure"); ?></th>
                      <td><?php echo $this->lang->line("Text only"); ?></td>
                      <!-- <td><?php echo $this->lang->line("Structured message"); ?></td> -->
                      <td><?php echo $this->lang->line("Structured message"); ?></td>
                    </tr>
                    <tr>
                      <th><?php echo $this->lang->line("Bulk send limit/campaign"); ?></th>
                      <td><?php echo $this->lang->line("Unlimited"); ?></td>
                      <!-- <td><?php echo $this->lang->line("10K"); ?></td> -->
                      <td><?php echo $this->lang->line("Unlimited"); ?></td>
                    </tr>
                    <tr>
                      <th><?php echo $this->lang->line("Sending speed"); ?></th>
                      <td><?php echo $this->lang->line("One by one with 10-25 seconds delay"); ?></td>
                      <!-- <td><?php echo $this->lang->line("Send all with one call within few seconds"); ?></td> -->
                      <td><?php echo $this->lang->line("One by one without any delay"); ?></td>
                    </tr>
                    <tr>
                      <th><?php echo $this->lang->line("Subscribe by comment private reply "); ?></th>
                      <td><?php echo $this->lang->line("Yes"); ?></td>
                      <!-- <td><?php echo $this->lang->line("No, user need to send message"); ?></td> -->
                      <td><?php echo $this->lang->line("No, user need to send message"); ?></td>
                    </tr>
                    <tr>
                      <th><?php echo $this->lang->line("Audience"); ?></th>
                      <td><?php echo $this->lang->line("All existing subscribers"); ?></td>
                      <!-- <td><?php echo $this->lang->line("All existing subscribers"); ?> <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Audience"); ?>" data-content="<?php echo $this->lang->line("The actual send, estimated reach & page subscribers may differ. This campaign is totally handled by Facebook for each send. So actual send may differ for various reason. As for example, if any subscriber did not interact with your bot for many days like 2 months or page sent private reply of comment but he never replied back, in those cases, those subscribers will not be eligible for quick broadcasting. While targeting by label it may happen that some subscribers have label in Facebook but have not been assigned label in our system, they are eligible for quick broadcasting."); ?>"><i class='fa fa-info-circle'></i> </a></td> -->
                      <td><?php echo $this->lang->line("BOT subscribers"); ?></td>
                    </tr>
                    <tr>
                      <th><?php echo $this->lang->line("Promo content allowed");?></th>
                      <td><?php echo $this->lang->line("Yes"); ?></td>
                      <!-- <td><?php echo $this->lang->line("No"); ?></td> -->
                      <td>
                        <?php echo $this->lang->line("Yes, following 24H policy"); ?>
                        <a href="#" data-placement="top" data-html='true' data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("24H"); ?>" data-content="<?php echo $this->lang->line("24H Rule : Pages are permitted to send promotional message to subscribers, those has sent message to your page in last 24 hours. The 24-hour limit is refreshed each time a person responds to a business through one of the eligible actions listed in Messenger Conversation Entry Points.");?>"><i class='fa fa-info-circle'></i> </a>                        
                        </td>
                    </tr>
                    <tr>
                      <th><?php echo $this->lang->line("Visibility in page inbox");?></th>
                      <td><?php echo $this->lang->line("Yes"); ?></td>
                      <!-- <td> 
                        <?php echo $this->lang->line("No"); ?>
                        <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Visibility in Page Inbox"); ?>" data-content="<?php echo $this->lang->line("Quick broadcast messages are only visible to the message recipient. Broadcast messages will not appear in the page inbox."); ?>"><i class='fa fa-info-circle'></i> </a>
                          
                        </td>-->
                      <td><?php echo $this->lang->line("Yes"); ?></td>
                    </tr>
                    <tr>
                      <th><?php echo $this->lang->line("Report"); ?></th>
                      <td><?php echo $this->lang->line("Report of each send"); ?></td>
                      <!-- <td><?php echo $this->lang->line("Report of total send count"); ?></td> -->
                      <td><?php echo $this->lang->line("Report of each send"); ?></td>
                    </tr>
                    <tr>
                      <th><?php echo $this->lang->line("API used"); ?></th>
                      <td><?php echo $this->lang->line("Conversation API"); ?></td>
                      <!-- <td><?php echo $this->lang->line("Messenger broadcast API"); ?></td> -->
                      <td><?php echo $this->lang->line("Messenger send API"); ?></td>
                    </tr>
                  </tbody>

                </table> 
              </div> 
            </div>
          </div>
         
        </div>
      </div>
      <?php } ?>

    </div>


  </div>
</section>
<?php } ?>


<?php 
  if($this->session->userdata('user_type') == 'Admin' || in_array(264,$this->module_access)) {  ?>
  <br>
  <section class="section">
      <div class="section-header">
          <h1><i class="fas fa-sms"></i> <?php echo $this->lang->line("SMS Broadcasting"); ?></h1>
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><?php echo $page_title; ?></div>
          </div>
      </div>

      <div class="section-body">
          <div class="row">  

            <div class="col-lg-4">
                <div class="card card-large-icons">
                    <div class="card-icon text-primary"><i class="fas fa-plug"></i></div>
                    <div class="card-body">
                        <h4><?php echo $this->lang->line("SMS API Settings"); ?></h4>
                        <p><?php echo $this->lang->line("Twilio, Plivo, Clickatell, Nexmo, AfricasTalking..."); ?></p>
                        <div class="dropdown">
                            <a class="no_hover" href="<?php echo base_url('sms_email_manager/sms_api_lists'); ?>"><?php echo $this->lang->line("Actions"); ?> <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-large-icons">
                    <div class="card-icon text-primary"><i class="fas fa-sms"></i></div>
                    <div class="card-body">
                        <h4><?php echo $this->lang->line("SMS Campaign"); ?></h4>
                        <p><?php echo $this->lang->line("Campaign list, new campaign, report..."); ?></p>
                        <div class="dropdown">
                            <a class="no_hover" href="<?php echo base_url('sms_email_manager/sms_campaign_lists'); ?>"><?php echo $this->lang->line("Actions"); ?> <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <?php 
              if($this->basic->is_exist("modules",array("id"=>270))) { 
                if($this->session->userdata('user_type') == 'Admin' || in_array(270,$this->module_access)) {  ?>
                <div class="col-lg-4">
                    <div class="card card-large-icons">
                        <div class="card-icon text-primary"><i class="fas fa-th-list"></i></div>
                        <div class="card-body">
                            <h4><?php echo $this->lang->line("SMS Template"); ?></h4>
                            <p><?php echo $this->lang->line("Templates for SMS Sequecne Message..."); ?></p>
                            <div class="dropdown">
                                <a class="no_hover" href="<?php echo base_url('sms_email_sequence/template_lists/sms'); ?>"><?php echo $this->lang->line("Actions"); ?> <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
          </div>
      </div>
  </section>
  <?php } ?>


<?php 
  if($this->session->userdata('user_type') == 'Admin' || count(array_intersect($this->module_access, array('263','271'))) !=0) {  ?>
  <br>
  <section class="section">
      <div class="section-header">
          <h1><i class="fas fa-envelope"></i> <?php echo $this->lang->line("Email Broadcasting"); ?></h1>
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><?php echo $page_title; ?></div>
          </div>
      </div>

      <div class="section-body">
          <div class="row">  

              <div class="col-lg-4">
                  <div class="card card-large-icons">
                      <div class="card-icon text-primary"><i class="fas fa-plug"></i></div>
                      <div class="card-body">
                          <h4><?php echo $this->lang->line("Email API Settings"); ?></h4>
                          <p><?php echo $this->lang->line("SMTP, Mandril, Mailgun, Sendgrid..."); ?></p>
                          <div class="dropdown">
                              <a href="#" data-toggle="dropdown" class="no_hover" style="font-weight: 500;"><?php echo $this->lang->line("Actions"); ?> <i class="fas fa-chevron-right"></i></a>
                              <div class="dropdown-menu">
                                  <div class="dropdown-title"><?php echo $this->lang->line("Tools"); ?></div>                        
                                  <a class="dropdown-item has-icon" href="<?php echo base_url('sms_email_manager/smtp_config'); ?>"><i class="fas fa-plug"></i> <?php echo $this->lang->line("SMTP API"); ?></a>
                                  <a class="dropdown-item has-icon" href="<?php echo base_url('sms_email_manager/mandrill_api_config'); ?>"><i class="fas fa-plug"></i> <?php echo $this->lang->line("Mandrill API"); ?></a>
                                  <a class="dropdown-item has-icon" href="<?php echo base_url('sms_email_manager/sendgrid_api_config'); ?>"><i class="fas fa-plug"></i> <?php echo $this->lang->line("Sendgrid API"); ?></a>
                                  <a class="dropdown-item has-icon" href="<?php echo base_url('sms_email_manager/mailgun_api_config'); ?>"><i class="fas fa-plug"></i> <?php echo $this->lang->line("Mailgun API"); ?></a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <?php if($this->session->userdata("user_type")=="Admin"  || in_array(263,$this->module_access)) : ?>
              <div class="col-lg-4">
                  <div class="card card-large-icons">
                      <div class="card-icon text-primary"><i class="fas fa-envelope"></i></div>
                      <div class="card-body">
                          <h4><?php echo $this->lang->line("Email Campaign"); ?></h4>
                          <p><?php echo $this->lang->line("Campaign list, new campaign, report..."); ?></p>
                          <div class="dropdown">
                              <a href="<?php echo base_url('sms_email_manager/email_campaign_lists'); ?>" class="no_hover"><?php echo $this->lang->line("Actions"); ?> <i class="fas fa-chevron-right"></i></a>
                          </div>
                      </div>
                  </div>
              </div>
            <?php endif; ?>
              
            <div class="col-lg-4">
                  <div class="card card-large-icons">
                      <div class="card-icon text-primary"><i class="fas fa-th-list"></i></div>
                      <div class="card-body">
                          <h4><?php echo $this->lang->line("Email Templates"); ?></h4>
                          <p><?php echo $this->lang->line("Templates for Email Sequecne Message..."); ?></p>
                          <div class="dropdown">
                              <a href="<?php echo base_url('sms_email_manager/template_lists/email'); ?>" class="no_hover"><?php echo $this->lang->line("Actions"); ?> <i class="fas fa-chevron-right"></i></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

      </div>
  </section>
  <?php } ?>


<?php 
if($this->basic->is_exist("modules",array("id"=>270)) && $this->basic->is_exist("modules",array("id"=>271))) {  
  if($this->session->userdata('user_type') == 'Admin' || count(array_intersect($this->module_access, array('270','271'))) !=0) {  ?>
  <br>
  <section class="section" id="external_sequence_block">
      <div class="section-header">
          <h1><i class="fas fa-paper-plane"></i> <?php echo $this->lang->line("SMS/Email Sequence Campaigner (External Contacts)"); ?></h1>
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><?php echo $page_title; ?></div>
          </div>
      </div>

      <div class="section-body">
          <div class="row">  
              <div class="col-lg-6">
                <div class="card card-large-icons">
                    <div class="card-icon text-primary"><i class="fas fa-envelope"></i></div>
                    <div class="card-body">
                        <h4><?php echo $this->lang->line("Sequence Campaign"); ?></h4>
                        <p><?php echo $this->lang->line("Sequence Campaing for external Contacts..."); ?></p>
                        <div class="dropdown">
                            <a href="<?php echo base_url('sms_email_sequence/external_sequence_lists'); ?>" class="no_hover"><?php echo $this->lang->line("Actions"); ?> <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
              </div>
          </div>
      </div>
  </section>
  <?php } ?>
<?php } ?>


<style type="text/css">
  .popover{min-width: 330px !important;}
  .no_hover:hover{text-decoration: none;}
  .otn_info_modal{cursor: pointer;}
  #external_sequence_block{ z-index: unset; }
</style>