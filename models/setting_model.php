<?php
/**
 * @author  Seungchul
 * @Date    July 2, 2014
 */

class Setting_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function changePassword()
    {
        $statement = $this->db->select( array("id"), "users", array("password"), array(md5($_POST['old_password'])) );
        if($statement->rowCount() < 1)
        {
            return false;
        }
        else
        {
            $statement = $this->db->update("users", 
                            array("password"), 
                            array(md5($_POST['new_password'])), 
                            array("login"), 
                            array(Session::get('username')));
            
            return true;
        }
    }
    
    public function withdraw()
    {
        $this->db->delete("users", 
                            array("login"), 
                            array(Session::get('username')));
        // we need to delete more s.t. their posts, pictures, and moives
        
        Session::destroy();
    }
}