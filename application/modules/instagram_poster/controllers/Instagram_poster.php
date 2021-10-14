<?php
/*
Addon Name: Instagram Poster
Unique Name: instagram_poster
Module ID: 220
Project ID: 19
Addon URI: https://xerochat.com
Author: Xerone IT
Author URI: http://xeroneit.net
Version: 1.0
Description: 
*/

require_once("application/controllers/Home.php"); // loading home controller

class Instagram_poster extends Home
{
    public $addon_data=array();
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')!= 1) redirect('home/login', 'location');

        $addon_path=APPPATH."modules/".strtolower($this->router->fetch_class())."/controllers/".ucfirst($this->router->fetch_class()).".php"; // path of addon controller
        $this->addon_data=$this->get_addon_data($addon_path);
        $this->member_validity();
        $this->user_id=$this->session->userdata('user_id'); // user_id of logged in user, we may need it 
    }

    public function index()
    {
        $this->image_video();
    }

    public function image_video()
    {
        if($this->session->userdata('user_type') != 'Admin' && !in_array(296,$this->module_access)) redirect('home/login', 'location');
        $data['page_title'] = $this->lang->line("Instagram Posting");

        // getting instagram info of the user
        $table = "facebook_rx_fb_page_info";
        $where = [];
        if($this->config->item('facebook_poster_botenabled_pages') == '1')
        $where['where'] = ['user_id'=>$this->user_id,"bot_enabled"=>"1","has_instagram"=>"1","facebook_rx_fb_user_info_id"=>$this->session->userdata("facebook_rx_fb_user_info")];
        else
        $where['where'] = ['user_id'=>$this->user_id,"has_instagram"=>"1","facebook_rx_fb_user_info_id"=>$this->session->userdata("facebook_rx_fb_user_info")];

        $select = ['id','page_profile','insta_username','instagram_business_account_id'];
        $data['account_list'] = $this->basic->get_data($table,$where,$select);
        
        $data['body'] = 'image_video_post/auto_post_list';
        $this->_viewcontroller($data);
    }   

    public function image_video_auto_post_list_data()
    {
        if($this->session->userdata('user_type') != 'Admin' && !in_array(296,$this->module_access)) exit();
        $this->ajax_check();

        $pagename        = trim($this->input->post("page_id",true));
        $post_type       = trim($this->input->post("post_type",true));
        $searching       = trim($this->input->post("searching",true));
        $post_date_range = $this->input->post("post_date_range",true);
        $display_columns = array("#",'id','campaign_name','campaign_type','publisher','post_type','actions','status','schedule_time','error_mesage');
        $search_columns = array('campaign_name','post_type','schedule_time');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'id';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
        $order_by=$sort." ".$order;

        $where_simple=array();

        if($post_date_range!="")
        {
            $exp = explode('|', $post_date_range);
            $from_date = isset($exp[0])?$exp[0]:"";
            $to_date   = isset($exp[1])?$exp[1]:"";

            if($from_date!="Invalid date" && $to_date!="Invalid date")
            {
                $from_date = date('Y-m-d', strtotime($from_date));
                $to_date   = date('Y-m-d', strtotime($to_date));
                $where_simple["Date_Format(last_updated_at,'%Y-%m-%d') >="] = $from_date;
                $where_simple["Date_Format(last_updated_at,'%Y-%m-%d') <="] = $to_date;
            }
        }

        if($post_type !="") $where_simple['facebook_rx_auto_post.post_type'] = $post_type;
        if($pagename !="") $where_simple['facebook_rx_auto_post.page_group_user_id'] = $pagename;
        if($searching !="") $where_simple['facebook_rx_auto_post.campaign_name like'] = "%".$searching."%";

        $where_simple['facebook_rx_auto_post.user_id'] = $this->user_id;
        $where_simple['facebook_rx_auto_post.facebook_rx_fb_user_info_id'] = $this->session->userdata("facebook_rx_fb_user_info");
        $where_simple['facebook_rx_auto_post.media_type'] = 'instagram';

        $this->db->where("(is_child='0' or posting_status='2')");
        $where  = array('where'=>$where_simple);

        $select = array(
            "facebook_rx_auto_post.id", 
            "facebook_rx_auto_post.user_id", 
            "facebook_rx_auto_post.post_type", 
            "facebook_rx_auto_post.facebook_rx_fb_user_info_id", 
            "facebook_rx_auto_post.campaign_name",
            "facebook_rx_auto_post.page_group_user_id", 
            "facebook_rx_auto_post.page_or_group_or_user",
            "facebook_rx_auto_post.page_or_group_or_user_name",
            "facebook_rx_auto_post.posting_status", 
            "facebook_rx_auto_post.post_url", 
            "facebook_rx_auto_post.schedule_time", 
            "facebook_rx_auto_post.error_mesage", 
            "facebook_rx_auto_post.is_child", 
            "facebook_rx_auto_post.parent_campaign_id", 
            "facebook_rx_auto_post.repeat_times", 
            "facebook_rx_auto_post.full_complete", 
            "facebook_rx_auto_post.schedule_type", 
            "facebook_rx_fb_page_info.page_id AS pageid",
            "facebook_rx_fb_group_info.group_id as groupid"
        );

        $join   = array('facebook_rx_fb_page_info'=>"facebook_rx_fb_page_info.id=facebook_rx_auto_post.page_group_user_id,left",'facebook_rx_fb_group_info'=>"facebook_rx_fb_group_info.id=facebook_rx_auto_post.page_group_user_id,left");

        $table = "facebook_rx_auto_post";
        $info = $this->basic->get_data($table,$where,$select,$join,$limit,$start,$order_by,$group_by='');
        $this->db->where("(is_child='0' or posting_status='2')");
        $total_rows_array=$this->basic->count_row($table,$where,$count=$table.".id",$join,$group_by='');
        $total_result=$total_rows_array[0]['total_rows'];

        $counted_info = count($info);

        for($i=0;$i<$counted_info;$i++)
        {   
            $action_count = 4;
            $posting_status = $info[$i]['posting_status'];
            $full_complete  = $info[$i]['full_complete'];
            $schedule_type  = $info[$i]['schedule_type'];
            $parent_id      = $info[$i]['parent_campaign_id'];
            $repeat_times   = $info[$i]['repeat_times'];

            // $allschedulepost_check = $this->basic->get_data("facebook_rx_auto_post", array('where'=>array('parent_campaign_id'=>$info[$i]['id'])));

            $total = $this->basic->get_data($table, 
                [
                    'where' => [
                        'parent_campaign_id' => $info[$i]['id'],
                        'schedule_type' => 'later',
                    ]
                ],
                [
                    'count(parent_campaign_id) as total'
                ]
            );

            $total = isset($total[0]['total']) ? $total[0]['total'] : 0;

            $completed = $this->basic->get_data($table, 
                [
                    'where' => [
                        'parent_campaign_id' => $info[$i]['id'],
                        'schedule_type' => 'later',
                        'posting_status' => '2',
                    ]
                ],
                [
                    'count(parent_campaign_id) as completed'
                ]
            );

            $completed = isset($completed[0]['completed']) ? $completed[0]['completed'] : 0;          

            if($total > 0)
            {
                if($total == $completed) $is_all_posted='1';
                else $is_all_posted='0';
            } else {
                if($posting_status=='2') $is_all_posted='1';
                else $is_all_posted='0';
            }
           
            // status section started
            if($posting_status == '2'  && ($schedule_type == 'later' && $parent_id == '0' && $is_all_posted=='0' )) {
                $completed = $completed+1;
                $total = $total+1;

                if ($completed == $total) {
                    $info[$i]['status'] = '<div class="min_width_120px text-success"><i class="fas fa-check-circle"></i> '.$this->lang->line("Completed").'</div>'; 
                } else {
                    $info[$i]['status'] = '<div class="min_width_120px text-muted"><i class="fas fa-exclamation-circle"></i> '.$completed. '/'. $total. ' '.$this->lang->line("completed").'</div>';
                }
            }
            else if( $posting_status == '2') 
                $info[$i]['status'] = '<div class="min_width_120px text-success"><i class="fas fa-check-circle"></i> '.$this->lang->line("Completed").'</div>';
            else if( $posting_status == '1') 
                $info[$i]['status'] = '<div class="min_width_120px text-warning"><i class="fas fa-spinner"></i> '.$this->lang->line("Processing").'</div>';
            else 
                $info[$i]['status'] = '<div class="min_width_120px text-danger"><i class="far fa-times-circle"></i> '.$this->lang->line("Pending").'</div>';
            // end of status section

            // campaign type started
            if($schedule_type == 'later' && $parent_id == '0') 
                $info[$i]['campaign_type'] = "<div class='min_width_120px'>".$this->lang->line("main campaign")."</div>";
            else if($schedule_type == 'now') 
                $info[$i]['campaign_type'] ="<div class='min_width_120px'>".$this->lang->line("single campaign")."</div>";
            else 
                $info[$i]['campaign_type'] = "<div class='min_width_120px'>".$this->lang->line("sub campaign")."</div>";
            // end of campaign type

            // post type started
            $post_type = $info[$i]['post_type'];
            $post_type = ucfirst(str_replace("_submit","",$post_type));
            if($post_type == 'Text') $info[$i]['post_type']  = '<div class="min_width_70px"><i class="fa fa-file-alt"></i> '.$this->lang->line("Text").'</div>';
            if($post_type == 'Image') $info[$i]['post_type'] = '<div class="min_width_70px"><i class="fa fa-image"></i> '.$this->lang->line("Image").'</div>';
            if($post_type == 'Video') $info[$i]['post_type'] = '<div class="min_width_70px"><i class="fa fa-video"></i> '.$this->lang->line("Video").'</div>';
            if($post_type == 'Link') $info[$i]['post_type']  = '<div class="min_width_70px"><i class="fa fa-link"></i> '.$this->lang->line("Link").'</div>';
            // post type ended


            // publisher started 
            $publisher = "<div class='min_width_120px'> <a target='_BLANK' data-toggle='tooltip' title='".$this->lang->line("Visit Account")."' href='https://www.instagram.com/".$info[$i]['page_or_group_or_user_name']."'>".$info[$i]['page_or_group_or_user_name']."</a></div>";
            

            $info[$i]['publisher'] = $publisher;
            // publisher ended

            if($info[$i]['schedule_time'] != "0000-00-00 00:00:00")
                $info[$i]['schedule_time'] = "<div class='min_width_70px'>".date("M j, y H:i",strtotime($info[$i]['schedule_time']))."</div>";
            else 
                $info[$i]['schedule_time'] = "<div class='min_width_70px text-muted'><i class='fas fa-exclamation-circle'></i> ".$this->lang->line('Not Scheduled')."</div>";

            $info[$i]['delete'] =  "<a data-toggle='tooltip' title='".$this->lang->line("Delete this post from our database")."' id='".$info[$i]['id']."' class='btn btn-circle btn-outline-danger delete'><i class='fas fa-trash-alt'></i></a>";


            // visit post action
            if ($posting_status == '2'  && ($schedule_type == 'later' && $parent_id == '0' && $is_all_posted=='0' )) {
                $visit_post = "<a data-toggle='tooltip' title='".$this->lang->line("not published yet.")."' class='btn btn-circle btn-light pointer text-muted'><i class='fas fa-hand-point-right'></i></a>";
            }
            else if($posting_status=='2') {
                $visit_post = "<a target='_BLANK' href='".$info[$i]['post_url']."' data-toggle='tooltip' title='".$this->lang->line("Visit Post")."' class='btn btn-circle btn-outline-info'><i class='fas fa-hand-point-right'></i></a>";
            }
            else {
                $visit_post = "<a data-toggle='tooltip' title='".$this->lang->line("not published yet.")."' class='btn btn-circle btn-light pointer text-muted'><i class='fas fa-hand-point-right'></i></a>";
            }

            // view report action
            if ($schedule_type == 'later' && $parent_id == '0')
                $see_report = '<a data-toggle="tooltip" title="'.$this->lang->line("Campaign Report").'" class="btn btn-circle btn-outline-primary view_report" table_id="'.$info[$i]['id'].'" href="#"><i class="fas fa-eye"></i></a>';
            else
                $see_report = '<a class="btn btn-circle btn-light pointer text-muted" data-toggle="tooltip" title="'.$this->lang->line('Only parent campaign has shown report').'"><i class="fas fa-eye"></i></a>';

            // edit campaign action
            if(($posting_status=='0' || $posting_status == '2')  && ($schedule_type == 'later' && $parent_id == '0' && $is_all_posted=='0'))
                $editPost ="<a class='btn btn-circle btn-outline-warning' href='".base_url()."instagram_poster/image_video_edit_auto_post/".$info[$i]['id']."' data-toggle='tooltip' title='".$this->lang->line('Edit Campaign')."'><i class='fas fa-edit'></i></a>";
            else 
                $editPost ="<a class='btn btn-circle btn-light pointer text-muted' data-toggle='tooltip' title='".$this->lang->line("Only pending and scheduled campaigns are editable")."'><i class='fas fa-edit'></i></a>";

            // delete campaign action
            if($schedule_type == 'later' && $parent_id == '0')
                $deletePost ='<a class="btn btn-circle btn-outline-danger delete_p" data-toggle="tooltip" title="'.$this->lang->line("Delete Campaign").'" id="'.$info[$i]['id'].'" href="#"><i class="fas fa-trash-alt"></i></a>';
            else
                $deletePost ='<a class="btn btn-circle btn-outline-danger delete" data-toggle="tooltip" title="'.$this->lang->line("Delete Campaign").'" id="'.$info[$i]['id'].'" href="#"><i class="fas fa-trash-alt"></i></a>';

            // Action section started from here
            $action_width = ($action_count*47)+20;
            $info[$i]['actions'] = '<div class="dropdown d-inline dropright">
            <button class="btn btn-outline-primary dropdown-toggle no_caret" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-briefcase"></i></button>
            <div class="dropdown-menu mini_dropdown text-center" style="width:'.$action_width.'px !important">';

            $info[$i]['actions'] .= $visit_post;
            $info[$i]['actions'] .= $see_report;
            $info[$i]['actions'] .= $editPost;
            $info[$i]['actions'] .= $deletePost;

            $info[$i]['actions'] .= "</div></div><script src='".base_url()."assets/js/system/tooltip_popover.js'></script>";
        }

        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");

        echo json_encode($data);
    }

    public function image_video_poster()
    {
        $this->is_group_posting_exist=$this->group_posting_exist();
        if($this->session->userdata('user_type') != 'Admin' && !in_array(296,$this->module_access)) exit();

        $data['page_title'] = $this->lang->line("Image/Video Post");
        $data['body'] = 'image_video_post/add_auto_post';
        $data["time_interval"] = $this->get_periodic_time();
        $data["time_zone"]= $this->_time_zone_list();

        $user_infos = $this->basic->get_data("facebook_rx_fb_user_info",array("where"=>array("user_id"=>$this->user_id,"id"=>$this->session->userdata("facebook_rx_fb_user_info"))));

        if ( count( $user_infos ) == 0 ) 
            return redirect( base_url( 'social_accounts/index' ), 'location' );

        $data["fb_user_info"] = $user_infos;

        $table = "facebook_rx_fb_page_info";
        $where = [];
        if($this->config->item('facebook_poster_botenabled_pages') == '1')
        $where['where'] = ['user_id'=>$this->user_id,"bot_enabled"=>"1","has_instagram"=>"1","facebook_rx_fb_user_info_id"=>$this->session->userdata("facebook_rx_fb_user_info")];
        else
        $where['where'] = ['user_id'=>$this->user_id,"has_instagram"=>"1","facebook_rx_fb_user_info_id"=>$this->session->userdata("facebook_rx_fb_user_info")];
        $select = ['id','page_profile','insta_username','instagram_business_account_id'];
        $data['account_list'] = $this->basic->get_data($table,$where,$select);

        $app_info=$this->basic->get_data("facebook_rx_config",array("where"=>array("id"=>$this->session->userdata("fb_rx_login_database_id"))));
        $data["app_info"] = $app_info;

        $this->load->library('fb_rx_login');
        $this->fb_rx_login->app_initialize($this->session->userdata("fb_rx_login_database_id"));
        $app_id = isset($app_info[0]['api_id']) ? $app_info[0]['api_id'] : 0;
        $app_secret = isset($app_info[0]['api_secret']) ? $app_info[0]['api_secret'] : 0;
        $current_app_info = $this->fb_rx_login->app_info_graber($app_id,$app_secret);
        $data['current_app_name'] = isset($current_app_info['name']) ? $current_app_info['name'] : "";
        $data['current_app_link'] = isset($current_app_info['link']) ? $current_app_info['link'] : "";
        $data['current_app_photo_url'] = isset($current_app_info['photo_url']) ? $current_app_info['photo_url'] : "";
        $output_dir = FCPATH."upload_caster/image_video";
        $output_dir = $output_dir.'/'.$this->user_id;
        if(!file_exists($output_dir)) {
            mkdir($output_dir,0777);
        }
        $files=$this->_scanAll($output_dir);
        rsort($files);
        $data['files']=$files;
        $this->_viewcontroller($data);
    }

    public function image_video_delete_post()
    {
       if($this->session->userdata('user_type') != 'Admin' && !in_array(296,$this->module_access)) exit();
       if(!$_POST) exit();
       $id=$this->input->post("id");
       $post_info = $this->basic->get_data('facebook_rx_auto_post',array('where'=>array('id'=>$id)));
       if($post_info[0]['posting_status'] != '2')
       {
           //******************************//
           // delete data to useges log table
           $this->_delete_usage_log($module_id=296,$request=1);
           //******************************//
       }

       if($this->basic->delete_data("facebook_rx_auto_post",array("id"=>$id,"user_id"=>$this->user_id)))
       {
           $subcampaigns = $this->basic->get_data('facebook_rx_auto_post',['where'=>["parent_campaign_id"=>$id,"user_id"=>$this->user_id]]);
           $subcampaigns_count = count($subcampaigns);
           $this->basic->delete_data("facebook_rx_auto_post",array("parent_campaign_id"=>$id,"user_id"=>$this->user_id));
           $this->_delete_usage_log($module_id=296,$request=$subcampaigns_count);
           echo "1";
       }
       else echo "0";
    }

    public function image_video_get_embed_code()
    {
        if($this->session->userdata('user_type') != 'Admin' && !in_array(296,$this->module_access)) exit();
        if(!$_POST) exit();
        $id=$this->input->post("id");

        $video_data = $this->basic->get_data("facebook_rx_auto_post",array("where"=>array("id"=>$id,"user_id"=>$this->user_id)));
        $post_url= isset($video_data[0]['post_url']) ? $video_data[0]['post_url']:"";

       $embed_code = '&lt;iframe src="https://www.facebook.com/plugins/video.php?href='.$post_url.'&show_text=0&width=600" width="600" height="600" class="overflow-hidden border-0" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"&gt;&lt;/iframe&gt;';
       $preview = '<iframe src="https://www.facebook.com/plugins/video.php?href='.$post_url.'&show_text=0&width=600" width="600" height="600" class="overflow-hidden border-0" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>';

        $embed_html1 = '
        <div class="card">
            <div class="card-body">
                <pre class="language-javascript"><code class="dlanguage-javascript copy_code">'.$embed_code.'</code></pre><br>
                <center>'.$preview.'</center>
            </div>
        </div>';

        $embed_html1 .= '<script src="'.base_url().'assets/js/system/instagram/posting_embed_code.js"></script>';

        echo $embed_html1;
    }

    public function image_video_add_auto_post_action()
    {
        if($this->session->userdata('user_type') != 'Admin' && !in_array(296,$this->module_access)) exit();
        if(!$_POST) exit();

        $this->load->library("fb_rx_login");

        $post=$_POST;
        foreach ($post as $key => $value)
        {
            if(!is_array($value))
                $temp = strip_tags($value);
            else
                $temp = $value;

            $$key=$this->security->xss_clean($temp);

           if(!is_array($value)){
               $value = strip_tags($value);
               $value = $this->security->xss_clean($value);

                if($key == "auto_reply_template")
                    $insert_data['ultrapost_auto_reply_table_id'] = $value;
                else
                    $insert_data[$key]=$value;
           }
        }

        $image_list = explode(',', $image_url);

        $insert_data["post_type"] = $insert_data["submit_post_hidden"];
        unset($insert_data["submit_post_hidden"]);
        unset($insert_data["post_to_profile"]);

        $schedule_type = $this->input->post('schedule_type',true);
        
        if($schedule_type == '')
            $insert_data["schedule_type"] = 'later';
        else
            $insert_data["schedule_type"] = 'now';

        //************************************************//
        $request_count1 = 0;
        $request_count = 0;
        if(isset($post_to_pages))
        $request_count1 = count($post_to_pages);
        $times = 0;
        $times = $repeat_times;
        $request_count = $request_count1;
        if($times != '' && $times != 0)
            $request_count = $request_count*$times;

        $interval= $time_interval; 
        $status=$this->_check_usage($module_id=296,$request=$request_count);
        if($status=="2")
        {
            $error_msg = $this->lang->line("sorry, your bulk limit is exceeded for this module.")."<a href='".site_url('payment/usage_history')."'>".$this->lang->line("click here to see usage log")."</a>";
            $return_val=array("status"=>"0","message"=>$error_msg);
            echo json_encode($return_val);
            exit();
        }
        else if($status=="3")
        {
            $error_msg = $this->lang->line("sorry, your monthly limit is exceeded for this module.")."<a href='".site_url('payment/usage_history')."'>".$this->lang->line("click here to see usage log")."</a>";
            $return_val=array("status"=>"0","message"=>$error_msg);
            echo json_encode($return_val);
            exit();
        }
        //************************************************//

        $insert_data["auto_share_to_profile"]= "0";
        $insert_data["user_id"] = $this->user_id;
        $insert_data["facebook_rx_fb_user_info_id"] = $this->session->userdata("facebook_rx_fb_user_info");

        
        if(!isset($post_to_pages) || !is_array($post_to_pages)) $post_to_pages=array();
        if(!isset($post_to_groups) || !is_array($post_to_groups)) $post_to_groups=array();

        $page_ids_string = implode(',', $post_to_pages);
        $insert_data["page_ids"] = $page_ids_string;

        $auto_share_this_post_by_pages = array();
        $auto_share_this_post_by_pages_new = array_diff($auto_share_this_post_by_pages,$post_to_pages);
        $insert_data["auto_share_this_post_by_pages"] = json_encode($auto_share_this_post_by_pages_new);

        $insert_data["auto_private_reply_status"] = "0";
        $insert_data["auto_private_reply_count"] = 0;
        $insert_data["auto_private_reply_done_ids"] = json_encode(array());

        // $insert_data['repeat_times'] = $times;
        $insert_data['time_interval'] = $interval;
        $insert_data["post_auto_comment_cron_jon_status"] = "0";
        $insert_data["post_auto_like_cron_jon_status"] = "0";
        $insert_data["post_auto_share_cron_jon_status"] = "0";

        $insert_data["media_type"] = "instagram";
        

        if($video_url!="")
        {
            if(strpos($video_url, 'youtube.com') !== false)
            {
                parse_str( parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
                $youtube_video_id = isset($my_array_of_vars['v']) ? $my_array_of_vars['v'] : "";

                if($youtube_video_id!="")
                {
                    $video_url = $this->fb_rx_login->get_youtube_video_url($youtube_video_id);
                    $insert_data["video_url"] = $video_url;
                }
            }
        }


        if($schedule_type=="now")
        {
            $insert_data["posting_status"] ='2';
            $insert_data["full_complete"]  ='1';
        }
        else
        {
            $insert_data["posting_status"] ='0';
    
        }

        $insert_data_batch=array();

        $user_id_array = array($this->user_id);
        $account_switching_id = $this->session->userdata("facebook_rx_fb_user_info"); // table > facebook_rx_fb_user_info.id
        $count=0;

        $user_infos = $this->basic->get_data("facebook_rx_fb_user_info",array("where"=>array("user_id"=>$this->user_id,"id"=>$this->session->userdata("facebook_rx_fb_user_info"))));
        $user_access_token = isset($user_infos[0]['access_token']) ? $user_infos[0]['access_token'] : '';


        $page_info = $this->basic->get_data("facebook_rx_fb_page_info",array("where"=>array("user_id"=>$this->user_id,"facebook_rx_fb_user_info_id"=>$account_switching_id)));

        foreach ($page_info as $key => $value)
        {
            if(!in_array($value["id"], $post_to_pages)) continue;

            $page_access_token =  isset($value["page_access_token"]) ? $value["page_access_token"] : "";
            $fb_page_id =  isset($value["page_id"]) ? $value["page_id"] : "";

            $insert_data_batch[$count]=$insert_data;

            $page_auto_id =  isset($value["id"]) ? $value["id"] : "";
            $instagram_business_account_id =  isset($value["instagram_business_account_id"]) ? $value["instagram_business_account_id"] : "";
            $insert_data_batch[$count]["page_group_user_id"]=$page_auto_id;
            $insert_data_batch[$count]["page_or_group_or_user"]="page";
            $insert_data_batch[$count]["page_or_group_or_user_name"] = isset($value["insta_username"]) ? $value["insta_username"] : "";
            $insert_data_batch[$count]["post_id"] = "";
            $insert_data_batch[$count]["post_url"] = "";

            if($schedule_type=="now")
            {
                if($this->is_demo == '1')
                    if($this->user_id == 1)
                        continue;
                
                if($submit_post_hidden=="image_submit")
                {

                    if(count($image_list) == 1)
                    {               
                        $message=spintax_process($message);
                        $response = $this->fb_rx_login->instagram_create_post($instagram_business_account_id,$type="IMAGE",$image_list[0],$message,$user_access_token);
                        if(isset($response['status']) && $response['status']=="error"){
                            $report['status'] = 'error';
                            $report['message'] = $response['message'];
                            echo json_encode($report);
                            exit();
                        }
                    }


                }

                else
                {
                    $message=spintax_process($message);
                    $response = $this->fb_rx_login->instagram_create_post($instagram_business_account_id,$type="VIDEO",$video_url,$message,$user_access_token);
                    if(isset($response['status']) && $response['status']=="error"){
                        $report['status'] = 'error';
                        $report['message'] = $response['message'];
                        echo json_encode($report);
                        exit();
                    }

                    $insert_data_batch[$count]["post_auto_comment_cron_jon_status"] = "0";
                    $insert_data_batch[$count]["post_auto_like_cron_jon_status"] = "0";
                    $insert_data_batch[$count]["post_auto_share_cron_jon_status"] = "0";
                }

                $object_id=isset($response["id"]) ? $response["id"] : "";

                $insert_data_batch[$count]["post_id"]= $object_id;
                $temp_data=$this->fb_rx_login->instagram_get_post_info_by_id($object_id,$user_access_token);

                $insert_data_batch[$count]["post_url"]= isset($temp_data["permalink"]) ? $temp_data["permalink"] : "";
                $insert_data_batch[$count]["last_updated_at"]= date("Y-m-d H:i:s");


                $this->basic->insert_data("facebook_rx_auto_post",$insert_data_batch[$count]);

            }

            $count++;

        }


        $profile_info = $this->basic->get_data("facebook_rx_fb_user_info",array("where"=>array("id"=> $account_switching_id,"user_id"=>$this->user_id)));
        $user_access_token =  isset($profile_info[0]["access_token"]) ? $profile_info[0]["access_token"] : "";
        $user_fb_id =  isset($profile_info[0]["fb_id"]) ? $profile_info[0]["fb_id"] : "";
        $user_fb_name =  isset($profile_info[0]["name"]) ? $profile_info[0]["name"] : "";     

       if($schedule_type=="now") $return_val=array("status"=>"1","message"=>$this->lang->line("Instagram post has been performed successfully."));
       

       else
       {
           
            $page_info_arr = array();
            $page_info = $this->basic->get_data("facebook_rx_fb_page_info",array("where"=>array("user_id"=>$this->user_id,"facebook_rx_fb_user_info_id"=>$account_switching_id)));

            foreach ($page_info as $key => $value) {
               if(!in_array($value["id"], $post_to_pages)) continue;
               $page_info_arr[$value["id"]] = $value['insta_username'];
            }

            $parent_id='';
            for ($insert_counter=0; $insert_counter < $request_count1; $insert_counter++) { 

               $insert_data['page_or_group_or_user'] = 'page';
               $insert_data['page_group_user_id'] = $post['post_to_pages'][$insert_counter];
               $insert_data['page_or_group_or_user_name'] = $page_info_arr[$insert_data['page_group_user_id']];

               $x=$post['time_interval'];
               if($x=="" || $x==0){
               	$x=rand(15,100);
               }

               for ($i=0; $i <= $times ; $i++) { 
                   
                    if($i == 0)
                    {
                        $insert_data['schedule_time']= $post['schedule_time'];
                        $this->basic->insert_data('facebook_rx_auto_post',$insert_data);
                        $insert_id = $this->db->insert_id();
                        if($i == 0 && $insert_counter == 0)
                            $parent_id = $insert_id;
                    }
                    if ($times == 0) {
                          $insert_data['is_child'] = '1';
                          $insert_data['parent_campaign_id'] = $parent_id;
                    
                    }

                    if($i >= 1)
                    {

                        $insert_data['is_child'] = '1';
                        $current_schedule_time = $post['schedule_time'];
                        $dateTime = new DateTime($current_schedule_time);
                        $p = $i*$x;
                        $dateTime->modify("+{$p} minutes");
                        $insert_data['parent_campaign_id'] = $parent_id;
                        $change_time= $dateTime->format('Y-m-d H:i:s');
                        $insert_data['schedule_time']= $change_time;
                         unset($insert_data['page_ids']);
                         unset($insert_data['group_ids']);
                        $this->basic->insert_data('facebook_rx_auto_post',$insert_data);
                    }
               }

            }
            

            if($insert_counter > 0)
            {
                $number_request = count($insert_data_batch);
                $this->_insert_usage_log($module_id=296,$request=$number_request);
                $return_val=array("status"=>"1","message"=>$this->lang->line("Instagram post campaign has been created successfully."));
            }
            else $return_val=array("status"=>"0","message"=>$this->lang->line("something went wrong, please try again."));
       }

       echo json_encode($return_val);
    }

    public function ajax_get_text_report()
    {
        if($this->session->userdata('user_type') != 'Admin' && !in_array(296,$this->module_access)) exit();
        $this->ajax_check();

        $table_id = $this->input->post('table_id');
        $searching = $this->input->post('searching1',true);
        
        $display_columns = array("#",'id','page_or_group_or_user_name','post_type','post_id','posting_status','schedule_time','error_mesage');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'id';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
        $order_by=$sort." ".$order;

        $where = array();
        $where_simple=array();

        if($searching == '')
        {
            $where_simple['parent_campaign_id'] = $table_id;
            $or_where['id'] = $table_id;
            $where  = array('where'=>$where_simple,'or_where'=>$or_where);
        }

        $sql = '';
        if ($searching != '') 
        {
            $sql = "(schedule_time LIKE  '%".$searching."%' OR post_id LIKE '%".$searching."%') AND (`parent_campaign_id` = '$table_id' OR `id` = '$table_id')";
        }
        if($sql != '') $this->db->where($sql);

        
        $table = "facebook_rx_auto_post";
        $info = $this->basic->get_data('facebook_rx_auto_post',$where,$select='',$join='',$limit,$start,$order_by,$group_by='');

        $total_rows_array=$this->basic->count_row($table,$where,$count="id",$join='',$group_by='');
        $total_result=$total_rows_array[0]['total_rows'];

        for($i=0;$i<count($info);$i++)
        {   
            $posting_status = $info[$i]['posting_status'];
            $schedule_type  = $info[$i]['schedule_type'];
            $post_id = $info[$i]['post_id'];
            $post_url = $info[$i]['post_url'];

            if($post_id != '')
                $info[$i]['post_id'] = "<a target='_BLANK' href='".$post_url."'>".$post_id."</a>";
            
            // status section started
            if($posting_status=='2')
                $posting_status='<span class="text-success"><i class="fas fa-check-circle"></i> '.$this->lang->line("completed").'</span>';
            if($posting_status == '0')
                $posting_status='<span class="text-danger"><i class="far fa-times-circle"></i> '.$this->lang->line("pending").'</span>';
            if($posting_status == '1')
                $posting_status='<span class="text-warning"><i class="fas fa-spinner"></i> '.$this->lang->line("processing").'</span>';

            $info[$i]['posting_status'] = $posting_status;
            // end of status section

            // post type started
            $post_type = $info[$i]['post_type'];
            $post_type = ucfirst(str_replace("_submit","",$post_type));
            if($post_type == 'Text') $info[$i]['post_type']  = '<i class="fa fa-file-alt"></i> '.$this->lang->line("Text");
            if($post_type == 'Image') $info[$i]['post_type'] = '<i class="fa fa-image"></i> '.$this->lang->line("Image");
            if($post_type == 'Video') $info[$i]['post_type'] = '<i class="fa fa-video"></i> '.$this->lang->line("Video");
            if($post_type == 'Link') $info[$i]['post_type']  = '<i class="fa fa-link"></i> '.$this->lang->line("Link");
            // post type ended


            // publisher started 
            $info[$i]['page_or_group_or_user_name'] = $info[$i]['page_or_group_or_user_name'];
            // publisher ended

            if($info[$i]['schedule_time'] != "0000-00-00 00:00:00")
                $info[$i]['schedule_time'] = "<div class='min_width_100px'>".date("M j, y H:i",strtotime($info[$i]['schedule_time']))."</div>";
            else 
                $info[$i]['schedule_time'] ='<div class="min_width_100px"><i class="far fa-exclamation-circle" title="'.$this->lang->line("Instantly posted").'"></i>'.$this->lang->line('Not Scheduled')."</div>";

        }

        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");

        echo json_encode($data);
    }    


    public function get_fb_rx_config($fb_user_id=0)
    {
        if($fb_user_id==0) return 0;

        $getdata= $this->basic->get_data("facebook_rx_fb_user_info",array("where"=>array("id"=>$fb_user_id)),array("facebook_rx_config_id"));
        $return_val = isset($getdata[0]["facebook_rx_config_id"]) ? $getdata[0]["facebook_rx_config_id"] : 0;

        return $return_val;
    }

    public function image_video_edit_auto_post($auto_post_id)
    {
        $this->is_group_posting_exist=$this->group_posting_exist();
        if($this->session->userdata('user_type') != 'Admin' && !in_array(296,$this->module_access)) exit();
        
        $table2 = "facebook_rx_auto_post";
        $where5656  = array('where'=>array('id'=>$auto_post_id));

        $allschedulepost_check = $this->basic->get_data($table2,$where5656);

        foreach ($allschedulepost_check as $key => $value12) {
            if ($value12['posting_status'] == '2')
            {
                 $data['is_all_posted'] = 1; 
            }
            else
            {
                $data['is_all_posted'] =0;
            }
          
        }
     
        $data['body'] = 'image_video_post/edit_auto_post';
        $data['page_title'] = $this->lang->line('Update Image/Video Post');
        $data["time_zone"]= $this->_time_zone_list();
        $data["time_interval"] = $this->get_periodic_time();
        $data["fb_user_info"]=$this->basic->get_data("facebook_rx_fb_user_info",array("where"=>array("user_id"=>$this->user_id,"id"=>$this->session->userdata("facebook_rx_fb_user_info"))));

        $table = "facebook_rx_fb_page_info";
        $where = [];
        if($this->config->item('facebook_poster_botenabled_pages') == '1')
        $where['where'] = ['user_id'=>$this->user_id,"bot_enabled"=>"1","has_instagram"=>"1","facebook_rx_fb_user_info_id"=>$this->session->userdata("facebook_rx_fb_user_info")];
        else
        $where['where'] = ['user_id'=>$this->user_id,"has_instagram"=>"1","facebook_rx_fb_user_info_id"=>$this->session->userdata("facebook_rx_fb_user_info")];
        $select = ['id','page_profile','insta_username','instagram_business_account_id'];
        $data['account_list'] = $this->basic->get_data($table,$where,$select);

        $app_info=$this->basic->get_data("facebook_rx_config",array("where"=>array("id"=>$this->session->userdata("fb_rx_login_database_id"))));
        $data["app_info"] = $app_info;

        $data["all_data"] = $this->basic->get_data("facebook_rx_auto_post",array("where"=>array("id"=>$auto_post_id)));
        
        $this->load->library('fb_rx_login');
        $this->fb_rx_login->app_initialize($this->session->userdata("fb_rx_login_database_id"));
        $app_id = isset($app_info[0]['api_id']) ? $app_info[0]['api_id'] : 0;
        $app_secret = isset($app_info[0]['api_secret']) ? $app_info[0]['api_secret'] : 0;
        $current_app_info = $this->fb_rx_login->app_info_graber($app_id,$app_secret);
        $data['current_app_name'] = isset($current_app_info['name']) ? $current_app_info['name'] : "";
        $data['current_app_link'] = isset($current_app_info['link']) ? $current_app_info['link'] : "";
        $data['current_app_photo_url'] = isset($current_app_info['photo_url']) ? $current_app_info['photo_url'] : "";
        $output_dir = FCPATH."upload_caster/image_video";
        $output_dir = $output_dir.'/'.$this->user_id;
        if(!file_exists($output_dir)) {
            mkdir($output_dir,0777);
        }
        $files=$this->_scanAll($output_dir);
        rsort($files);
        $data['files']=$files;
        $this->_viewcontroller($data);
    }

    public function image_video_edit_auto_post_action()
    {
        if($this->session->userdata('user_type') != 'Admin' && !in_array(296,$this->module_access)) exit();
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            redirect('home/access_forbidden', 'location');
        }

        if ($_POST)
        {
            $this->form_validation->set_rules('id',                             '<b>id</b>',                            'trim|required');
            $this->form_validation->set_rules('user_id',                        '<b>user_id</b>',                       'trim|required');
            $this->form_validation->set_rules('facebook_rx_fb_user_info_id',    '<b>facebook_rx_fb_user_info_id</b>',   'trim|required');
            $this->form_validation->set_rules('campaign_name',          '<b>Campaign Name</b>',     'trim');
            $this->form_validation->set_rules('message',                '<b>Message</b>',           'trim');
            $this->form_validation->set_rules('image_url',              '<b>Image Url</b>',  'trim');
            $this->form_validation->set_rules('video_url',              '<b>Video Url</b>',  'trim');
            $this->form_validation->set_rules('schedule_type',          '<b>schedule type</b>',  'trim');
            $this->form_validation->set_rules('schedule_time',          '<b>schedule time</b>',  'trim');
            $this->form_validation->set_rules('time_zone',              '<b>time zone</b>',  'trim');
            $this->form_validation->set_rules('submit_post_hidden',     '<b>submit post hidden</b>',  'trim');

            if($this->form_validation->run() == false)
            {
                return $this->edit_auto_post($_POST['id']);
            }
            $times = 0;
            $id                         = $this->input->post('id', true);
            $user_id                    = $this->input->post('user_id', true);
            $facebook_rx_fb_user_info_id= $this->input->post('facebook_rx_fb_user_info_id', true);
            $campaign_name              = strip_tags($this->input->post('campaign_name', true));
            $message                    = $this->input->post('message', true);
            $image_url                  = $this->input->post('image_url', true);
            $video_url                  = $this->input->post('video_url', true);
            $schedule_type              = $this->input->post('schedule_type', true);
            $schedule_time              = $this->input->post('schedule_time', true);
            $time_zone                  = $this->input->post('time_zone', true);
            $submit_post_hidden         = $this->input->post('submit_post_hidden', true);
            $times                      = $this->input->post('repeat_times', true);
            $interval                   = $this->input->post('time_interval', true);
            

            $post_to_pages = array();
            $post_to_groups = array();
            if($this->input->post('post_to_pages', true) !== null)
                $post_to_pages = $this->input->post('post_to_pages', true);
            if($this->input->post('post_to_groups', true) !== null)
                $post_to_groups = $this->input->post('post_to_groups', true);


            $request_count1 = 0;
            $request_count2 = 0;
            $request_count = 0;
            if(isset($post_to_pages))
            $request_count1 = count($post_to_pages);
            if(isset($post_to_groups))
            $request_count2 = count($post_to_groups);
            $request_count = $request_count1+$request_count2;

            $data = array(
                'user_id'                       => $user_id,
                'facebook_rx_fb_user_info_id'   => $facebook_rx_fb_user_info_id,
                'campaign_name'                 => $campaign_name,
                'message'                       => $message,
                'image_url'                     => $image_url,
                'video_url'                     => $video_url,
                'schedule_time'                 => $schedule_time,
                'time_zone'                     => $time_zone,
                'post_type'                     => $submit_post_hidden,
                'repeat_times'                  => $times,
                'time_interval'                 => $interval,
                'schedule_type'                 => $schedule_type
            );            
            $data["posting_status"] ='0';

            $this->basic->delete_data('facebook_rx_auto_post',array('id'=>$id,'user_id'=>$this->user_id));
            $this->basic->delete_data('facebook_rx_auto_post',array('parent_campaign_id'=>$id,'full_complete'=>'0' ,'user_id'=>$this->user_id));

            $data['media_type'] = 'instagram';

            $account_switching_id = $this->session->userdata("facebook_rx_fb_user_info");
            $user_id_array=array($this->user_id);
   
                $page_info_arr = array();
                $page_info = $this->basic->get_data("facebook_rx_fb_page_info",array("where"=>array("user_id"=>$this->user_id,"facebook_rx_fb_user_info_id"=>$account_switching_id)));

                foreach ($page_info as $key => $value) {
                   if(!in_array($value["id"], $post_to_pages)) continue;
                   $page_info_arr[$value["id"]] = $value['insta_username'];
                }

                $parent_id='';
                for ($insert_counter=0; $insert_counter < $request_count1; $insert_counter++) { 

                   $data['page_or_group_or_user'] = 'page';
                   $data['page_group_user_id'] = $post_to_pages[$insert_counter];
                   $data["page_ids"] = implode(',', $post_to_pages);
                   $data['page_or_group_or_user_name'] = $page_info_arr[$data['page_group_user_id']];

                 $x=$interval;

                 if($x=="" || $x==0){
	               	$x=rand(15,100);
	               }

                   for ($i=0; $i <=$times ; $i++) { 
                       
                        if($i == 0)
                        {
                            $data['schedule_time']= $schedule_time;
                            $this->basic->insert_data('facebook_rx_auto_post',$data);
                            $insert_id = $this->db->insert_id();
                            if($i == 0 && $insert_counter == 0)
                                $parent_id = $insert_id;
                                
                           

                        }

                        if ($times == 0) {
                              $data['is_child'] = '1';
                              $data['parent_campaign_id'] = $parent_id;
                        
                        }

                        if($i >= 1)
                        {
                            $data['is_child'] = '1';
                            $current_schedule_time = $schedule_time;
                            $dateTime = new DateTime($current_schedule_time);
                            $p = $i*$x;
                            $dateTime->modify("+{$p} minutes");
                            $data['parent_campaign_id'] = $parent_id;
                            $change_time= $dateTime->format('Y-m-d H:i:s');
                            $data['schedule_time']= $change_time;
                            $data["page_ids"];
                            $this->basic->insert_data('facebook_rx_auto_post',$data);
                        }
                   }

                }
  
            if($insert_counter > 0)
            $return_val=array("status"=>"1","message"=>$this->lang->line('Facebook post information has been updated successfully.')); 
            else $return_val=array("status"=>"0","message"=>$this->lang->line("something went wrong, please try again."));

            echo json_encode($return_val);
        }
    }

    public function image_video_meta_info_grabber()
    {
        if($_POST)
        {
            $link= $this->input->post("link");
            $this->load->library("fb_rx_login");
            $response=$this->fb_rx_login->get_meta_tag_fb($link);
            echo json_encode($response);
        }
    }

    public function image_video_youtube_video_grabber()
    {
        if(!$_POST) exit();
        $this->load->library("fb_rx_login");
        $video_url = $this->input->post("link");

        if($video_url!="")
        {
            if(strpos($video_url, 'youtube.com') !== false)
            {
                parse_str( parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
                $youtube_video_id = isset($my_array_of_vars['v']) ? $my_array_of_vars['v'] : "";

                if($youtube_video_id!="")
                {
                    echo $video_url = $this->fb_rx_login->get_youtube_video_url($youtube_video_id);
                    exit();
                }
            }
            else
            {
                echo $video_url;
                exit();
            }
        }
        else echo "";
    }

    public function image_video_upload_video()
    {
        $this->ajax_check();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') exit();

        $ret=array();
        $output_dir = FCPATH."upload_caster/image_video";
        $output_dir = $output_dir.'/'.$this->user_id.'/';
        if (isset($_FILES["myfile"])) {
            $error =$_FILES["myfile"]["error"];
            $post_fileName =$_FILES["myfile"]["name"];
            $post_fileName_array=explode(".", $post_fileName);
            $ext=array_pop($post_fileName_array);
            $filename=implode('.', $post_fileName_array);
            $filename="video_".$this->user_id."_".time().substr(uniqid(mt_rand(), true), 0, 6).".".$ext;

            $allow=".mov,.mp4";
            $allow=str_replace('.', '', $allow);
            $allow=explode(',', $allow);
            if(!in_array(strtolower($ext), $allow)) 
            {
                $custom_error['jquery-upload-file-error']="Only MOV or MP4 format is supported.";
                echo json_encode($custom_error);
                exit();
            }
            
            move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir.'/'.$filename);
            $ret[]= $filename;
            echo json_encode($filename);
        }
    }



    public function image_video_upload_image_only()
    {
        $this->ajax_check();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') exit();

        $ret=array();
        $output_dir = FCPATH."upload_caster/image_video";
        $output_dir = $output_dir.'/'.$this->user_id.'/';
        if (isset($_FILES["myfile"])) {
            $error =$_FILES["myfile"]["error"];
            $post_fileName =$_FILES["myfile"]["name"];
            $post_fileName_array=explode(".", $post_fileName);
            $ext=array_pop($post_fileName_array);
            $filename=implode('.', $post_fileName_array);
            $filename="image_".$this->user_id."_".time().substr(uniqid(mt_rand(), true), 0, 6).".".$ext;

            $allow=".jpg,.jpeg";
            $allow=str_replace('.', '', $allow);
            $allow=explode(',', $allow);
            if(!in_array(strtolower($ext), $allow)) 
            {
                $custom_error['jquery-upload-file-error']="JPEG is the only image format supported. Extended JPEG formats such as MPO and JPS are not supported.";
                echo json_encode($custom_error);
                exit();
            }

            
            move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir.'/'.$filename);
            $ret[]= $filename;
            echo json_encode($filename);
        }
    }

    public function image_video_upload_link_preview()
    {
        $this->ajax_check();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') exit();

        $ret=array();
        $output_dir = FCPATH."upload_caster/image_video";
        $output_dir = $output_dir.'/'.$this->user_id.'/';
        if (isset($_FILES["myfile"])) {
            $error =$_FILES["myfile"]["error"];
            $post_fileName =$_FILES["myfile"]["name"];
            $post_fileName_array=explode(".", $post_fileName);
            $ext=array_pop($post_fileName_array);
            $filename=implode('.', $post_fileName_array);
            $filename="imagethumb_".$this->user_id."_".time().substr(uniqid(mt_rand(), true), 0, 6).".".$ext;
            move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir.'/'.$filename);
            $ret[]= $filename;
            echo json_encode($filename);
        }
    }

    public function image_video_delete_uploaded_file() // deletes the uploaded video to upload another one
    {
        $this->ajax_check();
        if(!$_POST) exit();

        $output_dir = FCPATH."upload_caster/image_video/";
        $output_dir = $output_dir.'/'.$this->user_id.'/';
        if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
        {
             $fileName =$_POST['name'];
             $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
             $filePath = $output_dir. $fileName;
             if (file_exists($filePath))
             {
                unlink($filePath);
             }
        }
    }

    public function image_video_delete_file() // deletes the uploaded video to upload another one
    {
        $this->ajax_check();
        if(!$_POST) exit();

        $output_dir = FCPATH."upload_caster/image_video/";
        $output_dir = $output_dir.'/'.$this->user_id.'/';
        $file_url = $this->input->post("file_url");        
        $exp = explode('/', $file_url);
        $fileName = array_pop($exp);
        $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
        $filePath = $output_dir. $fileName;
        if (file_exists($filePath))
        {
           unlink($filePath);
        }
    }    


    protected function get_emotion_list()
    {
        $dirTree=$this->scanAll(FCPATH."assets/images/emotions-fb");
        $map = array
        (
            "angel" => "o:)",
            "colonthree" => ":3",
            "confused" => "o.O",
            "cry" => ":'(",
            "devil" => "3:)",
            "frown" => ":(",
            "gasp" => ":O",
            "glasses" => "8)",
            "grin" => ":D",
            "grumpy" => ">:(",
            "heart" => "<3",
            "kiki" => "^_^",
            "kiss" => ":*",
            "pacman" => ":v",
            "smile" => ":)",
            "squint" => "-_-",
            "sunglasses" => "8|",
            "tongue" => ":p",
            "upset" => ">:O",
            "wink" => ";)"
            );
        $str = "";
        foreach ($dirTree as $value) 
        {
            $temp = array();
            $value['file'] = str_replace('\\','/', $value['file']);
            $temp =explode('/', $value["file"]);
            $filename = array_pop($temp);
            if(!strpos($filename,'.gif')) continue;
            $title = str_replace('.gif',"",$filename);
            $eval = $map[$title];
            $src= base_url('assets/images/emotions-fb/'.$filename);
            $str.= '&nbsp;&nbsp;<img eval="'.$eval.'" title="'.$title.'" class="cursor_pointer emotion inline" src="'.$src.'"/>&nbsp;&nbsp;';
        }
        return $str;
    }

    protected function scanAll($myDir)
    {
        $dirTree = array();
        $di = new RecursiveDirectoryIterator($myDir,RecursiveDirectoryIterator::SKIP_DOTS);
        $i=0;
        foreach (new RecursiveIteratorIterator($di) as $filename) {
            $dir = str_replace($myDir, '', dirname($filename));
            $dir = str_replace('/', '>', substr($dir,1));
            $org_dir=str_replace("\\", "/", $dir);
            if($org_dir)
                $file_path = $org_dir. "/". basename($filename);
            else
                $file_path = basename($filename);
            $file_full_path=$myDir."/".$file_path;
            $file_size= filesize($file_full_path);
            $file_modification_time=filemtime($file_full_path);
            $dirTree[$i]['file'] = $file_full_path;
            $dirTree[$i]['size'] = $file_size;
            $dirTree[$i]['time'] =date("Y-m-d H:i:s",$file_modification_time);
            $i++;
        }
        return $dirTree;
    }


    public function get_periodic_time()
    {

        $all_periodic_time= array(
        
        
        '60' =>'every 1 hours',
        '120'=>'every 2 hours',
        '300'=>'every 5 hours',
        '1440'=>'every 1 days',
        '2880'=>'every 2 days',
        '4320'=>'every 3 days',
        '7200'=>'every 5 days',
        '8640'=>'every 6 days',
        '10080'=>'every 7 days',
        '43200'=>'every 1 months',
        '86400'=>'every 2 months',
        '259200'=>'every 6 months',
       );
        return $all_periodic_time;
    }


    public function image_editor()
    {
      $this->ajax_check();
      header('Content-Type: application/json');
      
      $errors= array();
      $file_name = $_FILES['croppedImage']['name'];
      $file_size =$_FILES['croppedImage']['size'];
      $file_tmp =$_FILES['croppedImage']['tmp_name'];
      $file_type=$_FILES['croppedImage']['type'];
      if(empty($errors)==true)
      {
         move_uploaded_file($file_tmp,"upload_caster/image_video/".$this->user_id.'/'.$file_name);
         echo json_encode($_FILES['croppedImage']);
      }
      else
      {
         echo json_encode($errors);
      }
    }


}