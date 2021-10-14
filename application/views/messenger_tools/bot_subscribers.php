<section class="section section_custom">
  <div class="section-header">
    <h1><i class="fas fa-users"></i> <?php echo $page_title;?></h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="<?php echo base_url('subscriber_manager'); ?>"><?php echo $this->lang->line("Subscriber Manager");?></a></div>
      <div class="breadcrumb-item"><?php echo $page_title;?></div>
    </div>
  </div>

  <?php $this->load->view('admin/theme/message'); ?>

  <style type="text/css">
    #page_id{width: 120px;}
    #label_id{width: 100px;}
    .bbw{border-bottom-width: thin !important;border-bottom:solid .5px #f9f9f9 !important;padding-bottom:20px;}
    @media (max-width: 575.98px) {
      #page_id{width: 80px;}
      #label_id{width: 80px;}
    }
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

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body data-card">
            <div class="row">
              <div class="col-12 col-md-10">
                <?php 

                echo 
                '<div class="input-group mb-3" id="searchbox">
                  <div class="input-group-prepend">
                   '.$page_dropdown.'
                  </div>
                  <div class="input-group-prepend" id="label_dropdown">
                  </div>

                  <div class="input-group-prepend">
                    <select class="form-control select2" id="gender" name="gender">
                      <option value="">'.$this->lang->line("Gender").'</option>
                      <option value="male">'.$this->lang->line("Male").'</option>
                      <option value="female">'.$this->lang->line("Female").'</option>
                    </select>
                  </div>

                  <select class="form-control select2" id="email_phone_birth" name="email_phone_birth[]" multiple="multiple" style="max-width:40%;">
                    <option value="has_phone">'.$this->lang->line("Has Phone").'</option>
                    <option value="has_email">'.$this->lang->line("Has Email").'</option>
                    <option value="has_birthdate">'.$this->lang->line("Has Birth Date").'</option>
                  </select>

                  <input type="text" class="form-control" autofocus id="search_value" name="search_value" placeholder="'.$this->lang->line("Search...").'" style="max-width:30%;">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="search_subscriber"><i class="fas fa-search"></i> <span class="d-none d-sm-inline">'.$this->lang->line("Search").'</span></button>
                  </div>
                </div>'; ?>                                          
              </div>

              <div class="col-12 col-md-2">

                <div class="btn-group dropleft float-right">
                  <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo $this->lang->line("Options"); ?>
                  </button>
                  <div class="dropdown-menu dropleft">
                    <a class="dropdown-item" href="<?php echo base_url('subscriber_manager/download_result'); ?>"><i class="fas fa-cloud-download-alt"></i> <?php echo $this->lang->line("Download Result"); ?></a>
                    <a class="dropdown-item" id="assign_group" href=""><i class="fas fa-user-tag"></i> <?php echo $this->lang->line("Assign Label"); ?></a>

                    <?php if($this->sms_email_drip_exist) : ?>
                      <?php if($this->session->userdata('user_type') == 'Admin' || count(array_intersect($this->module_access, array(270,271))) > 0 ) :  ?>
                        <a class="dropdown-item" id="assign_sms_email_sequence" href=""><i class="fas fa-plug"></i> <?php echo $this->lang->line("Assign Sequence"); ?></a>
                      <?php endif; ?>
                    <?php endif; ?>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item red" id="bulk_delete_contact" href=""><i class="fas fa-trash"></i> <?php echo $this->lang->line("Delete Subscriber"); ?></a>
                  </div>
                </div>                          
              </div>
            </div>

            <div class="table-responsive2">
                <input type="hidden" id="put_page_id">
                <table class="table table-bordered" id="mytable">
                  <thead>
                    <tr>
                      <th>#</th>      
                      <th style="vertical-align:middle;width:20px">
                          <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label for="datatableSelectAllRows"></label>        
                      </th>
                      <th><?php echo $this->lang->line("Avatar"); ?></th>      
                      <th><?php echo addon_exist($module_id=320,$addon_unique_name="instagram_bot") ? $this->lang->line("Page/Account") : $this->lang->line("Page Name"); ?></th>    
                      <th><?php echo $this->lang->line("Subscriber ID"); ?></th>      
                      <th><?php echo $this->lang->line("First Name"); ?></th>      
                      <th><?php echo $this->lang->line("Last Name"); ?></th>      
                      <th><?php echo $this->lang->line("Full Name"); ?></th>
                      <th><?php echo $this->lang->line("Actions"); ?></th>      
                      <th><?php echo $this->lang->line("Quick Info"); ?></th>      
                      <th><?php echo $this->lang->line("Label/Tag"); ?></th>      
                      <th><?php echo $this->lang->line("Thread ID"); ?></th>      
                      <th><?php echo $this->lang->line("Synced at"); ?></th>
                      <th><?php echo $this->lang->line("Social Media"); ?></th>
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

<?php     
    $doyouwanttodeletethiscontact = $this->lang->line("Do you want to delete this subscriber?");
    $youhavenotselected = $this->lang->line("You have not selected any subscriber to assign label. You can choose upto");
    $youhavenotselectanysubscribertoassignsequence = $this->lang->line("You have not selected any subscriber to assign sms/email sequence campaign. You can choose upto");
    $youhavenotselected2 = $this->lang->line("You have not selected any subscriber to delete.");
    $leadsatatime = $this->lang->line("subscribers at a time.");
    $youcanselectupto = $this->lang->line("You can select upto");
    $leadsyouhaveselected = $this->lang->line(",you have selected");
    $leads = $this->lang->line("subscribers.");
    $youhavenotselectedany = $this->lang->line("You have not selected any subscriber to delete. you can choose upto");
    $youhavenotselectedanyleadtoassigngroup = $this->lang->line("You have not selected any subscriber to assign label.");
    $youhavenotselectedanyleadtoassigndripcampaign = $this->lang->line("You have not selected any subscriber to assign sequence campaign.");
    $youhavenotselectedanyleadgroup = $this->lang->line("You have not selected any label.");
    $youhavenotselectedanysequence = $this->lang->line("You have not selected any sequence campaign.");
    $pleasewait = $this->lang->line("Please wait...");
    $groupshavebeenassignedsuccessfully = $this->lang->line("Labels have been assigned successfully");
    $sequencehavebeenassignedsuccessfully = $this->lang->line("Sequence campaign have been assigned successfully");
    $contactshavebeendeletedsuccessfully = $this->lang->line("Subscribers have been deleted successfully");
    $somethingwentwrongpleasetryagain = $this->lang->line("Something went wrong, please try again."); 
    $ig_bot_exists = addon_exist($module_id=320,$addon_unique_name="instagram_bot") ? '1' : '0';   
?>



<script type="text/javascript">
    var is_webview_exist = "<?php echo $this->is_webview_exist; ?>"
    var base_url="<?php echo base_url();?>";    
    var youhavenotselected = "<?php echo $youhavenotselected;?>";
    var youhavenotselectanysubscribertoassignsequence = "<?php echo $youhavenotselectanysubscribertoassignsequence; ?>";
    var youhavenotselected2 = "<?php echo $youhavenotselected2;?>";
    var leadsatatime = "<?php echo $leadsatatime;?>";
    var youcanselectupto = "<?php echo $youcanselectupto;?>";
    var leadsyouhaveselected = "<?php echo $leadsyouhaveselected;?>";
    var leads = "<?php echo $leads;?>";
    var youhavenotselectedanyleadtoassigngroup = "<?php echo $youhavenotselectedanyleadtoassigngroup; ?>";
    var youhavenotselectedanyleadtoassigndripcampaign = "<?php echo $youhavenotselectedanyleadtoassigndripcampaign; ?>";
    var youhavenotselectedanyleadgroup = "<?php echo $youhavenotselectedanyleadgroup; ?>";
    var pleasewait = "<?php echo $pleasewait; ?>";
    var groupshavebeenassignedsuccessfully = "<?php echo $groupshavebeenassignedsuccessfully; ?>";
    var sequencehavebeenassignedsuccessfully = "<?php echo $sequencehavebeenassignedsuccessfully; ?>";
    var contactshavebeendeletedsuccessfully = "<?php echo $contactshavebeendeletedsuccessfully; ?>";
    var auto_selected_page = "<?php echo $auto_selected_page; ?>";
    var auto_selected_subscriber = "<?php echo $auto_selected_subscriber; ?>";
    var youhavenotselectedanysequence = "<?php echo $youhavenotselectedanysequence; ?>";
    var ig_bot_exists = "<?php echo $ig_bot_exists; ?>";

    setTimeout(function(){ 
      $('#search_date_range').daterangepicker({
        ranges: {
          '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
          '<?php echo $this->lang->line("This Month");?>'  : [moment().startOf('month'), moment().endOf('month')],
          '<?php echo $this->lang->line("Last Month");?>'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      }, function (start, end) {
        $('#search_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
      });
    }, 3000);
    

    $("document").ready(function(){
      var perscroll;
      var table1 = '';
      if(auto_selected_page!='' && auto_selected_page!='0' ) $('#page_id').val(auto_selected_page).trigger('change');

      var hideCol = [4,10,11];
      table1 = $("#mytable").DataTable({
        serverSide: true,
        processing:true,
        bFilter: false,
        order: [[ 12, "desc" ]],
        pageLength: 10,
        ajax: {
            url: base_url+'subscriber_manager/bot_subscribers_data',
            type: 'POST',
            data: function ( d )
            {
                d.page_id = $('#page_id').val();
                d.search_value = $('#search_value').val();
                d.label_id = $('#label_id').val();
                d.email_phone_birth = $('#email_phone_birth').val();
                d.gender = $('#gender').val();
            }
        },
        language: 
        {
          url: "<?php echo base_url('assets/modules/datatables/language/'.$this->language.'.json'); ?>"
        },
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        columnDefs: [
          {
              targets: hideCol,
              visible: false
          },
          {
              targets: [0,2,4,8,9,10,11,12],
              className: 'text-center'
          },
          {
              targets: [0,1,2,8,10],
              sortable: false
          }
        ],
        fnInitComplete:function(){  // when initialization is completed then apply scroll plugin
             if(areWeUsingScroll)
             {
               if (perscroll) perscroll.destroy();
               perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
             }
         },
         scrollX: 'auto',
         fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again 
             if(areWeUsingScroll)
             { 
               if (perscroll) perscroll.destroy();
               perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
             }
         }
      });

      $(document).on('change', '#page_id', function(e) {
          var page_id =$(this).val();
          $.ajax({
            context: this,
            type:'POST',
            url:"<?php echo site_url();?>subscriber_manager/get_label_dropdown",
            data:{page_id:page_id},
            success:function(response){
               $("#label_dropdown").html(response);
               table1.draw(false);
            }
          });
      });

      if(auto_selected_subscriber!='' && auto_selected_subscriber!='0') 
      {
        $("#search_value").val(auto_selected_subscriber);
        $("#search_subscriber").click();
      }
      
      $(document).on('click', '#search_subscriber', function(e) {
          e.preventDefault(); 
          table1.draw(false);
      });

      $(document).on('change', '#label_id', function(e) {
          table1.draw(false);
      });

      $(document).on('change', '#gender', function(e) {
          table1.draw(false);
      });

      $(document).on('change', '#email_phone_birth', function(e) {
          table1.draw(false);
      });


      $(document).on('click','#assign_group',function(e){
          e.preventDefault();
          var upto = 500;
          var selected_page=$("#page_id").val(); // database id
          var ids = [];
          $(".datatableCheckboxRow:checked").each(function ()
          {
              ids.push(parseInt($(this).val()));
          });
          var selected = ids.length;

          if(selected_page=="")
          {
            swal('<?php echo $this->lang->line("Warning") ?>',"<?php echo $this->lang->line('To assign labels in bulk you have to search by any page first.');?>", 'warning');
              return;
          }

          if(ids=="") 
          {
            swal('<?php echo $this->lang->line("Warning") ?>', youhavenotselected+" "+upto+" "+leadsatatime, 'warning');
            return;
          } 
          if(selected>upto) 
          {
              swal('<?php echo $this->lang->line("Warning") ?>',youcanselectupto+" "+upto+" "+leadsyouhaveselected+" "+selected+" "+leads, 'warning');
              return;
          }
          
          $.ajax({
            type:'POST' ,
            url: "<?php echo site_url(); ?>subscriber_manager/get_label_dropdown_multiple",
            data:{selected_page:selected_page},
            success:function(response)
            {
               $("#get_labels").html(response);
            }
          });  

          $("#assign_group_modal").modal();         
      });

      $(document).on('click', '#assign_sms_email_sequence', function(event) {
        event.preventDefault();
        var upto = 500;
        var selected_page=$("#page_id").val();
        var ids = [];

        $(".datatableCheckboxRow:checked").each(function ()
        {
            ids.push(parseInt($(this).val()));
        });
        var selected = ids.length;

        if(selected_page=="")
        {
          swal('<?php echo $this->lang->line("Warning") ?>',"<?php echo $this->lang->line('To assign sequence in bulk you have to search by any page first.');?>", 'warning');
            return;
        }

        if(ids=="") 
        {
          swal('<?php echo $this->lang->line("Warning") ?>', youhavenotselectanysubscribertoassignsequence+" "+upto+" "+leadsatatime, 'warning');
          return;
        } 
        if(selected>upto) 
        {
            swal('<?php echo $this->lang->line("Warning") ?>',youcanselectupto+" "+upto+" "+leadsyouhaveselected+" "+selected+" "+leads, 'warning');
            return;
        }
        
        $.ajax({
          type:'POST' ,
          url: "<?php echo site_url(); ?>subscriber_manager/get_sequence_campaigns",
          data:{selected_page:selected_page},
          success:function(response)
          {
             $("#sequence_campaigns").html(response);
          }
        });  

        $("#assign_sqeuence_campaign_modal").modal(); 

      });

      $(document).on('click','#assign_group_submit',function(e){
          e.preventDefault();
          swal({
             title: '<?php echo $this->lang->line("Assign Label"); ?>',
             text: '<?php echo $this->lang->line("Do you really want to assign selected labels to your selected subscribers? Please be noted that bulk assigning labels will replace subscribers previous labels if any."); ?>',
             icon: 'warning',
             buttons: true,
             dangerMode: true,
           })
           .then((willDelete) => {
             if (willDelete) 
             {
                 var ids = [];
                 $(".datatableCheckboxRow:checked").each(function ()
                 {
                     ids.push(parseInt($(this).val()));
                 });
                 var selected = ids.length;        
                 
                 
                 if(ids=="") 
                 {
                   swal('<?php echo $this->lang->line("Warning") ?>', youhavenotselected+" "+upto+" "+leadsatatime, 'warning');
                   return;
                 } 

                 var group_id=$("#label_ids").val();
                 var page_id=$("#page_id").val();
                 var count=group_id.length;
                 
                 if(count==0) 
                 {
                   swal('<?php echo $this->lang->line("Error") ?>', youhavenotselectedanyleadgroup, 'error');
                   return;
                 } 

                 $("#assign_group_submit").addClass("btn-progress");

                 $.ajax({
                   type:'POST' ,
                   url: "<?php echo site_url(); ?>subscriber_manager/bulk_group_assign",
                   data:{ids:ids,group_id:group_id,page_id:page_id},
                   success:function(response)
                   {
                    $("#assign_group_submit").removeClass("btn-progress");
                    swal('<?php echo $this->lang->line("Label Assign") ?>', groupshavebeenassignedsuccessfully+" ("+selected+")", 'success')
                    .then((value) => {
                     $("#assign_group_modal").modal('hide');  
                     table1.draw(false);
                    });

                   }
                 });         
             } 
           });        
      });

      $(document).on('click','#assign_sequence_submit',function(e){
        e.preventDefault();

        var ids = [];
        $(".datatableCheckboxRow:checked").each(function ()
        {
            ids.push(parseInt($(this).val()));
        });
        var selected = ids.length;        
        
        if(ids=="") 
        {
          swal('<?php echo $this->lang->line("Warning") ?>', youhavenotselectanysubscribertoassignsequence+" "+upto+" "+leadsatatime, 'warning');
          return;
        } 

        var sequence_id = $("#sequence_ids").val();
        var page_id = $("#page_id").val();
        var count = sequence_id.length;
        
        if(count==0) 
        {
          swal('<?php echo $this->lang->line("Error") ?>', youhavenotselectedanysequence, 'error');
          return;
        } 

        $("#assign_sequence_submit").addClass("btn-progress");

        $.ajax({
          type:'POST' ,
          url: "<?php echo site_url(); ?>subscriber_manager/bulk_sequence_campaign_assign",
          data:{ids:ids,sequence_id:sequence_id,page_id:page_id},
          success:function(response)
          {
            $("#assign_sequence_submit").removeClass("btn-progress");
            swal('<?php echo $this->lang->line("Sequence Campaign Assign") ?>', sequencehavebeenassignedsuccessfully+" ("+selected+")", 'success')
            .then((value) => {
              $("#assign_sqeuence_campaign_modal").modal('hide');  
              table1.draw(false);
            });

          }
        });  

      });

      $(document).on('click','#bulk_delete_contact',function(e){
          e.preventDefault();
          var ids = [];
          var page_id=$("#page_id").val();

          $(".datatableCheckboxRow:checked").each(function ()
          {
              ids.push(parseInt($(this).val()));
          });
          var selected = ids.length;   

          if(page_id=="")
          {
            swal('<?php echo $this->lang->line("Warning") ?>',"<?php echo $this->lang->line('To delete subscribers in bulk you have to search by any page first.');?>", 'warning');
              return;
          }     
          if(ids=="") 
          {
            swal('<?php echo $this->lang->line("Warning") ?>', youhavenotselected2, 'warning');
            return;
          } 

          swal({
             title: '<?php echo $this->lang->line("Delete Subscribers"); ?>',
             text: '<?php echo $this->lang->line("Do you really want to delete selected subscribers?"); ?>',
             icon: 'error',
             buttons: true,
             dangerMode: true,
           })
           .then((willDelete) => {
             if (willDelete) 
             {
                 $.ajax({
                   type:'POST' ,
                   url: "<?php echo site_url(); ?>subscriber_manager/delete_bulk_subscriber",
                   data:{ids:ids,page_id:page_id},
                   success:function(response)
                   {
                    swal('<?php echo $this->lang->line("Delete Subscribers") ?>', contactshavebeendeletedsuccessfully+" ("+selected+")", 'success')
                    .then((value) => {                   
                     table1.draw(false);
                    });

                   }
                 });         
             } 
           });        
      });    


      $(document).on('click','.subscriber_actions_modal',function(e){
          e.preventDefault();
          
          var id=$(this).attr('data-id');
          var subscribe_id=$(this).attr('data-subscribe-id');
          var page_id=$(this).attr('data-page-id'); // auto id
          $("#search_subscriber_id").val(subscribe_id);
      
          var social_media = 'ig';
          if (page_id.indexOf('fb') > -1) social_media = 'fb';

          $("#subscriber_actions_modal").modal();
          get_subscriber_action_content(id,subscribe_id,page_id); 
          var user_input_flow_exist = "<?php echo $user_input_flow_exist; ?>";
          if(user_input_flow_exist == 'yes' && social_media=='fb')
          {
            get_subscriber_flowdata(id,subscribe_id,page_id);
            get_subscriber_customfields(id,subscribe_id,page_id);
          }
          else
          {
            $("#flowanswers-tab,#customfields-tab,#formdata-tab").hide();
          }

          if(is_webview_exist && social_media=='fb') get_subscriber_formdata(id,subscribe_id,page_id);

          $("#default-tab").click();
      });     


      $(document).on('click','.update_user_details',function(e){
        e.preventDefault();
        $(this).addClass('btn-progress');
        $("#save_changes").addClass("btn-progress");
        var post_value = $(this).attr('button_id');
        var social_media = $(this).attr('social_media');

        var exp=[];
        exp=post_value.split("-");
        var id=exp[0];
        var subscribe_id=exp[1];
        var page_id=exp[2];

        var page_id_media = page_id+"-"+social_media;

        $.ajax({
          context: this,
          type:'POST',
          dataType:'JSON',
          url:"<?php echo site_url();?>subscriber_manager/sync_subscriber_data",
          data:{post_value:post_value,social_media:social_media},
          success:function(response){
             $(this).removeClass('btn-progress');
             $("#save_changes").removeClass('btn-progress');
             if(response.status=='1')   iziToast.success({title: '',message: response.message,position: 'bottomRight'});       
             else  iziToast.error({title: '',message: response.message,position: 'bottomRight'});
             get_subscriber_action_content(id,subscribe_id,page_id_media);    
          }
        });

      });

      $(document).on('click','.reset_user_input_flow',function(e){
        e.preventDefault();
        $(this).addClass('btn-progress');
        $("#save_changes").addClass("btn-progress");
        var post_value = $(this).attr('button_id');
        var social_media = $(this).attr('social_media');

        var exp=[];
        exp=post_value.split("-");
        var id=exp[0];
        var subscribe_id=exp[1];
        var page_id=exp[2];

        var page_id_media = page_id+"-"+social_media;

        $.ajax({
          context: this,
          type:'POST',
          dataType:'JSON',
          url:"<?php echo site_url();?>subscriber_manager/reset_user_input_flow",
          data:{post_value:post_value,social_media:social_media},
          success:function(response){
             $(this).removeClass('btn-progress');
             $("#save_changes").removeClass('btn-progress');
             if(response.status=='1')   iziToast.success({title: '',message: response.message,position: 'bottomRight'});       
             else  iziToast.error({title: '',message: response.message,position: 'bottomRight'});
             get_subscriber_action_content(id,subscribe_id,page_id_media);    
          }
        });

      });

      $(document).on('click','.delete_user_details',function(e){
        e.preventDefault();

        swal({
           title: '<?php echo $this->lang->line("Delete Subscriber"); ?>',
           text: '<?php echo $this->lang->line("Do you really want to delete this subscriber?"); ?>',
           icon: 'warning',
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
           if (willDelete) 
           {
               $(this).addClass('btn-progress');
               $("#save_changes").addClass("btn-progress");
               var post_value = $(this).attr('button_id');
               var social_media = $(this).attr('social_media');
               $.ajax({
                 context: this,
                 type:'POST',
                 dataType:'JSON',
                 url:"<?php echo site_url();?>subscriber_manager/delete_subsriber",
                 data:{post_value:post_value,social_media:social_media},
                 success:function(response){
                    $(this).removeClass('btn-progress');
                    $("#save_changes").removeClass('btn-progress');
                    $("#subscriber_actions_modal").modal('hide');
                    iziToast.success({title: '',message: '<?php echo $this->lang->line("Subscriber has been deleted successfully."); ?>',position: 'bottomRight'});    
                 }
               });
           } 
         });       

      });
     
      function get_subscriber_flowdata(id,subscribe_id,page_id)
      {
        $(".flowanswers_div").html('<div class="text-center waiting"><i class="fas fa-spinner fa-spin blue text-center"></i></div>');

        $.ajax({
          type:'POST' ,
          url: "<?php echo site_url(); ?>subscriber_manager/get_subscriber_inputflow_data",
          data:{id:id,page_id:page_id,subscribe_id:subscribe_id},
          success:function(response)
          {
            $(".flowanswers_div").html(response);
          }
        }); 
      }

      function get_subscriber_customfields(id,subscribe_id,page_id)
      {
        $(".customfields_div").html('<div class="text-center waiting"><i class="fas fa-spinner fa-spin blue text-center"></i></div>');

        $.ajax({
          type:'POST' ,
          url: "<?php echo site_url(); ?>subscriber_manager/get_subscriber_customfields_data",
          data:{id:id,page_id:page_id,subscribe_id:subscribe_id},
          success:function(response)
          {
            $(".customfields_div").html(response);
          }
        }); 
      }

      function get_subscriber_formdata(id,subscribe_id,page_id)
      {
        $(".formdata_div").html('<div class="text-center waiting"><i class="fas fa-spinner fa-spin blue text-center"></i></div>');

        $.ajax({
          type:'POST' ,
          url: "<?php echo site_url(); ?>subscriber_manager/get_subscriber_formdata",
          data:{id:id,page_id:page_id,subscribe_id:subscribe_id},
          success:function(response)
          {
            $(".formdata_div").html(response);
          }
        }); 
      }

      var table2 = '';

      $(document).on('change', '#search_status', function(e) {
          table2.draw();
      });

      $(document).on('change', '#search_date_range_val', function(e) {
          e.preventDefault();
          table2.draw();
      });

      $(document).on('keypress', '#search_value2', function(e) {
        if(e.which == 13) $("#search_action").click();
      });

      $(document).on('click', '#search_action', function(event) {
        event.preventDefault(); 
        table2.draw();
      });

      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var id = $(this).attr('id');
        if(id=='purchase-tab' ) setTimeout(function(){ get_purchase_data(); }, 1000);
      });


      function get_purchase_data()
      {
        var perscroll2;
        if (table2 == '')
        {
          table2 = $("#mytable2").DataTable({
            serverSide: true,
            processing:true,
            bFilter: false,
            order: [[ 10, "desc" ]],
            pageLength: 10,
            ajax: {
                url: base_url+'subscriber_manager/my_orders_data',
                type: 'POST',
                data: function ( d )
                {
                    d.search_subscriber_id = $('#search_subscriber_id').val();
                    d.search_status = $('#search_status').val();
                    d.search_value = $('#search_value2').val();
                    d.search_date_range = $('#search_date_range_val').val();
                }
            },
            language: 
            {
              url: "<?php echo base_url('assets/modules/datatables/language/'.$this->language.'.json'); ?>"
            },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
              {
                  targets: [1,3,6,7,11],
                  visible: false
              },
              {
                  targets: [5,7,8,9,10,11],
                  className: 'text-center'
              },
              {
                  targets: [3,4],
                  className: 'text-right'
              },
              {
                  targets: [2,8,9],
                  sortable: false
              }
            ],
            fnInitComplete:function(){  // when initialization is completed then apply scroll plugin
                   if(areWeUsingScroll)
                   {
                     if (perscroll2) perscroll2.destroy();
                     perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                   }
               },
               scrollX: 'auto',
               fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again 
                   if(areWeUsingScroll)
                   { 
                     if (perscroll2) perscroll2.destroy();
                     perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                   }
               }
          });
        } 
        else table2.draw();
      }

    $('#subscriber_actions_modal').on('hidden.bs.modal', function () { 
      table1.draw(false);
    });
    $('#subscriber_actions_modal').on('shown.bs.modal', function() {
        $(document).off('focusin.modal');
    });   

  });

