<link rel="stylesheet" href="<?php echo base_url('assets/css/system/instagram/instagram_comment_reply.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/system/instagram/instagram_template_manager.css');?>">
<?php 
	$this->load->view("include/upload_js");    
	$commnet_hide_delete_addon = $commnet_hide_delete_addon;
	$comment_tag_machine_addon = 1;
    if(addon_exist($module_id=320,$addon_unique_name="instagram_bot"))
        $instagram_reply_bot_addon = 1;
    else
        $instagram_reply_bot_addon = 0;

?>

<section class="section">
	<div class="section-header">
		<h1><i class="fa fa-pen-alt"></i> <?php echo $page_title;?></h1>

		<div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="<?php echo base_url('comment_automation/comment_growth_tools'); ?>"><?php echo $this->lang->line("Comment Growth Tools"); ?></a></div>
			<div class="breadcrumb-item"><?php echo $this->lang->line("Instagram Reply");?></div>
			<div class="breadcrumb-item"><?php echo $page_title;?></div>
		</div>

	  </div>
</section>


<?php if(empty($account_info))
{ ?>
	 
	<div class="card" id="nodata">
	  <div class="card-body">
	    <div class="empty-state">
	      <img class="img-fluid" src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">
	      <h2 class="mt-0"><?php echo $this->lang->line("We could not find any page.");?></h2>
	      <p class="lead"><?php echo $this->lang->line("Please import account if you have not imported yet.")."<br>".$this->lang->line("If you have already imported account then enable bot connection for one or more page to continue.") ?></p>
	      <a href="<?php echo base_url('social_accounts'); ?>" class="btn btn-outline-primary mt-4"><i class="fas fa-arrow-circle-right"></i> <?php echo $this->lang->line("Continue");?></a>
	    </div>
	  </div>
	</div>

<?php 
}
else
{ ?>
	
	<div class="row multi_layout">

		<div class="col-12 col-md-5 col-lg-3 collef">
		  <div class="card main_card">
		    <div class="card-header">
		      <div class="col-6 padding-0">
		        <h4><i class="fas fa-newspaper"></i> <?php echo $this->lang->line("Accounts"); ?></h4>
		      </div>
		      <div class="col-6 padding-0">            
		        <input type="text" class="form-control float-right" id="search_page_list" onkeyup="search_in_ul(this,'page_list_ul')" autofocus placeholder="<?php echo $this->lang->line('Search...'); ?>">
		      </div>
		    </div>
		    <div class="card-body padding-0">
		      <div class="makeScroll">
		        <ul class="list-group" id="page_list_ul">
		          <?php $i=0; foreach($account_info as $value) { ?> 
		            <li class="list-group-item <?php if($i==0) echo 'active'; ?> page_list_item" page_table_id="<?php echo $value['id']; ?>">
		              <div class="row">
		                <div class="col-3 col-md-2"><img width="45px" class="rounded-circle" src="<?php echo $value['page_profile']; ?>"></div>
		                <div class="col-9 col-md-10">
		                  <h6 class="page_name"><?php echo $value['insta_username']; ?></h6>
		                  <span class="gray"><?php echo $value['instagram_business_account_id']; ?></span>
		                  </div>
		                </div>
		            </li> 
		            <?php $i++; } ?>                
		        </ul>
		      </div>
		    </div>
		  </div>          
		</div>

		<div class="col-12 col-md-7 col-lg-4 colmid" id="middle_column">
			
		</div>

		<div class="col-12 col-md-12 col-lg-5 colrig" id="right_column">
			
	    </div>
		
	</div>

<?php } ?>


<input type="hidden" name="dynamic_page_id" id="dynamic_page_id">


<?php
	$Youdidntprovideallinformation = $this->lang->line("you didn't provide all information.");
	$Pleaseprovidepostid = $this->lang->line("please provide post id.");
	$Youdidntselectanyoption = $this->lang->line("you didn\'t select any option.");
	$AlreadyEnabled = $this->lang->line("already enabled");
	$ThispostIDisnotfoundindatabaseorthispostIDisnotassociatedwiththepageyouareworking = $this->lang->line("This post ID is not found in database or this post ID is not associated with the page you are working.");
	$EnableAutoReply = $this->lang->line("enable auto reply");
	$areyousure = $this->lang->line("are you sure");
	$disablebot = $this->lang->line("Disable reply");
	$enablebot = $this->lang->line("Enable reply");
	$restart_bot = $this->lang->line("Re-start Reply");
?>

<?php include("application/views/instagram_reply/comment_reply/comment_reply_js.php"); ?>


