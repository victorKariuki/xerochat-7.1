<section class="section">
  <div class="section-header">
    <h1><i class="fab fa-instagram"></i> <?php  echo $this->lang->line('Live Chat')." : ".$page_name; ?> </h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="<?php echo base_url('subscriber_manager'); ?>"><?php echo $this->lang->line("Subscriber Manager");?></a></div>
      <div class="breadcrumb-item"><a href="<?php echo base_url('subscriber_manager/sync_subscribers'); ?>"><?php echo $this->lang->line("Sync Subscribers"); ?></a></div>
      <div class="breadcrumb-item"><?php echo $this->lang->line('Instagram Live Chat'); ?></div>
    </div>
  </div>

  <div class="section-body">
    
    <div class="row main_row">
      <div class="col-12 col-sm-6 col-lg-3 no_padding_col">
        <div class="card card-success" style="min-height: 500px">
          <div class="card-header">
            <h4 class="w-100 pr-0">
             <span class="float-left pr-2"> <?php echo $this->lang->line('Subscribers'); ?></span>
              <input type="text" class="form-control float-left search_list" onkeyup="search_in_ul(this,'put_content')" placeholder="<?php echo $this->lang->line("Search...") ?>">
              <a class="btn btn-outline-primary btn-sm float-right px-2 py-0" data-toggle="tooltip" title="<?php echo $this->lang->line("Refresh") ?>" name="refresh_data" id="refresh_data" href="#" page_table_id="<?php echo $page_table_id; ?>"> <i class="fas fa-sync"></i>
              </a>
            </h4>
          </div>
          <div class="card-body p-0">
            <div class="makeScroll">
              <ul class="list-unstyled list-unstyled-border" id="put_content">              
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-6 no_padding_col">
        <div class="card chat-box card-success" style="min-height: 500px" id="mychatbox2">
           <div class="card-header">
              <h4 class="w-100 pr-0">                
                <span class="float-left pr-2"><i class="fas fa-circle text-success mr-2" title="" data-toggle="tooltip" data-original-title="Online"></i><span id="chat_with"></span></span>
                <input type="text" class="form-control float-left search_list" onkeyup="search_in_div(this,'conversation_modal_body')" autofocus="" placeholder="<?php echo $this->lang->line("Search...") ?>">
                <select name="refresh_seconds" id="refresh_interval" class="form-control d-inline float-right py-0">
                  <option value="30000"> <?php echo $this->lang->line('Refresh');?></option>
                  <!-- <option value="5000"> 5 <?php echo $this->lang->line('Sec');?></option> -->
                  <option value="10000"> 10 <?php echo $this->lang->line('Sec');?></option>
                  <option value="15000"> 15 <?php echo $this->lang->line('Sec');?></option>
                  <option value="20000"> 20 <?php echo $this->lang->line('Sec');?></option>
                  <option value="30000"> 30 <?php echo $this->lang->line('Sec');?></option>
                  <option value="60000"> 60 <?php echo $this->lang->line('Sec');?></option>
                </select>
              </h4>
              
           </div>
           <div class="card-body chat-content2" style="overflow-y: auto;" id="conversation_modal_body">              
           </div>
           <div class="card-footer chat-form">
              <form id="chat-form2">
                 <input type="text" id="reply_message" class="form-control border no_radius" placeholder="<?php echo $this->lang->line('Type a message..');?>" autofocus="">
                 <button class="btn btn-primary" id="final_reply_button">
                 <i class="far fa-paper-plane"></i>
                 </button>
              </form>
           </div>
        </div>
      </div>
      <div class="col-12 col-sm-12 col-lg-3">
        <div class="card card-primary" style="min-height: 500px">
          <div class="card-header">
            <h4 class="w-100">
              <?php echo $this->lang->line('Actions'); ?>
            </h4>
          </div>
          <div class="card-body p-0">
            <div id="subscriber_action">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  var social_media = 'ig';
  var get_post_conversation_url = 'get_post_conversation_instagram';
  var get_pages_conversation_url = 'get_pages_conversation_instagram';
  var reply_to_conversation_url = 'reply_to_conversation_instagram';
</script>


<?php include(FCPATH.'application/views/message_manager/message_dashboard_common_js.php');?>