<!-- new datatable section -->
<section class="section section_custom">
  <div class="section-header">
    <h1><i class="fa fa-th-large"></i> <?php echo $page_title; ?> </h1>
    
    <div class="section-header-button">
      <?php if($visual_flow_builder_exist == 'yes') : ?>
          <a class="btn btn-primary" href="<?php echo base_url('messenger_bot/create_new_template/0/0/0/'.$media_type); ?>">
            <i class="fas fa-plus-circle"></i> <?php echo $this->lang->line("Classic editor"); ?>
          </a>&nbsp;

        <?php if($builder_access == 'yes') : ?>
          <a class="btn btn-primary" name="add" id="add"  href="#">
             <i class="fas fa-plus-circle"></i> <?php echo $this->lang->line("Visual flow builder"); ?>
          </a> 
        <?php endif; ?>
      <?php else : ?>
        <a class="btn btn-primary" href="<?php echo base_url('messenger_bot/create_new_template/0/0/0/'.$media_type); ?>">
          <i class="fas fa-plus-circle"></i> <?php echo $this->lang->line("Create new template"); ?>
        </a> 
      <?php endif; ?>
    </div>

    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="<?php echo base_url('messenger_bot'); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a></div>
      <div class="breadcrumb-item"><?php echo $this->lang->line("Post-back Manager"); ?></div>
    </div>
  </div>

  <?php $this->load->view('admin/theme/message'); ?>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body data-card">

            <div class="input-group mb-3" id="searchbox">
                <div class="input-group-prepend">
                    <select class="select2 form-control" id="page_id">
                      <option value=""><?php echo $this->lang->line("Page"); ?></option>
                        <?php foreach ($page_info as $key => $value): ?>
                          <option value="<?php echo $value['id']; ?>"><?php echo $value['page_name']; ?></option>
                        <?php endforeach ?>
                  </select>
                </div>
                <input type="text" class="form-control" id="postback_id" autofocus placeholder="<?php echo $this->lang->line('PostBack'); ?>" aria-label="" aria-describedby="basic-addon2" style="max-width: 30%">
                <div class="input-group-append">
                      <button class="btn btn-primary" id="search_submit" type="button"><i class="fas fa-search"></i> <span class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span></button>
                </div>
            </div>
            
            <div class="table-responsive2">
              <input type="hidden" id="template_media_type" name="template_media_type" value="<?php echo $media_type; ?>">
              <table class="table table-bordered" id="mytable">
                <thead>
                  <tr>
                    <th>#</th>      
                    <th style="vertical-align:middle;width:20px">
                        <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label for="datatableSelectAllRows"></label>        
                    </th>
                    <th><?php echo $this->lang->line("id")?></th>
                    <th><?php echo $this->lang->line("Page Name")?></th>
                    <th><?php echo $this->lang->line("Postback Template Name")?></th>
                    <th><?php echo $this->lang->line("Postback ID")?></th>
                    <?php if($visual_flow_builder_exist == 'yes') : ?>
                      <th><?php echo $this->lang->line("Type")?></th>
                    <?php endif; ?>
                    <th><?php echo $this->lang->line("Actions")?></th>
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


