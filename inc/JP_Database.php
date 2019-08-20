<?php
if(!defined('ABSPATH')){
    die();
}

class JP_Database{

    protected $db = null;

    protected $prefix = 'jp_';

    public function __construct(){
        if(!$this->db){
            global $wpdb;
            $this->db = &$wpdb;
        }
    }

    public function init(){
        if($this->db) {
            $charset_collate = $this->db->get_charset_collate();

            // Created query for notifications table
            $table_notifications = $this->get_prefix().'notifications';
            $this->db->query("DROP TABLE IF EXISTS $table_notifications");
            $notification_query = "CREATE TABLE $table_notifications (
                            `id` INT NOT NULL  AUTO_INCREMENT ,
                            `user_id` INT NOT NULL , 
                            `from_user_id` INT DEFAULT NULL ,
                            `type` ENUM('post', 'follow', 'comment') NOT NULL , 
                            `post_id` INT DEFAULT NULL ,  
                            `status` ENUM('open', 'seen') NOT NULL ,
                            `Created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() , 
                            PRIMARY KEY (`id`)
                    ) $charset_collate;";

            // Created query for user followers table
            $table_user_followers = $this->get_prefix().'user_followers';
            $this->db->query("DROP TABLE IF EXISTS $table_user_followers");
            $user_followers_query = "CREATE TABLE $table_user_followers (
                            `id` INT NOT NULL  AUTO_INCREMENT ,
                            `user_id` INT NOT NULL , 
                            `follower_id` INT NOT NULL ,  
                            `Created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() , 
                            PRIMARY KEY (`id`)
                    ) $charset_collate;";
            
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($notification_query);
            dbDelta($user_followers_query);
        }
    }

    public function get_prefix(){
        if($this->db) {
            return $this->db->prefix.$this->prefix;
        }
    }

    public function insert($table, $data, $format){
        $table = $this->get_prefix().$table;
        $id = $this->db->insert($table, $data, $format);
        return $id;
    }

    public function update($table, $data, $where, $format, $format_where){
        $table = $this->get_prefix().$table;
        $result = $this->db->update($table, $data, $where, $format, $format_where);
        return $result;
    } 

    public function select($query){
        $results = $this->db->get_results($query, ARRAY_A); 
        return $results;
    }
    public function delete($table, array $args ){ 
        $table = $this->get_prefix().$table;
        $results = $this->db->delete($table, $args); 
        return $results;
    }

    public function num_rows(){
        return $this->db->num_rows;
    }
    
}