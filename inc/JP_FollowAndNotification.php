<?php
if(!defined('ABSPATH')){
    die();
}
class JP_FollowAndNotification{

    protected $db = null;

    protected $ntable = 'notifications';

    protected $ftable = 'user_followers';

    function __construct(){
        if (!$this->db){
            $this->db = new JP_Database();
        } 
    }

    public function getNewNotificationByUserID($user){
        $table = $this->db->get_prefix().$this->ntable;
        $query = 'SELECT * FROM '.$table.' WHERE user_id='.$user->ID.' AND status="open"';
        $results = $this->db->select($query);
        if($this->db->num_rows() > 0){
            $notifiData = array();
            foreach ($results as $singlnf) { 
                $row = array();
                $formUser   = get_user_by('id', $singlnf['from_user_id']);
                $fname      = get_user_meta($formUser->ID, 'first_name', true);
                $lname      = get_user_meta($formUser->ID, 'last_name', true);
                $imageSrc   = wp_get_attachment_url( get_user_meta($formUser->ID, 'profile_image', true) );
                
                $imageSrc   = !empty($imageSrc) ? $imageSrc : get_template_directory_uri().'/assets/img/plato.png';

                $row['type']                = $singlnf['type'];
                $row['from_user_name']      = $fname .' '.$lname;
                $row['from_user_avater']    = $imageSrc;
                $row['date']                = $this->time_elapsed_string( $singlnf['Created_at'] );

                if( ($singlnf['type'] == 'post') || ($singlnf['type'] == 'comment') ){
                    $post               = get_post( $singlnf['post_id'] );
                    $catName            = get_the_terms($post->ID, 'category')[0]->name;
                    $postLink           = get_permalink($post);
                    $row['post_title']  = $post->post_title;
                    $row['post_cat']    = $catName;
                    $row['post_link']   = $postLink;
                }
                $notifiData[] = $row; 
            }
            return $notifiData;
        }
        return false;
    } 

    public function getAllNotificationDataByUserID($user, $limit=false){
        $table = $this->db->get_prefix().$this->ntable;
        $query = 'SELECT * FROM '.$table.' WHERE user_id='.$user->ID;
        if($limit != false){
            $query .=' LIMIT '.$limit;
        }
        $results = $this->db->select($query);
        if($this->db->num_rows() > 0){
            $notifiData = array();
            foreach ($results as $singlnf) { 
                $row = array();
                $formUser   = get_user_by('id', $singlnf['from_user_id']);
                $fname      = get_user_meta($formUser->ID, 'first_name', true);
                $lname      = get_user_meta($formUser->ID, 'last_name', true);
                $imageSrc   = wp_get_attachment_url( get_user_meta($formUser->ID, 'profile_image', true) );
                
                $imageSrc   = !empty($imageSrc) ? $imageSrc : get_template_directory_uri().'/assets/img/plato.png';

                $row['type']                = $singlnf['type'];
                $row['from_user_name']      = $fname .' '.$lname;
                $row['from_user_avater']    = $imageSrc;
                $row['date']                = $this->time_elapsed_string( $singlnf['Created_at'] );

                if( ($singlnf['type'] == 'post') || ($singlnf['type'] == 'comment') ){
                    $post               = get_post( $singlnf['post_id'] );
                    $catName            = get_the_terms($post->ID, 'category')[0]->name;
                    $postLink           = get_permalink($post);
                    $row['post_title']  = $post->post_title;
                    $row['post_cat']    = $catName;
                    $row['post_link']   = $postLink;
                }
                $notifiData[] = $row; 
            }
            return $notifiData;
        }
        return false;
    } 

    public function updateNotificationByUserID($user){  
        $results = $this->db->update( $this->ntable, array('status'=>'seen'), array('user_id'=>$user->ID, 'status'=>'open'), array("%s"), array("%s") );
        if($this->db->num_rows() > 0){
            return true;
        }
        return false;
    }

    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function getAllNotificationByUserID($userId){
        $table = $this->db->get_prefix().$this->ntable;
        $query = 'SELECT * FROM '.$table.' WHERE user_id='.$userId;
        $results = $this->db->select($query);
        if($this->db->num_rows() > 0){
            return $results;
        }
        return false;
    }

