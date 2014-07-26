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
    
    public function delete_ajax($wall_Id)
    {
        $statement = $this->db->prepare("Delete wall, status
                            From status
                            Inner Join wall
                            Inner Join (
                                    Select wall.StatusId
                                    From wall
                                    Where wall.Id = '$wall_Id') table1
                            Where status.Id = table1.StatusId AND wall.Id = '$wall_Id'
                            ");
        $success = $statement->execute();
        if($success)
        {
            return SUCCESS;
        }
        else
        {
            return FAIL;
        }
    }
    
    public function post_ajax($username, $from, $type)
    {   
        if(!isset($from) || empty($from))
        {   
            $query_whereId = $this->db->select(array("Id"), "users", array("login"), array($username));
            $row =$query_whereId->fetchAll();
            $whereId = $row[0]['Id'];
            
            $this->db->insert("status", array("UId", "Status", "Privacy"), array(Session::get('userId'), $_POST['post-text'], $_POST['privacy']));
            $statement2 = $this->db->insert("wall", array("whereId", "StatusId", "Type"), array($whereId, $this->db->lastInsertId(), $type));
            
            $wallId = $this->db->lastInsertId();
        }
        
        if ($statement2->rowCount() > 0)
        {
            return json_encode( $this->formatter($wallId, Session::get('username'), $_POST['post-text'], date("Y-m-d h:i:s"), $_POST['privacy']) );
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
                                        ORDER BY table2.date DESC
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
     * @param int $id           Wall Id
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
        
        $post = preg_replace("/[\r\n]{2,}/", "\\n", $post);
        
        if ($writer == Session::get('username')) {
            $delete = 'fi-trash';
        }
        else {
            $delete = '';
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
                        "Delete": "' . $delete . '",
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

    public function profile_image($username)
    {
        if(empty($_FILES))
        {
            return array(false, "No Files");
        }
        else
        {
            $x_val = $_POST["x_val"];
            $y_val = $_POST["y_val"];
            $width_val = $_POST["width"];
            $height_val = $_POST["height"];

            $image_info = getimagesize($_FILES["file"]["tmp_name"]);

            if($image_info[2] == IMAGETYPE_GIF || $image_info[2] == IMAGETYPE_JPEG || $image_info[2] == IMAGETYPE_PNG)
            {
                $img_path = URL + "/public/images/image/" . date("Ymdhisu") . "_" . $username . ".jpg";
                $src = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
                $des = imagecreatetruecolor($width_val, $height_val);
                imagecopyresampled($des, $src, 0, 0, $x_val, $y_val, $width_val, $height_val, $width_val, $height_val);
                imagejpeg($des, $img_path, 100);

                imagedestroy($src);
                imagedestroy($des);

                return $img_path;
            }
            else
            {
                return array(false, "Invalid File Type!");
            }
        }
    }
}