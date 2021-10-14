<style>.select2{width: 100% !important;}</style>
<div id="dynamic_field_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="page_name">
                <div class="modal-body" style="padding-bottom:0">
                    <div class="row">
                          <div class="col-12"> 
                            <div class="form-group">
                              <label><?php echo $this->lang->line("Select Facebook page / Instagram account"); ?></label>
                              <?php echo $page_dropdown;?>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: 10px;">
                    <button id="submit" class="btn btn-primary btn-lg"><i class="fas fa-comment-alt"></i> <?php echo $this->lang->line('Live Chat'); ?></button>
                </div>
            </form>
        </div>
    </div>

</div> 

<script>
$(document).ready(function(){

    var base_url="<?php echo base_url(); ?>";
    setTimeout(function(){  $('#dynamic_field_modal').modal('show'); }, 500);

    $('#submit').click(function(e) {
       e.preventDefault();
       var page_id = $('#page_id').val();

       if(page_id == '')
       {
          swal('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Please select a Facebook page / Instagram account"); ?>', 'warning');
          return false;
       }
       else
       {
          var exp = page_id.split("-");
          var page_auto_id = 0;
          var social_media = 'fb';
          if(typeof(exp[0])!=='undefined') page_auto_id = exp[0];
          if(typeof(exp[1])!=='undefined') social_media = exp[1];

          var link = base_url+"message_manager/message_dashboard/"+page_auto_id;
          if(social_media=='ig') link = base_url+"message_manager/instagram_message_dashboard/"+page_auto_id;
          window.open(link, '_blank').focus();
       }         

    });

    $(document).on('click', '.edit_reply_info', function(event) {
      event.preventDefault();
      var table_id = $(this).attr('table_id');
      var media_type = $(this).attr('media_type');
      var link = base_url + "visual_flow_builder/edit_builder_data/" + table_id + "/1/" + media_type;
      window.location.replace(link);
    });


    $(document).on('click', '.delete_data', function(event) {
        event.preventDefault();
        swal({
            title: '<?php echo $this->lang->line("Warning"); ?>',
            text: '<?php echo $this->lang->line("Are you sure you want to delete this campaign"); ?>',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willreset) => {
            if (willreset) 
            {
                $(this).addClass('btn-progress');
                var table_id = $(this).attr('table_id');

                $.ajax({
                    context: this,
                    type:'POST',
                    url: base_url + "visual_flow_builder/delete_flowbuilder_data",
                    dataType: 'json',
                    data: {table_id},
                    success:function(response){ 
                    if(response.status == 1)
                    {
                        $(this).removeClass('btn-progress');
                        
                        swal('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                          table.draw();
                      });
                    }
                    else
                    {
                        swal('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                },
                error:function(response){
                    var span = document.createElement("span");
                    span.innerHTML = response.responseText;
                    swal({ title:'<?php echo $this->lang->line("Error!"); ?>', content:span,icon:'error'});
                }
            });
            } 
        });
    });
     

});
</script>