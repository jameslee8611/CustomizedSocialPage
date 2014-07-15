<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Profile_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    
    public function check_user($username)
    {
        $statement = $this->db->select(array("id"), "users", array("login"), array($username));
        if(!$statement){
            throw new Exception('Query failed.');
        }
        
        if ($statement->rowCount() > 0)
        {
            return true;
        }
        
        return false;
    }
    
    public function post($from, $type)
    {
        if(!isset($from) || empty($from))
        {
            $query = $this->db->select(array("Id"), "users", array("login"), array(Session::get('username')));
            $row =$query->fetchAll();
            $statement = $this->db->insert("status", array("UId", "Status"), array($row[0]['Id'], $_POST['post-text']));
        }
        
        
        if ($statement->rowCount() > 0)
        {
            // if from is from profile page
            header('location: ' . '../' . Session::get('username'));
            // otherwise,
        }
        else
        {
            echo "Network Connection fails";
            exit;
        }
    }

    public function get_status()
    {
        $result = array();
        
        //////////// Db connection goes here ////////////
        array_push($result, $this->formatter("Tester", "Hello, world", array("Tester2", "Tester3"), array("Hi", "Hello")));

	return $result;
    }
    
    /**
     * 
     * @param string $writer    Name of writer
     * @param string $post      Post context
     * @param array $commentors List of commentors    
     * @param array $comments   List of comments
     */
    private function formatter($writer, $post, $commentors, $comments)
    {
        $string = new ArrayObject();
        
        if (count($commentors) != count($comments))
        {
            return NULL;
        }
        
        $result = '{
                        "Writer": "' . $writer. '",
                        "Post": "' . $post . '",
                        "Comments": 
                        [';
                            for ($i=0; $i<count($commentors); $i++)
                            {
                                $result .= '{"Writer": "' . $commentors[$i]. '", "Comment": "' . $comments[$i] . '"}';
                                if ($i+1 != count($commentors))
                                {
                                    $result .= ', ';
                                }
                            }
        $result .=      ']
                    }';
        
        $string->append($result);
        
        return json_decode($string[0], true);
    }
}