</script>

<?php include(FCPATH.'application/views/messenger_tools/subscriber_actions_common_js.php');?>



<style type="text/css">
  .multi_layout{margin:0;background: #fff}
  .multi_layout .card{margin-bottom:0;border-radius: 0;}
  .multi_layout{border:1px solid #dee2e6;border-top-width: 0;}
  .multi_layout .collef{padding-left: 0px; padding-right: 0px;border-right: 1px solid #dee2e6;}
  .multi_layout .colmid{padding-left: 0px; padding-right: 0px;}
  .multi_layout .card-statistic-1{border:1px solid #dee2e6;border-radius: 4px;}
  .multi_layout .main_card{min-height: 100%;}
  .multi_layout h6.page_name{font-size: 14px;}
  .multi_layout .card .card-header input{max-width: 100% !important;}
  .multi_layout .card .card-header h4 a{font-weight: 700 !important;}
  .multi_layout .card-primary{margin-top: 35px;margin-bottom: 15px;}
  .multi_layout .product-details .product-name{font-size: 12px;}
  .multi_layout .margin-top-50 {margin-top: 70px;}
  .multi_layout .waiting {height: 100%;width:100%;display: table;}
  .multi_layout .waiting i{font-size:60px;display: table-cell; vertical-align: middle;padding:30px 0;}
  .multi_layout .collef .bgimage{border-radius:5px;height: 250px;background-position: 50% 50%; background-size: cover;min-width: 140px;background-repeat:no-repeat;display: block;}
  .multi_layout .collef .subscriber_details{padding-right: 20px;}
  .multi_layout .colmid .section-title{padding-bottom: 10px;}
  .tab-content > .tab-pane{padding:0;}
   @media (max-width: 575.98px) {
      .multi_layout .collef{border-right: none !important;}
    }
</style>

<div class="modal fade" id="assign_group_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="fas fa-user-tag"></i> <?php echo $this->lang->line("Assign Label");?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body">    
                <div id="get_labels">              
                </div>
            </div>
            <div class="modal-footer">
              <a class="btn btn-primary float-left" href="" id="assign_group_submit"><i class="fas fa-user-tag"></i> <?php echo $this->lang->line("Assign Label") ?></a>
              <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i class="fas fa-times"></i> <?php echo $this->lang->line("Close") ?></a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="assign_sqeuence_campaign_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style='min-width:40%;'>
        <div class="modal-content">
            <div class="modal-header bbw">
              <h5 class="modal-title"><i class="fas fa-sort-numeric-up"></i> <?php echo $this->lang->line("Assign sms/email Sequence");?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            
            <div class="modal-body">   
              <div class="text-center" style="padding:20px;margin-bottom:20px;border:.5px solid #dee2e6; color:#6777ef;background: #fff;"><?php echo $this->lang->line("Bulk sequence assign is available for Email & SMS cmapaign. For Messenger, bulk campaign isn't available due to safety & avoiding breaking 24 Hours policy. "); ?></div>
              <div id="sequence_campaigns"></div>
            </div>
            <div class="modal-footer bg-whitesmoke">
              <a class="btn btn-lg btn-primary float-left" href="" id="assign_sequence_submit"><i class="fas fa-save"></i> <?php echo $this->lang->line("Assign Sequence") ?></a>
              <a class="btn btn-lg btn-light float-right" data-dismiss="modal"><i class="fas fa-times"></i> <?php echo $this->lang->line("Close") ?></a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="subscriber_actions_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="padding:15px;">
              <h5 class="modal-title"><i class="fas fa-user-circle"></i> <?php echo $this->lang->line("Subscriber Actions");?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body" id="subscriber_actions_modal_body" style="padding:0 15px 15px 15px;" data-backdrop="static" data-keyboard="false">
              
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="default-tab" data-toggle="tab" href="#default" role="tab" aria-controls="default" aria-selected="true"><?php echo $this->lang->line("Subscriber Data"); ?></a>
                </li>

                <?php if($user_input_flow_exist == 'yes') : ?>
                <li class="nav-item">
                  <a class="nav-link" id="flowanswers-tab" data-toggle="tab" href="#flowanswers" role="tab" aria-controls="flowanswers" aria-selected="false"><?php echo $this->lang->line("User Input Flow Answer"); ?></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="customfields-tab" data-toggle="tab" href="#customfields" role="tab" aria-controls="customfields" aria-selected="false"><?php echo $this->lang->line("Custom Fields"); ?></a>
                </li>
                <?php endif; ?>

                <?php if($webview_access == 'yes') : ?>
                <li class="nav-item">
                  <a class="nav-link" id="formdata-tab" data-toggle="tab" href="#formdata" role="tab" aria-controls="formdata" aria-selected="false"><?php echo $this->lang->line("Custom Form Data"); ?></a>
                </li>
                <?php endif; ?>
                <?php if($ecommerce_exist == 'yes') : ?>
                <li class="nav-item">
                  <a class="nav-link" id="purchase-tab" data-toggle="tab" href="#purchase" role="tab" aria-controls="purchase" aria-selected="false"><?php echo $this->lang->line("Purchase History"); ?></a>
                </li>
                <?php endif; ?>

              </ul>

              <div class="tab-content" id="myTabContent">
                
                <div class="tab-pane fade active show" id="default" role="tabpanel" aria-labelledby="default-tab">
                  <div class="row multi_layout">
                  </div> 
                </div>

                <div class="tab-pane fade" id="formdata" role="tabpanel" aria-labelledby="formdata-tab">
                  <div class="card no_shadow" style="border:1px solid #dee2e6;border-top:none;border-radius:0">
                    <div class="card-body">
                      <div class="row formdata_div" style="padding-top:20px;"></div>                  
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="flowanswers" role="tabpanel" aria-labelledby="flowanswers-tab">
                  <div class="card no_shadow" style="border:1px solid #dee2e6;border-top:none;border-radius:0">
                    <div class="card-body">
                      <div class="row flowanswers_div" style="padding-top:20px;"></div>                  
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="customfields" role="tabpanel" aria-labelledby="customfields-tab">
                  <div class="card no_shadow" style="border:1px solid #dee2e6;border-top:none;border-radius:0">
                    <div class="card-body">
                      <div class="row customfields_div" style="padding-top:20px;"></div>                  
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">
                  <div class="card no_shadow data-card" style="border:1px solid #dee2e6;border-top:none;border-radius:0">
                    <div class="card-body">
                      <div class="row purchase_div" style="padding-top:20px;"></div>
                      <div class="row">
                        <div class="col-12 col-md-9">
                          <?php
                          $status_list[''] = $this->lang->line("Status");                
                          echo 
                          '<div class="input-group mb-3" id="searchbox">
                            <div class="input-group-prepend d-none">
                              <input type="text" value="" name="search_subscriber_id" id="search_subscriber_id">
                            </div>
                            <div class="input-group-prepend d-none">
                              '.form_dropdown('search_status',$status_list,'','class="form-control select2" id="search_status"').'
                            </div>
                            <input type="text" class="form-control" id="search_value2" autofocus name="search_value2" placeholder="'.$this->lang->line("Search...").'" style="max-width:25%;">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="button" id="search_action"><i class="fas fa-search"></i> <span class="d-none d-sm-inline">'.$this->lang->line("Search").'</span></button>
                            </div>
                          </div>'; ?>                                          
                        </div>

                        <div class="col-12 col-md-3">

                        <?php
                          echo $drop_menu ='<a href="javascript:;" id="search_date_range" class="btn btn-primary btn-lg float-right icon-left btn-icon"><i class="fas fa-calendar"></i> '.$this->lang->line("Choose Date").'</a><input type="hidden" id="search_date_range_val">';
                        ?>

                                                   
                        </div>
                      </div>

                      <div class="table-responsive2">
                          <table class="table table-bordered" id="mytable2">
                            <thead>
                              <tr>
                                <th>#</th>      
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label for="datatableSelectAllRows"></label>        
                                </th>         
                                <th style="max-width: 130px"><?php echo $this->lang->line("Status")?></th>              
                                <th><?php echo $this->lang->line("Coupon")?></th>                   
                                <th><?php echo $this->lang->line("Amount")?></th>                   
                                <th><?php echo $this->lang->line("Currency")?></th>                   
                                <th><?php echo $this->lang->line("Method")?></th>                   
                                <th><?php echo $this->lang->line("Transaction ID")?></th>                   
                                <th><?php echo $this->lang->line("Invoice")?></th>                              
                                <th><?php echo $this->lang->line("Docs")?></th>                              
                                <th><?php echo $this->lang->line("Ordered at")?></th>                   
                                <th><?php echo $this->lang->line("Paid at")?></th>                  
                              </tr>
                            </thead>
                          </table>
                      </div>

                    </div>
                  </div>
                </div>

              </div>

                         
            </div>
   
        </div>
    </div>
</div>

<style type="text/css">
  .chocolat-wrapper{z-index: 1060 !important;}
</style>