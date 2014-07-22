<?php
/**
 * @author  Seungchul Lee
 * @date    July 16, 2014
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
    
    public function post($username, $from, $type)
    {
        //echo $_POST['privacy'];
        
        if(!isset($from) || empty($from))
        {   
            $query_whereId = $this->db->select(array("Id"), "users", array("login"), array($username));
            $row =$query_whereId->fetchAll();
            $whereId = $row[0]['Id'];
            
            $this->db->insert("status", array("UId", "Status", "Privacy"), array(Session::get('userId'), $_POST['post-text'], $_POST['privacy']));
            $statement2 = $this->db->insert("wall", array("whereId", "StatusId", "Type"), array($whereId, $this->db->lastInsertId(), $type));
            
        }
        
        if ($statement2->rowCount() > 0)
        {
            // if from is from profile page
            header('location: ' . '../../' . $username);
            // otherwise,
        }
        else
        {
            echo "Network Connection fails";
            exit;
        }
        
    }

    public function get_status($username)
    {
        $result = array();
        $statement = $this->db->prepare("Select users.login, table2.status, table2.date, table2.privacy, table2.id
                                        From (
                                            Select status.status, status.UId, status.date, status.privacy, wall.id
                                            From wall
                                            Inner join (
                                                    Select users.Id
                                                    From users
                                                    Where users.login = '$username') table1
                                                On table1.Id = wall.whereId
                                            Inner join status
                                                On wall.StatusId = status.Id) table2
                                        Inner join users
                                            On users.Id = table2.UId
                                                ");
        
        $success = $statement->execute();
        if($success)
        {
            $query = $statement->fetchAll();
            
            foreach ($query as $row)
            {
                array_push($result, $this->formatter($row['id'], $row['login'], $row['status'], $row['date'], $row['privacy']));
            }
        }
        else
        {
            echo 'error';
            exit;
        }
        
	return $result;
    }
    
    /**
     * 
     * @param string $writer    Name of writer
     * @param string $post      Post context
     * @param array $commentors List of commentors    
     * @param array $comments   List of comments
     */
    private function formatter($id, $writer, $post, $date, $privacy, $commentors = null, $comments = null)
    {
        if (count($commentors) != count($comments))
        {
            return NULL;
        }
        
        switch ((int)$privacy) 
        {
            case PUBLIC_POST:
                $privacy_icon = 'fi-rss';
                $description = 'Public post';
                break;
            case FRIENDS_POST:
                $privacy_icon = 'fi-torsos-all';
                $description = 'Only for Friends';
                break;
            case PRIVATE_POST:
                $privacy_icon = 'fi-lock';
                $description = 'Only for you';
                break;
            default:
                $privacy_icon = '';
                $description = '';
        }
        
        $result = '{
                        "id": "'. $id .'",
                        "Writer": "' . $writer. '",
                        "Post": "' . $post . '",
                        "Date": "' . $date . '",
                        "Privacy": "'. $privacy_icon .'",
                        "Privacy_description": "'. $description .'",
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
        
        return json_decode($result, true);
    }
}