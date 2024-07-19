<?php 
require_once 'db.php';
 
class User { 
    function __construct(){
        if(!isset($this->db)){ 
            $this->db = new Database();
        } 
    } 
     
    function checkUser($data = array()){ 
            // var_dump($data); die;
            if(!empty($data)){ 
            $checkResult = $this->db->select("users", "*", "oauth_provider = '". $data['oauth_provider']. "' AND oauth_uid = '".$data['oauth_uid']."'");
            // Add modified time to the data array 
            if(!array_key_exists('modified', $data)){ 
                $data['modified'] = date("Y-m-d H:i:s"); 
            }
             
            if(count($checkResult) > 0){
                $this->db->update("users", $data, "oauth_provider = '". $data['oauth_provider']. "' AND oauth_uid = '".$data['oauth_uid']."'");

            }else{
                // Add created time to the data array 
                if(!array_key_exists('created',$data)){
                    $data['created'] = date("Y-m-d H:i:s"); 
                } 
                $this->db->insert("users", $data);
            }
            $userData = $checkResult[0];
            // var_dump($userData); die;
        } 
        $this->db->close();
        // Return user data 
        return !empty($userData)?$userData:false; 
    } 
}