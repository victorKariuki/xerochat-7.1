<?php

require_once("Home.php"); // loading home controller

class message_manager extends Home
{

    
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login_page', 'location');   
        if($this->session->userdata('user_type') != 'Admin' && !in_array(82,$this->module_access))
        redirect('home/login_page', 'location'); 

        if($this->session->userdata("facebook_rx_fb_user_info")==0)
        redirect('social_accounts/index','refresh');
    
        $this->load->library("fb_rx_login");
        $this->important_feature();
        $this->member_validity();        
    }


    public function index()
    {
      $this->message_dashboard();
    }
   

    public function instagram_message_dashboard($page_table_id=0)
    {  
        if($page_table_id==0) exit();

        $page_data = $this->basic->get_data("facebook_rx_fb_page_info",array("where"=>array("id"=>$page_table_id)),"page_name,insta_username,page_id");
        if(!isset($page_data[0])) exit();

        $data['page_name'] =  "<a href='https://inatagram.com.com/".$page_data[0]['insta_username']."'>".$page_data[0]['insta_username']."</a>";

        $data['body'] = 'message_manager/instagram_message_dashboard';
        $data['page_title'] = $page_data[0]['insta_username'].' - '.$this->lang->line('Instagram Live Chat');
        $data['page_table_id'] = $page_table_id;        
        $this->_viewcontroller($data);
    }

    public function get_pages_conversation_instagram()
    {
        $this->ajax_check();
        $page_table_id = $this->input->post('page_table_id',true);
        $where['where'] = array(
            'user_id' => $this->user_id,
            'facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info'),
            'bot_enabled' => '1',
            'id' => $page_table_id
            );
        $select = array('id','page_name','page_profile','page_id as fb_page_id');
        $page_list = $this->basic->get_data('facebook_rx_fb_page_info',$where,$select,'','','', $order_by='page_name asc');

        $user_info = $this->basic->get_data('users',array('where'=>array('id'=>$this->user_id)));
        if(isset($user_info[0]['time_zone']) && $user_info[0]['time_zone'] != '')
            date_default_timezone_set($user_info[0]['time_zone']);

        $response= $this->messenger_sync_page_messages($page_table_id,"ig");


        if(isset($response['error']))
        echo '<br><div class="alert alert-danger text-center w-100"><b class="m-0">'.$response['error_message'].'</b></div>';


        // for go to link generating
        $where = array();
        $where['where'] = array(
            'user_id' => $this->user_id,
            'facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info')
            );

        $go_to_link = "";

            
        $str = '';
        foreach($page_list as $value)
        {

            $where = array();
            $where['where'] = array(
                'fb_msg_manager.user_id' => $this->user_id,
                'fb_msg_manager.facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info'),
                'fb_msg_manager.page_table_id' => $value['id'],
                'fb_msg_manager.social_media'=>'ig'
                );
            $join  = array("messenger_bot_subscriber"=>"messenger_bot_subscriber.subscribe_id=fb_msg_manager.from_user_id,left");
            $last_conversation = $this->basic->get_data('fb_msg_manager',$where,'fb_msg_manager.*,messenger_bot_subscriber.status,messenger_bot_subscriber.id as auto_id',$join,50,$start=0,$order_by='last_update_time desc');

            foreach($last_conversation as $data)
            { 
                $rand = rand(1,4);
                $permission = $data['status'] ?? '1';
                $auto_id = $data['auto_id'] ?? 0;
                $button_id = $auto_id.'-'.$permission;
                $img = base_url('assets/img/avatar/avatar-'.$rand.'.png');
                $str.='
                <li class="media py-2 px-4 open_conversation" thread_id="'.$data["thread_id"].'" from_user="'.htmlspecialchars($data['from_user']).'" from_user_id="'.$data['from_user_id'].'" page_table_id="'.$data["page_table_id"].'" style="cursor:pointer">
                    <img alt="image" class="mr-3 rounded-circle" width="50" src="'.$img.'">
                    <div class="media-body">
                      <div class="mt-0 mb-1 font-weight-bold text-primary">'.$data['from_user'].'<span class="badge badge-danger badge-pill ml-2 px-2 py-1 d-none">0</span></div>
                      <div class="text-gray text-small font-600-bold"><i class="fas fa-user"></i> '.$data['from_user_id'].'</div>
                    </div>
                </li>';  
            }


        }
        echo $str;
        
    }

    public function get_post_conversation_instagram()
    {
        $this->ajax_check();

        // for time zone checking
        $where = array();
        $where['where'] = array(
            'user_id' => $this->user_id,
            'facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info')
            );
       

        $from_user_id = $this->input->post('from_user_id',true);
        $thread_id = $this->input->post('thread_id',true);
        $page_table_id = $this->input->post('page_table_id',true);
        $last_message_id = $this->input->post('last_message_id',true);

        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)));

        $post_access_token = $page_info[0]['page_access_token'];
        $page_name = $page_info[0]['page_name'];

        $conversations = $this->fb_rx_login->get_messages_from_thread_instagram($thread_id,$post_access_token);
        if(!isset($conversations['data'])) $conversations['data']=array();
        $conversations['data'] = array_reverse($conversations['data']);

        // pre($conversations['data']);

        $show_after_this_index = '';
        if(!empty($last_message_id))
        foreach($conversations['data'] as $key=>$value)
        {
            if($value['id']==$last_message_id) {
                $show_after_this_index = $key;
                break;
            }
        }

        $str = '';
        foreach($conversations['data'] as $key=>$value)
        {
            if(!empty($show_after_this_index) && $key<=$show_after_this_index) continue;

            $temp_from_user_id = isset($value['from']['id']) ? $value['from']['id'] :'';
            $temp_from_user_name = isset($value['from']['username']) ? $value['from']['username'] :'';
            $position_class = $from_user_id!=$temp_from_user_id ? "chat-item chat-right" : "chat-item chat-left";
            $thumbnail = $from_user_id!=$temp_from_user_id ? base_url('assets/img/icon/instagram.png') : base_url('assets/img/avatar/avatar-1.png');

            $created_time = $value['created_time']." UTC";

            $message = '';

            if(isset($value['message']) && !empty($value['message'])) $message = '<div class="chat-text">'.$value["message"].'</div>';
            if(isset($value['is_unsupported']) && $value['is_unsupported']=='1') $message = '<div class="chat-text text-muted">Message not supported</div>';
 
            $attachments='';
            if(isset($value['attachments']['data'][0]))
            {                
                if(isset($value['attachments']['data'][0]['image_data']))
                {
                     $image_url = isset($value['attachments']['data'][0]['image_data']['url']) ? $value['attachments']['data'][0]['image_data']['url'] : '';
                     $attachments .= '<img class="img-thumbnail img-fluid d-block" style="max-width:300px;" src="'.$image_url.'">';
                }
                else if(isset($value['attachments']['data'][0]['video_data']))
                {
                     $image_url = isset($value['attachments']['data'][0]['video_data']['url']) ? $value['attachments']['data'][0]['video_data']['url'] : '';
                     $attachments .= '
                     <video width="300" height="" src="'.$image_url.'" onClick=\'openTab("'.$image_url.'")\'></video>';
                }
                
            }

            $str.='
            <div class="'.$position_class.'" style="">
                 <div class="chat-details mr-0 ml-0" key="'.$key.'" message_id="'.$value['id'].'">
                    '.$message.'
                    '.$attachments.'
                    <div class="chat-time">'.date('d M Y H:i:s',strtotime($created_time)).'</div>
                 </div>
            </div>';
        }
        echo $str;
    }

    public function reply_to_conversation_instagram()
    {
        if($this->is_demo == '1')
        {
            echo "<div class='alert alert-danger text-center'>This feature is disabled in this demo.</div>"; 
            exit();
        }

        $from_user_id = $this->input->post('from_user_id',true);
        $page_table_id = $this->input->post('page_table_id',true);
        $reply_message = $this->input->post('reply_message',true);


        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)));
        $post_access_token = $page_info[0]['page_access_token'] ?? '';


        $message = array
        (
            'recipient' =>array('id'=>$from_user_id),
            'message'=>array('text'=>$reply_message),
            'tag'=>'ACCOUNT_UPDATE'
        );
        $message = json_encode($message);

        try
        {            
            $response = $this->fb_rx_login->send_non_promotional_message_subscription($message,$post_access_token);
           
            if(isset($response['message_id']))
            {
                echo
                '<div class="chat-item chat-right" style="">
                     <div class="chat-details mr-0 ml-0" message_id="'.$response['message_id'].'">
                        <div class="chat-text">'.$reply_message.'</div>
                        <div class="chat-time">'.date('d M Y H:i:s').'</div>
                     </div>
                </div>';
            }
            else 
            {
                if(isset($response["error"]["message"])) $message_sent_id = $response["error"]["message"];  
                if(isset($response["error"]["code"])) $message_error_code = $response["error"]["code"]; 

                if(isset($message_error_code) && $message_error_code=="368") // if facebook marked message as spam 
                {
                    $error_msg=$message_sent_id;
                }

                $error_msg = $message_sent_id;
                echo "<div class='alert alert-danger text-center'>".$error_msg."</div>";

            } 
        }
        catch(Exception $e) 
        {
          echo "<div class='alert alert-danger text-center'>".$e->getMessage()."</div>";
        }
    }


    public function message_dashboard($page_table_id=0)
    {
        if($page_table_id==0) exit();

        $page_data = $this->basic->get_data("facebook_rx_fb_page_info",array("where"=>array("id"=>$page_table_id)),"page_name,insta_username,page_id");
        if(!isset($page_data[0])) exit();

        $data['page_name'] =  "<a href='https://facebook.com/".$page_data[0]['page_id']."'>".$page_data[0]['page_name']."</a>";

        $data['body'] = 'message_manager/message_dashboard';
        $data['page_title'] = $page_data[0]['page_name'].' - '.$this->lang->line('Facebook Live Chat');
        $data['page_table_id'] = $page_table_id;        
        $this->_viewcontroller($data);
    }


    public function get_pages_conversation()
    {

        $this->ajax_check();
        $page_table_id = $this->input->post('page_table_id',true);
        $where['where'] = array(
            'user_id' => $this->user_id,
            'facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info'),
            'bot_enabled' => '1',
            'id' => $page_table_id
            );
        $select = array('id','page_name','page_profile','page_id as fb_page_id');
        $page_list = $this->basic->get_data('facebook_rx_fb_page_info',$where,$select,'','','', $order_by='page_name asc');

        $user_info = $this->basic->get_data('users',array('where'=>array('id'=>$this->user_id)));
        if(isset($user_info[0]['time_zone']) && $user_info[0]['time_zone'] != '')
            date_default_timezone_set($user_info[0]['time_zone']);

        $response= $this->messenger_sync_page_messages($page_table_id);


        if(isset($response['error']))
             echo '<br><div class="alert alert-danger text-center w-100"><b class="m-0">'.$response['error_message'].'</b></div>';


        // for go to link generating
        $where = array();
        $where['where'] = array(
            'user_id' => $this->user_id,
            'facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info')
            );

        $go_to_link = "https://www.facebook.com";
        $business_account = $this->basic->get_data('fb_msg_manager_notification_settings',$where);
        if(!empty($business_account))
        {
            $check_business_account = $business_account[0]['has_business_account'];
            if($check_business_account == 'yes')
               $go_to_link = "https://business.facebook.com";
            if($business_account[0]['time_zone'] != '')
                date_default_timezone_set($business_account[0]['time_zone']);
        }
        // end of go to link generating

        if(empty($page_list))
        {
            echo '<br><div class="alert alert-danger text-center w-100"><b class="m-0">'.$this->lang->line("you have not enabled messenger manager for any page yet !").'</b></div>';
        }
        else
        {
            $str = '';
            foreach($page_list as $value)
            {
                $where = array();
                $where['where'] = array(
                    'fb_msg_manager.user_id' => $this->user_id,
                    'fb_msg_manager.facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info'),
                    'fb_msg_manager.page_table_id' => $value['id'],
                    'fb_msg_manager.social_media'=>'fb'
                    );
                $join  = array("messenger_bot_subscriber"=>"messenger_bot_subscriber.subscribe_id=fb_msg_manager.from_user_id,left");
                $last_conversation = $this->basic->get_data('fb_msg_manager',$where,'fb_msg_manager.*,messenger_bot_subscriber.status,messenger_bot_subscriber.id as auto_id',$join,50,$start=0,$order_by='last_update_time desc');

                foreach($last_conversation as $data)
                {
                    $rand = rand(1,4);
                    $permission = $data['status'] ?? '1';
                    $auto_id = $data['auto_id'] ?? 0;
                    $button_id = $auto_id.'-'.$permission;
                    $img = base_url('assets/img/avatar/avatar-'.$rand.'.png');
                    $str.='
                    <li class="media py-2 px-4 open_conversation" thread_id="'.$data["thread_id"].'" from_user="'.htmlspecialchars($data['from_user']).'" from_user_id="'.$data['from_user_id'].'" page_table_id="'.$data["page_table_id"].'" style="cursor:pointer">
                        <img alt="image" class="mr-3 rounded-circle" width="50" src="'.$img.'">
                        <div class="media-body">
                          <div class="mt-0 mb-1 font-weight-bold text-primary">'.$data['from_user'].'<span class="badge badge-danger badge-pill ml-2 px-2 py-1 d-none">2</span></div>
                          <div class="text-gray text-small font-600-bold"><i class="fas fa-user"></i> '.$data['from_user_id'].'</div>
                        </div>
                    </li>';
                }
                
            }
            echo $str;
        }
        
    }
    

    public function get_post_conversation()
    {
        $this->ajax_check();

        // for time zone checking
        $where = array();
        $where['where'] = array(
            'user_id' => $this->user_id,
            'facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info')
            );

        $business_account = $this->basic->get_data('fb_msg_manager_notification_settings',$where);
        if(!empty($business_account))
        {
            if($business_account[0]['time_zone'] != '')
                date_default_timezone_set($business_account[0]['time_zone']);
        }
        // end of time zone checking

        $from_user_id = $this->input->post('from_user_id',true);
        $thread_id = $this->input->post('thread_id',true);
        $page_table_id = $this->input->post('page_table_id',true);
        $last_message_id = $this->input->post('last_message_id',true);  
        

        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)));

        $post_access_token = $page_info[0]['page_access_token'];
        $page_name = $page_info[0]['page_name'];

        $conversations = $this->fb_rx_login->get_messages_from_thread($thread_id,$post_access_token);
        if(!isset($conversations['data'])) $conversations['data']=array();
        $conversations['data'] = array_reverse($conversations['data']);
        // echo "<pre>"; print_r($conversations['data']); exit;

        $show_after_this_index = '';
        if(!empty($last_message_id))
        foreach($conversations['data'] as $key=>$value)
        {
            if($value['id']==$last_message_id) {
                $show_after_this_index = $key;
                break;
            }
        }

        $str = '';
        foreach($conversations['data'] as $key=>$value)
        {
            if(!empty($show_after_this_index) && $key<=$show_after_this_index) continue;

            $created_time = $value['created_time']." UTC";
            isset($value['from']['name']) ? $value['from']['name'] = $value['from']['name'] : $value['from']['name'] = '';
            if($value['from']['name'] == $page_name)
            {
                $str.='
                <div class="chat-item chat-right" style="">
                     <div class="chat-details mr-0 ml-0" message_id="'.$value['id'].'">
                        <div class="chat-text">'.chunk_split($value['message'], 50, '<br>').'</div>
                        <div class="chat-time">'.$value['from']['name'].' @'.date('d M Y H:i:s',strtotime($created_time)).'</div>
                     </div>
                </div>';
            }
            else
            {
                $str.='
                <div class="chat-item chat-left" style="">
                     <div class="chat-details mr-0 ml-0" message_id="'.$value['id'].'">
                        <div class="chat-text">'.chunk_split($value['message'], 50, '<br>').'</div>
                        <div class="chat-time">'.$value['from']['name'].' @'.date('d M Y H:i:s',strtotime($created_time)).'</div>
                     </div>
                </div>';
            }
        }
        echo $str;
    }
   

    public function reply_to_conversation()
    {
        if($this->is_demo == '1')
        {
            echo "<div class='alert alert-danger text-center'>This feature is disabled in this demo.</div>"; 
            exit();
        }

        $thread_id = $this->input->post('thread_id',true);
        $from_user_id = $this->input->post('from_user_id',true);
        $page_table_id = $this->input->post('page_table_id',true);
        $reply_message = $this->input->post('reply_message',true);

        $message = array
        (
            'recipient' =>array('id'=>$from_user_id),
            'message'=>array('text'=>$reply_message),
            'tag'=>'ACCOUNT_UPDATE'
        );
        $message = json_encode($message);


        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)));
        $post_access_token = $page_info[0]['page_access_token'];

        try
        {            
            $response = $this->fb_rx_login->send_non_promotional_message_subscription($message,$post_access_token);

            if(isset($response['message_id']))
            {
                echo
                '<div class="chat-item chat-right" style="">
                     <div class="chat-details mr-0 ml-0" message_id="'.$response['message_id'].'">
                        <div class="chat-text">'.$reply_message.'</div>
                        <div class="chat-time">'.date('d M Y H:i:s').'</div>
                     </div>
                </div>';
            }
            else 
            {
                if(isset($response["error"]["message"])) $message_sent_id = $response["error"]["message"];  
                if(isset($response["error"]["code"])) $message_error_code = $response["error"]["code"]; 

                if(isset($message_error_code) && $message_error_code=="368") // if facebook marked message as spam 
                {
                    $error_msg=$message_sent_id;
                }

                $error_msg = $message_sent_id;
                echo "<div class='alert alert-danger text-center'>".$error_msg."</div>";
            } 
        }
        catch(Exception $e) 
        {
          echo "<div class='alert alert-danger text-center'>".$e->getMessage()."</div>";
        }

    }
  

    public function messenger_sync_page_messages($page_table_id=0,$social_media="fb"){
        
        $user_id = $this->user_id;
        $where=array('where'=>array('id'=>$page_table_id)); 
        $pages_info_for_sync = $this->basic->get_data("facebook_rx_fb_page_info",$where);
        
        foreach($pages_info_for_sync as $page){
        
            $facebook_rx_fb_page_info_id = $page['facebook_rx_fb_user_info_id'];
            $user_id = $page['user_id'];
            $page_table_id= $page['id'];
            
            // getting latest 200 data
            $get_concersation_info = $this->fb_rx_login->get_all_conversation_page($page['page_access_token'],$page['page_id'],1,'','',$social_media);

            if(isset($get_concersation_info['error'])){
                $response['error']='1';
                $response['error_message']=isset($get_concersation_info['error_msg']) ? $get_concersation_info['error_msg']:"Unknown Error Occurred";
                return $response;

            }

            
            foreach($get_concersation_info as $conversion_info){
            
                $from_user     = isset($conversion_info['name']) ? $this->db->escape($conversion_info['name']) : "";
                $from_user_id  = isset($conversion_info['id']) ? $conversion_info['id'] : "";
                $last_snippet  = isset($conversion_info['snippet']) ? $this->db->escape($conversion_info['snippet']) : "";
                $message_count = isset($conversion_info['message_count']) ? $conversion_info['message_count'] : 0;
                $thread_id     = isset($conversion_info['thead_id']) ? $conversion_info['thead_id'] : "";
                $inbox_link    = isset($conversion_info['link']) ? $conversion_info['link'] : "";
                $unread_count  = isset($conversion_info['unread_count']) ? $conversion_info['unread_count'] : 0;

                $sync_time     = date("Y-m-d H:i:s");
                $last_update_time=$conversion_info['updated_time'];
                // $last_update_time=date('Y-m-d H:i:s',strtotime($conversion_info['updated_time']));
                
                /***delete from database **/
                $this->basic->delete_data('fb_msg_manager',array('user_id'=>$user_id,'facebook_rx_fb_user_info_id'=>$facebook_rx_fb_page_info_id,'thread_id'=>$thread_id,"social_media"=>$social_media));
                
                /***Insert into database **/
                 $sql="Insert into fb_msg_manager(user_id,facebook_rx_fb_user_info_id,from_user,from_user_id,last_snippet,message_count,thread_id,inbox_link,unread_count,sync_time,last_update_time,page_table_id,social_media) 
                    values ('$user_id','$facebook_rx_fb_page_info_id',$from_user,'$from_user_id',$last_snippet,'$message_count','$thread_id','$inbox_link','$unread_count','$sync_time','$last_update_time','$page_table_id','$social_media')";
                
                $this->basic->execute_complex_query($sql);
                
                    
            }
                
        }
        
        
    }




}