<script>       
    var base_url="<?php echo site_url(); ?>";
    
    var visual_flow_builder_exist = "<?php echo $visual_flow_builder_exist; ?>";
    if(visual_flow_builder_exist == 'yes')
      var shortable_column = [0,1,2,3,4,5,7];
    else
      var shortable_column = [0,1,2,3,4,5,6];

    $(document).ready(function() {

      var perscroll;
      var table = $("#mytable").DataTable({
          serverSide: true,
          processing:true,
          bFilter: false,
          order: [[ 2, "desc" ]],
          pageLength: 10,
          ajax: {
              url: base_url+'messenger_bot/template_manager_data',
              type: 'POST',
              data: function ( d )
              {
                  d.page_id = $('#page_id').val();
                  d.postback_id = $('#postback_id').val();
                  d.template_media_type = $('#template_media_type').val();
              }
          },          
          language: 
          {
            url: "<?php echo base_url('assets/modules/datatables/language/'.$this->language.'.json'); ?>"
          },
          dom: '<"top"f>rt<"bottom"lip><"clear">',
          columnDefs: [
            {
                targets: [1,2],
                visible: false
            },
            {
                targets: '',
                className: 'text-center'
            },
            {
                targets: shortable_column,
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


      $(document).on('click', '#search_submit', function(event) {
        event.preventDefault(); 
        table.draw();
      });

      $(document).on('click', '.get_json_code', function(event) {
        event.preventDefault(); 
        var waiting_content = '<div class="text-center waiting"><i class="fas fa-spinner fa-spin blue text-center" style="font-size: 40px;"></i></div>';
        var table_id = $(this).attr('table_id');
        $('#get_json_code_modal_body').html(waiting_content);
        $('#get_json_code').modal();
        
        $.ajax({
          context: this,
          type:'POST' ,
          url:"<?php echo base_url('messenger_bot/get_json_code'); ?>",
          // dataType: 'json',
          data:{table_id:table_id},
          success:function(response){ 
            $('#get_json_code_modal_body').html(response);
          }
        });
      });

      $(document).on('change', '#page_id', function(event) {
        event.preventDefault(); 
        table.draw();
      });

      $(document).on('click','.delete_template',function(e){
        e.preventDefault();

        swal({
          title: '<?php echo $this->lang->line("Delete!"); ?>',
          text: '<?php echo $this->lang->line("Do you want to detete this template?"); ?>',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) 
          {
            var base_url = '<?php echo site_url();?>';
            $(this).addClass('btn-progress');
            var table_id = $(this).attr('table_id');

            $.ajax({
              context: this,
              type:'POST' ,
              url:"<?php echo site_url();?>messenger_bot/ajax_delete_template_info",
              // dataType: 'json',
              data:{table_id:table_id},
              success:function(response){ 
                $(this).removeClass('btn-progress');
                if(response=='success')
                {
                  iziToast.success({title: '',message: '<?php echo $this->lang->line("Template has been deleted successfully."); ?>',position: 'bottomRight'});
                  table.draw();
                }
                else if(response=='no_match')
                {
                  iziToast.error({title: '',message: '<?php echo $this->lang->line("No Template is found for this user with this ID."); ?>',position: 'bottomRight'});
                }
                else
                {
                  $("#delete_template_modal_body").html(response);
                  $("#delete_template_modal").modal();
                }
              }
            });
          } 
        });


      });

      $('#add').click(function(e){
          e.preventDefault();
          $('#dynamic_field_modal').modal('show');
      });

      $('#submit').click(function(e) {
        e.preventDefault();
         var page_id_media = $('#page_table_id').val();
         var page_id_media_array = page_id_media.split("-");

         var page_table_id = page_id_media_array[0];
         var media_type = 'fb';
         if (typeof page_id_media_array[1] !== 'undefined') {
           media_type = page_id_media_array[1];
         }
         
         if(page_table_id == '')
         {
              swal('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("You have to select a page"); ?>', 'warning');
              return false;
         }
         else
         {
              var link = base_url + "visual_flow_builder/load_builder/" + page_table_id + "/0/" + media_type;
              window.location.replace(link);
         }

      });

      $(document).on('click', '.edit_reply_info', function(event) {
        event.preventDefault();
        var table_id = $(this).attr('table_id');
        var media_type = $(this).attr('media_type');
        var link = base_url + "visual_flow_builder/edit_builder_data/" + table_id + "/2/" + media_type;
        window.location.replace(link);
      });



    });
  
 
</script>

<div class="modal fade" id="get_json_code" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center"><i class="fas fa-code"></i> <?php echo $this->lang->line("JSON Code"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="get_json_code_modal_body">                
              
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center"><i class="fa fa-trash"></i> <?php echo $this->lang->line("Template Delete Confirmation"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="delete_template_modal_body">                

            </div>
        </div>
    </div>
</div>

<div id="dynamic_field_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="page_name">
              <div class="modal-body" style="padding-bottom:0">
                  <div class="row">
                    <div class="col-12"> 
                      <?php if(addon_exist($module_id=320,$addon_unique_name="instagram_bot")) : ?>
                      <div class="form-group">
                        <label><?php echo $this->lang->line("Please select a page"); ?></label>
                        <select name="page_table_id" id="page_table_id" class="form-control select2" style="width:100%;">
                          <?php 
                            echo "<option value=''>".$this->lang->line('Choose a Page')."</option>";
                            if($media_type == 'fb') {
                              foreach ($flow_page_list['page_list'] as $key => $value) 
                              {
                                echo "<option value='".$key."' >".$value."</option>";
                              }

                            } else if($media_type == 'ig') {
                              foreach ($ig_flow_page_list['page_list'] as $key => $value) 
                              {
                                echo "<option value='".$key."' >".$value."</option>";
                              }

                            }
                          ?>
                        </select>

                          <!-- <select class="form-control select2" id="page_table_id" name="page_table_id" style="width:100%;">
                            <?php 
                              echo "<option value=''>".$this->lang->line('Choose a Page')."</option>";
                              foreach ($group_page_list as $key => $value) 
                              {
                                echo '<optgroup label="'.$value['media_name'].'">';
                                foreach ($value['page_list'] as $key2 => $value2) 
                                {
                                  echo "<option value='".$key2."' >".$value2."</option>";
                                }
                                echo '</optgroup>';
                              } 
                            ?>
                          </select> -->
                      </div>
                      <!-- <div class="form-group">
                        <label class="d-block"><?php echo $this->lang->line('Media'); ?></label>
                        <div class="row">
                          <div class="col-12 col-md-6">
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="media_type_fb" name="media_type" value="fb" class="custom-control-input">
                              <label class="custom-control-label" for="media_type_fb"><?php echo $this->lang->line('Facebook'); ?></label>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="media_type_ig" name="media_type" value="ig" class="custom-control-input">
                              <label class="custom-control-label" for="media_type_ig"><?php echo $this->lang->line('Instagram'); ?></label>
                            </div>
                          </div>
                        </div>
                      </div> -->
                      <?php else : ?>
                        <div class="form-group">
                          <label><?php echo $this->lang->line("Please select a page"); ?></label>
                          <?php 
                            $page_list[''] = $this->lang->line("Choose a Page");
                            echo form_dropdown('page_table_id',$page_list,'','id="page_table_id" class="form-control select2" style="width:100%;"'); 
                          ?>
                        </div>       
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="modal-footer" style="margin-top: 10px;">
                    <button class="btn btn-lg btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> <?php echo $this->lang->line("Cancel"); ?></button>
                    <button id="submit" class="btn btn-primary btn-lg"><i class="fas fa-check"></i> <?php echo $this->lang->line('Ok'); ?></button>
                    
                </div>
            </form>
        </div>
    </div>

</div>