    public function setFollower($userId){ 
        $currentUser = wp_get_current_user();
        if( is_user_logged_in() && $currentUser->ID ){ 
            $exitsUser = $this->isUserFollowing($userId, $currentUser->ID);
            if( $exitsUser === false ){
                $format = array("%d", "%d");
                $data = array(
                    'user_id'       => (int)$userId,
                    'follower_id'   => $currentUser->ID
                );
                if ($this->db){ 
                    $frow = $this->db->insert($this->ftable, $data, $format); 
                    $nrow = $this->pushNotification($userId, $currentUser->ID, 'follow', null, 'open'); 
                    if($frow && $nrow){  
                        $followersData = $this->getFollowersByUserID($userId); 
                        $followers = $this->db->num_rows();
                        // var_dump($followers);
                        wp_send_json( array('status'=> 'success', 'data'=>'unfollow', 'followers'=>$followers) );
                    }else{
                        wp_send_json( array('status'=> 'failed', 'error_message'=>'Unavable To Follow User.') );
                    }
                } 
            }
            wp_send_json( array('status'=> 'failed', 'error_message'=>'Already Following.') );
        }
        wp_send_json( array('status'=> 'failed', 'error_message'=>'Invalid Request.') );
    }

    public function unsetFollower($userId){
        $currentUser = wp_get_current_user();
        if( is_user_logged_in() && $currentUser->ID ){ 
            $exitsUser = $this->isUserFollowing($userId, $currentUser->ID);
            if( $exitsUser === true ){ 
                $frow = $this->db->delete($this->ftable, array(
                    'user_id'       => (int)$userId,
                    'follower_id'   => (int)$currentUser->ID
                )); 
                $nrow = $this->db->delete($this->ntable, array(
                    'user_id'       => (int)$userId,
                    'from_user_id'  => (int)$currentUser->ID,
                    'type'          => 'follow'
                ));
                if( $frow && $nrow ){
                    $followersData = $this->getFollowersByUserID($userId); 
                    $followers = $this->db->num_rows();
                    //var_dump($followers);
                    wp_send_json( array('status'=> 'success', 'data'=>'follow', 'followers'=>$followers) );
                } 
            }
        }
    }

    public function isUserFollowing($userId, $followerID){ 
        $table = $this->db->get_prefix().$this->ftable;
        $query = 'SELECT * FROM '.$table.' WHERE user_id ='.$userId.' AND follower_id ='.$followerID;
        $results = $this->db->select($query); 
        if($this->db->num_rows() > 0){
            return true;
        }
        return false;
    }
    public function getFollowersByUserID($userId){
        $table = $this->db->get_prefix().$this->ftable;
        $query = 'SELECT * FROM '.$table.' WHERE user_id='.$userId;
        $results = $this->db->select($query);
        if($this->db->num_rows() > 0){
            return $results;
        }
        return false;
    }

    public function getFolloweingByUserID($userId){
        $table = $this->db->get_prefix().$this->ftable;
        $query = 'SELECT * FROM '.$table.' WHERE follower_id='.$userId;
        $results = $this->db->select($query);
        if($this->db->num_rows() > 0){
            return $results;
        }
        return false;
    }

    public function countFolloweingByUserID($userId){
        $table = $this->db->get_prefix().$this->ftable;
        $query = 'SELECT * FROM '.$table.' WHERE follower_id='.$userId;
        $results = $this->db->select($query); 
        return $this->db->num_rows();
    }

    public function countFollowersByUserID($userId){
        $table = $this->db->get_prefix().$this->ftable;
        $query = 'SELECT * FROM '.$table.' WHERE user_id='.$userId;
        $results = $this->db->select($query); 
        return $this->db->num_rows();
    }

    public function pushNotification($userId, $followingID, $type, $post_id = null, $status){
        if($userId && $followingID && $type && $status){
            $fformat = array("%d", "%d", "%s", "%d", "%s"); 
            $data = array(
                'user_id'       => (int)$userId,
                'from_user_id'  => (int)$followingID,
                'type'          => $type,
                'post_id'       => $post_id,
                'status'        => $status
            );
            $frow = $this->db->insert($this->ntable, $data, $format); 
            if($frow){ 
                return $frow;
            }
        }
        return false;
    } 

}