<div class="modal fade" id="auto_reply_message_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title padding_10_20_10_20px" ><?php echo $this->lang->line("Please give the following information for post auto reply") ?></h5>
              <button type="button" class="close" id='modal_close'  aria-label="Close">
            	<span aria-hidden="true">×</span>
              </button>
            </div>
            <form action="#" id="auto_reply_info_form" method="post">
                <input type="hidden" name="auto_reply_page_id" id="auto_reply_page_id" value="">
                <input type="hidden" name="auto_reply_post_id" id="auto_reply_post_id" value="">
                <input type="hidden" name="manual_enable" id="manual_enable" value="">
                <input type="hidden" name="create_new_template" id="create_new_template" value="">
                <div class="modal-body" id="auto_reply_message_modal_body">

                    <div class="row padding_0_20px">                  
                        <div class="col-12 col-md-6">
                            <label><i class="fa fa-th-list"></i> <?php echo $this->lang->line("do you want to use saved template?") ?>
                                <a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("message") ?>" data-content="<?php echo $this->lang->line("If you want to set campaign from previously saved template, then keep 'Yes' & select from below select option. If you want to add new settings, then select 'NO' , then auto reply settings form will come."); ?>"><i class='fa fa-info-circle'></i> </a>
                            </label>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label class="custom-switch">
                              <input type="checkbox" name="auto_template_selection" value="yes" id="template_select" class="custom-switch-input" checked>
                              <span class="custom-switch-indicator"></span>
                              <span class="custom-switch-description"><?php echo $this->lang->line('Yes');?></span>
                            </label>
                          </div>
                        </div>
                    </div>
                    <!-- comment hide and delete section -->

                    <div id="auto_reply_templates_section" class="row padding_10_20_10_20px">
                        <div class="col-12">
                            <div id="all_save_templates">
                                <div id="saved_templates">
                                    <div class="row">
                                        <div class="form-group col-12 col-md-3">
                                            <label><i class="fa fa-reply"></i> <?php echo $this->lang->line('Auto Reply Template'); ?>
                                                <a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("message") ?>" data-content="<?php echo $this->lang->line("Select any saved template of Auto Reply Campaign. If you want to modify any settings of this post campaign later, then edit this campaign & modify. Be notified that editing the saved template will not affect the campaign settings. To edit campaign, you need to edit post reply settings.") ?>"><i class='fa fa-info-circle'></i> </a>
                                            </label>
                                        </div>

                                        <div class="col-12 col-md-9">
                                            <select  class="form-control select2" id="auto_reply_template" name="auto_reply_template">
                                            <?php echo "<option value='0'>{$this->lang->line('Please select a template')}</option>"; ?>
                                            </select>
                                        </div>
                                    </div> <!-- end of row  -->
                                </div>
                            </div>
                        </div>                  
                    </div>
                    <!-- end of use saved template section -->

                    <div id="new_template_section">
                        <div class="row padding_10_20_10_20px <?php if (!$commnet_hide_delete_addon) echo 'd_none'; ?>">
                            <div class="col-12">
                                <div class="row">									
                                	<div class="col-12 col-md-6">
                                		<label><i class="fa fa-ban"></i> <?php echo $this->lang->line("what do you want about offensive comments?") ?></label>
                                	</div>
                                	<div class="col-12 col-md-6">
                                		<div class="row">
                                		  <div class="col-12 col-md-6">
                                			<label class="custom-switch">
                                			  <input type="radio" name="delete_offensive_comment" value="hide" id="delete_offensive_comment_hide" class="custom-switch-input" checked>
                                			  <span class="custom-switch-indicator"></span>
                                			  <span class="custom-switch-description"><?php echo $this->lang->line('hide'); ?></span>
                                			</label>
                                		  </div>
                                		  <div class="col-12 col-md-6">
                                			<label class="custom-switch">
                                			  <input type="radio" name="delete_offensive_comment" value="delete" id="delete_offensive_comment_delete" class="custom-switch-input">
                                			  <span class="custom-switch-indicator"></span>
                                			  <span class="custom-switch-description"><?php echo $this->lang->line('delete'); ?>
                                			</label>
                                		  </div>
                                		</div>
                                	</div>
                                </div>
                            </div>
                            <br/><br/>
                            <div class="col-12 col-md-6" id="delete_offensive_comment_keyword_div">
                                <div class="form-group e4e6fc_border_dashed">
                                    <label><i class="fa fa-tag"></i> <?php echo $this->lang->line("write down the offensive keywords in comma separated") ?>
                                        <span class="red">*</span>
                                    </label>
                                    <textarea class="form-control message height_70px" name="delete_offensive_comment_keyword" id="delete_offensive_comment_keyword" placeholder="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions") ?>"></textarea>
                                </div>
                            </div>
                            <!-- private reply section -->
                            <?php if($instagram_reply_bot_addon) : ?>
                            <div class="col-12 col-md-6">
                                <div class="form-group clearfix e4e6fc_border_dashed">
                                    <label><small>
                                        <i class="fas fa-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply after deleting offensive comment") ?></small>
                                    </label>
                                    <div>                      
                                        <select class="form-group private_reply_postback select2" id="private_message_offensive_words" name="private_message_offensive_words">
                                            <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                        </select>

                                        <a href="" class="add_template float-left"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("Add Message Template");?></a>
                                        <a href="" class="ref_template float-right"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Refresh List");?></a>

                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- end of private reply section -->
                        </div>
                        <!-- end of comment hide and delete section -->

                        <div class="row padding_10_20_10_20px">
    						
    						<div class="col-12">
    							<div class="row">									
    								<div class="col-12 col-md-6"><label><i class="fa fa-sort-numeric-down"></i> <?php echo $this->lang->line("Do you want to reply comments of a user multiple times?") ?></label></div>
    								<div class="col-12 col-md-6">
    								  <div class="form-group">
    									<label class="custom-switch">
    									  <input type="checkbox" name="multiple_reply" value="yes" id="multiple_reply" class="custom-switch-input">
    									  <span class="custom-switch-indicator"></span>
    									  <span class="custom-switch-description"><?php echo $this->lang->line('Yes');?></span>
    									</label>
    								  </div>
    								</div>
    							</div>
    						</div>

                            <div class="smallspace clearfix"></div>

                            <div class="col-12 <?php if(!$commnet_hide_delete_addon) echo 'd_none';?>"  >
                            	<div class="row">									
                            		<div class="col-12 col-md-6">
                            			<label><i class="fa fa-eye-slash"></i>  <?php echo $this->lang->line("do you want to hide comments after comment reply?") ?></label>
                            		</div>
                            		<div class="col-12 col-md-6">
                            			<div class="form-group">
                            			  <label class="custom-switch">
                            				<input type="checkbox" name="hide_comment_after_comment_reply" value="yes" id="hide_comment_after_comment_reply" class="custom-switch-input">
                            				<span class="custom-switch-indicator"></span>
                            				<span class="custom-switch-description"><?php echo $this->lang->line('Yes');?></span>
                            			  </label>
                            			</div>
                            		</div>
                            	</div>
                            </div>
                            <!-- comment hide and delete section -->

                            <br/><br/>

                            <div class="col-12">
                              <div class="custom-control custom-radio">
                            	<input type="radio" name="message_type" value="generic" id="generic" class="custom-control-input radio_button">
                            	<label class="custom-control-label" for="generic"><?php echo $this->lang->line("generic comment reply for all") ?></label>
                              </div>
                              <div class="custom-control custom-radio">
                            	<input type="radio" name="message_type" value="filter" id="filter" class="custom-control-input radio_button">
                            	<label class="custom-control-label" for="filter"><?php echo $this->lang->line("send comment reply by filtering word/sentence") ?></label>
                              </div>
                            </div>

                            <div class="col-12 margin_top_15">
                                <div class="form-group">
                                    <label><i class="fa fa-monument"></i>
                                        <?php echo $this->lang->line("auto comment reply campaign name") ?> <span class="red">*</span></a>
                                    </label>
                                    <input class="form-control" type="text" name="auto_campaign_name" id="auto_campaign_name" placeholder="<?php echo $this->lang->line("write your auto comment reply campaign name here") ?>">
                                </div>
                            </div>
                            <div class="col-12 d_none" id="generic_message_div">
                                <div class="form-group e4e6fc_border_dashed clearfix">
                                    <label>
                                        <i class="fa fa-envelope"></i> <?php echo $this->lang->line("comment reply text") ?> <span
                                                class="red">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("message") ?>" data-content="<?php echo $this->lang->line("write your message which you want to send. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i class='fa fa-info-circle'></i> </a>
                                    </label>
                                    <span class='float-right'>
    								<a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>" data-toggle="tooltip" data-placement="top" class='btn btn-default btn-sm lead_tag_name button-outline'><i class='fa fa-tags'></i> <?php echo $this->lang->line("mention user") ?></a>
    							</span>
                                <span class='float-right'>								
                                	<a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>" data-toggle="tooltip" data-placement="top" class='btn btn-default btn-sm lead_first_name button-outline'><i
                                                class='fa fa-user'></i> <?php echo $this->lang->line("Username") ?></a>
    							</span>
                                <div class="clearfix"></div>
                                <textarea class="form-control message height_170px" name="generic_message" id="generic_message" placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                <!-- private reply section -->
                                <?php if($instagram_reply_bot_addon) : ?>
                                <br><br>
                                <label>
                                  <i class="fas fa-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                </label>
                                <div>                      
                                  <select class="form-group private_reply_postback select2" id="generic_message_private" name="generic_message_private">
                                    <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                  </select>

                                  <a href="" class="add_template float-left"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("Add Message Template");?></a>
                                  <a href="" class="ref_template float-right"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Refresh List");?></a>
                                </div>
                                <?php endif; ?>
                                <!-- end of private reply section -->
                                    
                                </div>
                            </div>
                            <div class="col-12 d_none" id="filter_message_div">
                                <?php for ($i = 1; $i <= 20; $i++) : ?>
                                    <div class="form-group instagram_border_padded2 clearfix" id="filter_div_<?php echo $i; ?>">
                                       <label><i class="fa fa-tag"></i> <?php echo $this->lang->line("filter word/sentence") ?> 
                                       <span class="red">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("message") ?>" data-content="<?php echo $this->lang->line("Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when") ?>"><i class='fa fa-info-circle'></i> </a>
                                        </label>
                                        <input class="form-control filter_word" type="text" name="filter_word_<?php echo $i; ?>" id="filter_word_<?php echo $i; ?>" placeholder="<?php echo $this->lang->line("write your filter word here") ?>">
                                        <br/>
                                        <br/>
                                        <label>
                                            <i class="fa fa-envelope"></i> <?php echo $this->lang->line("comment reply text") ?>
                                            <span class="red">*</span>
                                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("message") ?>"
                                               data-content="<?php echo $this->lang->line("write your message which you want to send based on filter words. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                        class='fa fa-info-circle'></i> </a>
                                        </label>
                                        <span class='float-right'>
    										<a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>" data-toggle="tooltip" data-placement="top" class='btn btn-default btn-sm lead_tag_name button-outline'><i class='fa fa-tags'></i> <?php echo $this->lang->line("mention user") ?></a>
    									</span>
                                        <span class='float-right'>
    										<a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>" data-toggle="tooltip" data-placement="top" class='btn btn-default btn-sm lead_first_name button-outline'><i class='fa fa-user'></i> <?php echo $this->lang->line("Username") ?></a>
    									</span>
                                        <div class="clearfix"></div>
                                        <textarea class="form-control message height_170px" name="comment_reply_msg_<?php echo $i; ?>" id="comment_reply_msg_<?php echo $i; ?>" placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                        <!-- private reply section -->
                                        <?php if($instagram_reply_bot_addon) : ?>
                                        <br><br>
                                        <label>
                                          <i class="fas fa-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                        </label>
                                        <div>                      
                                          <select class="form-group private_reply_postback select2" id="filter_message_<?php echo $i; ?>" name="filter_message_<?php echo $i; ?>">
                                            <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                          </select>

                                          <a href="" class="add_template float-left"><i class="fa fa-plus-circle"></i>     <?php echo $this->lang->line("Add Message Template");?></a>
                                          <a href="" class="ref_template float-right"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Refresh List");?></a>
                                        </div>
                                        <?php endif; ?>
                                        <!-- end of private reply section -->

                                    </div>
                                <?php endfor; ?>

                                <div class="clearfix">
                                    <input type="hidden" name="content_counter" id="content_counter"/>
                                    <button type="button" class="btn btn-sm btn-outline-primary float-right" id="add_more_button"><i class="fa fa-plus"></i> <?php echo $this->lang->line("add more filtering") ?></button>
                                </div>

                                <div class="form-group instagram_border_margined_padded clearfix" id="nofilter_word_found_div">
                                    <label><i class="fa fa-envelope"></i> <?php echo $this->lang->line("comment reply if no matching found") ?>
    	                                <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("message") ?>" data-content="<?php echo $this->lang->line("Write the message,  if no filter word found. If you don't want to send message them, just keep it blank ."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i class='fa fa-info-circle'></i> </a>
                                    </label>
                                    <span class='float-right'>
    									<a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>" data-toggle="tooltip" data-placement="top" class='btn btn-default btn-sm lead_tag_name button-outline'><i class='fa fa-tags'></i> <?php echo $this->lang->line("mention user") ?></a>
    								</span>
    	                            <span class='float-right'>
    									<a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>" data-toggle="tooltip" data-placement="top" class='btn btn-default btn-sm lead_first_name button-outline'><i class='fa fa-user'></i> <?php echo $this->lang->line("Username") ?></a>
    								</span>
                                	<div class="clearfix"></div>
                                	<textarea class="form-control message height_170px" name="nofilter_word_found_text" id="nofilter_word_found_text" placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                    <!-- private reply section -->
                                    <?php if($instagram_reply_bot_addon) : ?>
                                    <br><br>
                                    <label>
                                      <i class="fas fa-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                    </label>
                                    <div>                      
                                      <select class="form-group private_reply_postback select2" id="nofilter_word_found_text_private" name="nofilter_word_found_text_private">
                                        <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                      </select>

                                      <a href="" class="add_template float-left"><i class="fa fa-plus-circle"></i>     <?php echo $this->lang->line("Add Message Template");?></a>
                                      <a href="" class="ref_template float-right"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Refresh List");?></a>
                                    </div>
                                    <?php endif; ?>
                                    <!-- end of private reply section -->
                                    
                                </div>

                            </div>
                        </div>
                    </div> 
                    <!-- end of new template section -->

                    <div class="col-12 text-center" id="response_status"></div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="modal-footer bg-whitesmoke padding_0_45px">
				<div class="row">
					<div class="col-6">
						<button class="btn btn-lg btn-info float-left save_create" create_template="yes" id="save_button"><i class='fas fa-save'></i> <?php echo $this->lang->line("Submit & Save as Template") ?></button>
					</div>

                    <div class="col-6">
                        <button class="btn btn-lg btn-primary float-right" create_template="no" id="save_button"><i class='fas fa-save'></i> <?php echo $this->lang->line("Submit") ?></button>
                    </div>
				</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_auto_reply_message_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center"><?php echo $this->lang->line("Please give the following information for post auto Reply") ?></h5>
                <button type="button" id='edit_modal_close' class="close">&times;</button>
            </div>
            <form action="#" id="edit_auto_reply_info_form" method="post">
                <input type="hidden" name="edit_auto_reply_page_id" id="edit_auto_reply_page_id" value="">
                <input type="hidden" name="edit_auto_reply_post_id" id="edit_auto_reply_post_id" value="">
                <div class="modal-body" id="edit_auto_reply_message_modal_body">

                    <div class="text-center waiting previewLoader"><i class="fas fa-spinner fa-spin blue text-center font_size_40px"></i></div><br>


                    <!-- comment hide and delete section -->
                    <div class="row padding_10_20_10_20px <?php if (!$commnet_hide_delete_addon) echo 'd_none';?> ">
                        <div class="col-12">
                            <div class="row">							
                            	<div class="col-12 col-md-6" >
                            		<label><i class="fa fa-ban"></i> <?php echo $this->lang->line("what do you want about offensive comments?") ?></label>
                            	</div>
                            	<div class="col-12 col-md-6">
                            		<div class="row">
                            		  <div class="col-12 col-md-6">
                            		    <label class="custom-switch">
                            		      <input type="radio" name="edit_delete_offensive_comment" value="hide" id="edit_delete_offensive_comment_hide" class="custom-switch-input" checked>
                            		      <span class="custom-switch-indicator"></span>
                            		      <span class="custom-switch-description"><?php echo $this->lang->line('hide'); ?></span>
                            		    </label>
                            		  </div>
                            		  <div class="col-12 col-md-6">
                            		    <label class="custom-switch">
                            		      <input type="radio" name="edit_delete_offensive_comment" value="delete"  id="edit_delete_offensive_comment_delete" class="custom-switch-input">
                            		      <span class="custom-switch-indicator"></span>
                            		      <span class="custom-switch-description"><?php echo $this->lang->line('delete'); ?>
                            		    </label>
                            		  </div>
                            		</div>
                            	</div>
                            </div>
                        </div>
                        <br/><br/>

                        <div class="row" id="edit_delete_offensive_comment_keyword_div">
                            <div class="col-12 col-md-6">
                                <div class="form-group e4e6fc_border_dashed">
                                    <label><i class="fa fa-tag"></i> <?php echo $this->lang->line("write down the offensive keywords in comma separated") ?>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("offensive keywords") ?>" data-content="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions"); ?> "><i class='fa fa-info-circle'></i> </a>
                                    </label>
                                    <textarea class="form-control message height_70px" name="edit_delete_offensive_comment_keyword" id="edit_delete_offensive_comment_keyword" placeholder="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions") ?>"></textarea>
                                </div>
                            </div>

                            <!-- private reply section -->
                            <?php if($instagram_reply_bot_addon) : ?>
                            <div class="col-12 col-md-6">
                                <div class="form-group clearfix e4e6fc_border_dashed">
                                    <label><small>
                                        <i class="fas fa-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply after deleting offensive comment") ?></small>
                                    </label>
                                    <div>                      
                                        <select class="form-group private_reply_postback select2" id="edit_private_message_offensive_words" name="edit_private_message_offensive_words">
                                            <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                        </select>

                                        <a href="" class="add_template float-left"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("Add Message Template");?></a>
                                        <a href="" class="ref_template float-right"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Refresh List");?></a>

                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- end of private reply section -->
                        </div>

                    </div>
                    <!-- end of comment hide and delete section -->


                    <div class="row padding_10_20_10_20px">
                        <div class="col-12">

                            <div class="row">							
                            	<div class="col-12 col-md-6" ><label><i class="fa fa-sort-numeric-down"></i> <?php echo $this->lang->line("Do you want to reply comments of a user multiple times?") ?></label></div>
                            	<div class="col-12 col-md-6">
                            	  <div class="form-group">
                            	    <label class="custom-switch">
                            	      <input type="checkbox" name="edit_multiple_reply" value="yes" id="edit_multiple_reply" class="custom-switch-input">
                            	      <span class="custom-switch-indicator"></span>
                            	      <span class="custom-switch-description"><?php echo $this->lang->line('Yes');?></span>
                            	    </label>
                            	  </div>
                            	</div>
                            </div>
                        </div>
                        <div class="smallspace clearfix"></div>

                        <!-- comment hide and delete section -->
                        <div class="col-12 <?php if (!$commnet_hide_delete_addon) echo 'd_none'; ?>">

                            <div class="row">							
                            	<div class="col-12 col-md-6" >
                            		<label><i class="fa fa-eye-slash"></i> <?php echo $this->lang->line("do you want to hide comments after comment reply?") ?></label>
                            	</div>
                            	<div class="col-12 col-md-6">
                            	  <div class="form-group">
                            	    <label class="custom-switch">
                            	      <input type="checkbox" name="edit_hide_comment_after_comment_reply" value="yes" id="edit_hide_comment_after_comment_reply" class="custom-switch-input">
                            	      <span class="custom-switch-indicator"></span>
                            	      <span class="custom-switch-description"><?php echo $this->lang->line('Yes');?></span>
                            	    </label>
                            	  </div>
                            	</div>
                            </div>
                        </div>
                        <!-- comment hide and delete section -->

                        <br/><br/>

                        <div class="col-12">
                          <div class="custom-control custom-radio">
                          	<input type="radio" name="edit_message_type" value="generic" id="edit_generic" class="custom-control-input radio_button">
                          	<label class="custom-control-label" for="edit_generic"><?php echo $this->lang->line("generic comment reply for all") ?></label>
                          </div>
                          <div class="custom-control custom-radio">
                          	<input type="radio" name="edit_message_type" value="filter" id="edit_filter" class="custom-control-input radio_button">
                          	<label class="custom-control-label" for="edit_filter"><?php echo $this->lang->line("send comment reply by filtering word/sentence") ?></label>
                          </div>
                        </div>

                        <div class="col-12 margin_top_15">
                            <div class="form-group">
                                <label>
                                    <i class="fa fa-monument"></i> <?php echo $this->lang->line("auto comment reply campaign name") ?> <span
                                            class="red">*</span>
                                </label>
                                <input class="form-control" type="text" name="edit_auto_campaign_name"
                                       id="edit_auto_campaign_name"
                                       placeholder="<?php echo $this->lang->line("write your auto comment reply campaign name here") ?>">
                            </div>
                        </div>
                        <div class="col-12 d_none" id="edit_generic_message_div">
                            <div class="form-group e4e6fc_border_dashed clearfix">
                                <label>
                                    <i class="fa fa-envelope"></i> <?php echo $this->lang->line("comment reply text") ?> <span
                                            class="red">*</span>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("message") ?>"
                                       data-content="<?php echo $this->lang->line("write your message which you want to send. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                class='fa fa-info-circle'></i> </a>
                                </label>
                                <?php if ($comment_tag_machine_addon) { ?>
                                    <span class='float-right'>
                                        <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>" data-toggle="tooltip" data-placement="top"
                                           class='btn btn-default btn-sm lead_tag_name button-outline'><i class='fa fa-tags'></i> <?php echo $this->lang->line("mention user") ?></a>
                                    </span>
                                <?php } ?>
                                <span class='float-right'>
                                    <a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>" data-toggle="tooltip" data-placement="top" class='btn btn-default btn-sm lead_first_name button-outline'><i class='fa fa-user'></i> <?php echo $this->lang->line("Username") ?></a>
                                </span>
                                <div class="clearfix"></div>
                                <textarea class="form-control message height_170px" name="edit_generic_message" id="edit_generic_message" placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                <!-- private reply section -->
                                <?php if($instagram_reply_bot_addon) : ?>
                                <br><br>
                                <label>
                                  <i class="fas fa-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                </label>
                                <div>                      
                                  <select class="form-group private_reply_postback select2" id="edit_generic_message_private" name="edit_generic_message_private">
                                    <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                  </select>

                                  <a href="" class="add_template float-left"><i class="fa fa-plus-circle"></i>     <?php echo $this->lang->line("Add Message Template");?></a>
                                  <a href="" class="ref_template float-right"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Refresh List");?></a>
                                </div>
                                <?php endif; ?>
                                <!-- end of private reply section -->

                            </div>
                        </div>
                        <div class="col-12 d_none" id="edit_filter_message_div">
                            <?php for ($i = 1; $i <= 20; $i++) : ?>
                                <div class="form-group instagram_border_margined_padded2 clearfix" id="edit_filter_div_<?php echo $i; ?>">
                                    <label>
                                        <i class="fa fa-tag"></i> <?php echo $this->lang->line("filter word/sentence") ?> <span
                                                class="red">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("message") ?>"
                                           data-content="<?php echo $this->lang->line("Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, want to know, when") ?>"><i
                                                    class='fa fa-info-circle'></i> </a>
                                    </label>
                                    <input class="form-control filter_word" type="text" name="edit_filter_word_<?php echo $i; ?>" id="edit_filter_word_<?php echo $i; ?>" placeholder="<?php echo $this->lang->line("write your filter word here") ?>">

                                    <br>
                                    <label>
                                        <?php echo $this->lang->line("comment reply text") ?><span
                                                class="red">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("message") ?>" data-content="<?php echo $this->lang->line("write your message which you want to send based on filter words. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i class='fa fa-info-circle'></i> </a>
                                    </label>
                                    <?php if ($comment_tag_machine_addon) { ?>
                                        <span class='float-right'>
                                            <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>" data-toggle="tooltip" data-placement="top"
                                               class='btn btn-default btn-sm lead_tag_name button-outline'><i
                                                        class='fa fa-tags'></i> <?php echo $this->lang->line("mention user") ?></a>
                                        </span>
                                    <?php } ?>
                                    <span class='float-right'>
                                        <a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>" data-toggle="tooltip" data-placement="top"
                                           class='btn btn-default btn-sm lead_first_name button-outline'><i
                                                    class='fa fa-user'></i> <?php echo $this->lang->line("Username") ?></a>
                                    </span>
                                    <div class="clearfix"></div>
                                    <textarea class="form-control message height_170px" name="edit_comment_reply_msg_<?php echo $i; ?>" id="edit_comment_reply_msg_<?php echo $i; ?>" placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                    <!-- private reply section -->
                                    <?php if($instagram_reply_bot_addon) : ?>
                                    <br><br>
                                    <label>
                                      <i class="fas fa-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                    </label>
                                    <div>                      
                                      <select class="form-group private_reply_postback select2" id="edit_filter_message_<?php echo $i; ?>" name="edit_filter_message_<?php echo $i; ?>">
                                        <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                      </select>

                                      <a href="" class="add_template float-left"><i class="fa fa-plus-circle"></i>     <?php echo $this->lang->line("Add Message Template");?></a>
                                      <a href="" class="ref_template float-right"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Refresh List");?></a>
                                    </div>
                                    <?php endif; ?>
                                    <!-- end of private reply section -->

                                </div>
                            <?php endfor; ?>

                            <div class="clearfix">
                                <input type="hidden" name="edit_content_counter" id="edit_content_counter"/>
                                <button type="button" class="btn btn-sm btn-outline-primary float-right" id="edit_add_more_button"><i class="fa fa-plus"></i> <?php echo $this->lang->line("add more filtering") ?>
                                </button>
                            </div>

                            <div class="form-group instagram_border_margined_padded clearfix" id="edit_nofilter_word_found_div">
                                <label>
                                    <i class="fa fa-envelope"></i> <?php echo $this->lang->line("comment reply if no matching found") ?>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("message") ?>"
                                       data-content="<?php echo $this->lang->line("Write the message,  if no filter word found. If you don't want to send message them, just keep it blank ."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                class='fa fa-info-circle'></i> </a>
                                </label>
                                <?php if ($comment_tag_machine_addon) { ?>
                                    <span class='float-right'>
                                        <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>" data-toggle="tooltip" data-placement="top"
                                           class='btn btn-default btn-sm lead_tag_name button-outline'><i
                                                    class='fa fa-tags'></i> <?php echo $this->lang->line("mention user") ?></a>
                                    </span>
                                <?php } ?>
                                <span class='float-right'>
                                    <a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>" data-toggle="tooltip" data-placement="top"
                                       class='btn btn-default btn-sm lead_first_name button-outline'><i
                                                class='fa fa-user'></i> <?php echo $this->lang->line("Username") ?></a>
                                </span>
                                <div class="clearfix"></div>
                                <textarea class="form-control message height_170px" name="edit_nofilter_word_found_text"
                                          id="edit_nofilter_word_found_text"
                                          placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                <!-- private reply section -->
                                <?php if($instagram_reply_bot_addon) : ?>
                                <br><br>
                                <label>
                                  <i class="fas fa-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                </label>
                                <div>                      
                                  <select class="form-group private_reply_postback select2" id="edit_nofilter_word_found_text_private" name="edit_nofilter_word_found_text_private">
                                    <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                  </select>

                                  <a href="" class="add_template float-left"><i class="fa fa-plus-circle"></i>     <?php echo $this->lang->line("Add Message Template");?></a>
                                  <a href="" class="ref_template float-right"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Refresh List");?></a>
                                </div>
                                <?php endif; ?>
                                <!-- end of private reply section -->

                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 text-center" id="edit_response_status"></div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="modal-footer bg-whitesmoke padding_0_45px">
            	<div class="row">
            		<div class="col-6">
            			<button class="btn btn-lg btn-primary float-left" id="edit_save_button"><i class='fa fa-save'></i> <?php echo $this->lang->line("save") ?></button>
            		</div>  
            		<div class="col-6">
            			<button class="btn btn-lg btn-secondary float-right cancel_button"><i class='fas fa-times'></i> <?php echo $this->lang->line("cancel") ?></button>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="media_insights_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content bg_f1f1f1">
            <div class="modal-header bbw">
                <h5 class="modal-title"><i class="fas fa-chart-bar"></i> <?php echo $this->lang->line('Post Analytics'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                 </button>
            </div>
            <div class="modal-body" id="media_insights_modal_body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="all_comments_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div id="all_comments_modal_contents"></div>
            </div>
        </div>
    </div>
</div>


<?php include("application/views/instagram_reply/comment_reply/full_mentions_campaign_modals.php"); ?>



<!-- instand comment checker -->
<div class="modal fade" id="instant_comment_modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title"><i class="fas fa-comments"></i> <?php echo $this->lang->line("Instant Comment") ?></h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>

			<div class="modal-body">     
				<input type="hidden" name="instant_comment_page_id" id="instant_comment_page_id">           
				<input type="hidden" name="instant_comment_post_id" id="instant_comment_post_id">           
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label><i class="fas fa-keyboard"></i> <?php echo $this->lang->line("Please provide a message as comment") ?></label>
							<textarea class="form-control" name="instant_comment_message" id="instant_comment_message" placeholder="<?php echo $this->lang->line("Type your comment here.") ?>"></textarea>
						</div>
					</div>
					<div class="col-12">
						<button class="btn btn-primary submit_instant_comment"><i class="fas fa-paper-plane"></i> <?php echo $this->lang->line('Create Comment'); ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php 
    $Youdidntprovideallinformation = $this->lang->line("you didn\'t provide all information.");
    $Pleaseprovidepostid = $this->lang->line("please provide post id.");
    $Youdidntselectanytemplate = $this->lang->line("you have not select any template.");
    $Youdidntselectanyoptionyet = $this->lang->line("you have not select any option yet.");
    $Youdidntselectanyoption = $this->lang->line("you have not select any option.");
    
    $AlreadyEnabled = $this->lang->line("already enabled");
    $ThispostIDisnotfoundindatabaseorthispostIDisnotassociatedwiththepageyouareworking = $this->lang->line("This post ID is not found in database or this post ID is not associated with the page you are working.");
    $EnableAutoReply = $this->lang->line("enable auto reply");
    $TypeAutoCampaignname = $this->lang->line("You have not Type auto campaign name");
    $YouDidnotchosescheduleType = $this->lang->line("You have not choose any schedule type");
    $YouDidnotchosescheduletime = $this->lang->line("You have not select any schedule time");
    $YouDidnotchosescheduletimezone = $this->lang->line("You have not select any time zone");
    $YoudidnotSelectPerodicTime = $this->lang->line("You have not select any periodic time");
    $YoudidnotSelectCampaignStartTime = $this->lang->line("You have not choose campaign start time");
    $YoudidnotSelectCampaignEndTime = $this->lang->line("You have not choose campaign end time");
?>
<!-- start of auto comment javascript section -->
<?php include(FCPATH.'application/views/comment_automation/autocomment_javascript_section.php'); ?>
<!-- end of auto comment javascript section -->
<!-- start of auto comment modal section -->
<?php include(FCPATH.'application/views/comment_automation/autocomment_modal_section.php'); ?>
<!-- end of auto comment modal section -->


<!-- postback add/refresh button section -->
<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body"> 
        <iframe src="" frameborder="0" width="100%" onload="resizeIframe(this)"></iframe>
      </div>
      <div class="modal-footer">
        <button data-dismiss="modal" type="button" class="btn-lg btn btn-dark"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Close & Refresh List");?></button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $("document").ready(function(){     
        var base_url = "<?php echo base_url(); ?>";

        $('.modal').on("hidden.bs.modal", function (e) { 
            if ($('.modal:visible').length) { 
                $('body').addClass('modal-open');
            }
        });

        $(document).on('click','.add_template',function(e){
          e.preventDefault();
          var current_id=$(this).prev().prev().attr('id');
          var current_val=$(this).prev().prev().val();
          var page_id = get_page_id();
          if(page_id=="")
          {
            swal('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
            return false;
          }
          $("#add_template_modal").attr("current_id",current_id);
          $("#add_template_modal").attr("current_val",current_val);
          $("#add_template_modal").modal();
        });

        $(document).on('click','.ref_template',function(e){
          e.preventDefault();
          var current_val=$(this).prev().prev().prev().val();
          var current_id=$(this).prev().prev().prev().attr('id');
          var page_id = get_page_id();
           if(page_id=="")
           {
             swal('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
             return false;
           }
           $.ajax({
             type:'POST',
             url: base_url+"instagram_reply/get_private_reply_postbacks",
             data: {page_table_ids:page_id},
             dataType: 'JSON',
             success:function(response){
               $("#"+current_id).html(response.options).val(current_val);
             }
           });
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) { 
          var current_id=$("#add_template_modal").attr("current_id");
          var current_val=$("#add_template_modal").attr("current_val");
          var page_id = get_page_id();
           if(page_id=="")
           {
             swal('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
             return false;
           }
           $.ajax({
             type:'POST' ,
             url: base_url+"instagram_reply/get_private_reply_postbacks",
             data: {page_table_ids:page_id,is_from_add_button:'1'},
             dataType: 'JSON',
             success:function(response){
               $("#"+current_id).html(response.options);
             }
           });
        });

        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal',function(){ 
            var page_id = get_page_id();
            var rand_time="<?php echo time(); ?>";
            var media_type = "ig";
            var iframe_link="<?php echo base_url('messenger_bot/create_new_template/1/');?>"+page_id+"/0/"+media_type+"?lev="+rand_time;
            $(this).find('iframe').attr('src',iframe_link); 
        });   
        // getting postback list and making iframe

    });

    function get_page_id()
    {
        var page_id = $("#dynamic_page_id").val();
        return page_id;
    }
</script>