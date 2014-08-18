<?php

/**
 * @author  Seungchul Lee
 * @date    July 16, 2014
 */
class Profile_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function check_user($username) {
        $statement = $this->db->select(array("id"), "users", array("login"), array($username));
        if (!$statement) {
            throw new Exception('Query failed.');
        }

        if ($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }
    
    public function get_profile_url($username) {
        $query = $this->db->select(array('Profile_pic'), "users", array("login"), array($username));
        if ($query) {
            $row =$query->fetchAll();
            if(count($row) > 0) {
                $result = $row[0]['Profile_pic'];

                if (!isset($result) || empty($result) || !file_exists($result . '_large.jpg')) {
                    return 'public/images/profile';
                }
                else {
                    return $result;
                }
            }
            else
            {
                return 'public/images/profile';
            }
        }
        else{
            echo 'network error!';
            exit;
        }
    }

    public function delete_ajax($wall_Id, $type) {
        $statement = $this->db->prepare("Delete wall, $type
                                        From $type
                                        Inner Join wall
                                        Inner Join (
                                                Select wall.ContentId
                                                From wall
                                                Where wall.Id = '$wall_Id') table1
                                        Where ". $type .".Id = table1.ContentId AND wall.Id = '$wall_Id'
                                        ");
        $success = $statement->execute();
        
        if ($success) {
            return SUCCESS;
        } else {
            return FAIL;
        }
    }

    public function post_ajax($username, $type) {
        $query_whereId = $this->db->select(array("Id"), "users", array("login"), array($username));
        $row = $query_whereId->fetchAll();
        $whereId = $row[0]['Id'];

        if($type == STATUS)
        {
            $this->db->insert("status", array("UId", "Status", "Privacy"), array(Session::get('userId'), $_POST['post-text'], $_POST['privacy']));
            $statement2 = $this->db->insert("wall", array("whereId", "ContentId", "Type"), array($whereId, $this->db->lastInsertId(), $type));
            $wallId = $this->db->lastInsertId();
            return json_encode($this->formatter($wallId, Session::get('username'), Session::get('profile_pic'), $_POST['post-text'], $type, date("Y-m-d h:i:s"), $_POST['privacy'], '[]'));
        }
        elseif($type == COMMENT)
        {
            $this->db->insert("comment", array("UId", "Comment"), array(Session::get('userId'), $_POST['comment-post']));
            $statement2 = $this->db->insert("wall", array("ContentId", "Type", "PId"), array($this->db->lastInsertId(), $type, $_POST['contentId']));
            $wallId = $this->db->lastInsertId();
            
            return json_encode(json_decode($this->commentFormatter(Session::get('username'), $_POST['comment-post'], $wallId, date("Y-m-d h:i:s"), Session::get('profile_pic')), true));
            //return json_encode('{"Comment": ' . $this->get_comment($_POST['contentId']) . '}');
        }
    }
    
    public function get_wall($username)
    {
        $result = array();
        $statement = $this->db->prepare("Select users.login, users.Profile_pic, table2.UId, table2.Date, table2.Id, table2.Content, table2.Type, table2.Privacy
                                        From (
                                                Select 
                                                    wall.Type, wall.Id,
                                                    case wall.Type
                                                        when 'status' then status.UId
                                                        when 'image' then image.UId
                                                    end as UId,
                                                    case wall.Type
                                                        when 'status' then status.Date
                                                        when 'image' then image.Date
                                                    end as Date,
                                                    case wall.Type
                                                        when 'status' then status.Status
                                                        when 'image' then image.URL
                                                    end as Content,
                                                    case wall.Type
                                                        when 'status' then status.Privacy
                                                        when 'image' then image.Privacy
                                                    end as Privacy
                                                From wall
                                                Inner join (
                                                                Select users.Id
                                                                From users
                                                                Where users.login = '$username'
                                                            ) table1
                                                    On table1.Id = wall.whereId

                                                left outer join status
                                                    On  wall.ContentId = status.Id
                                                left outer join  image
                                                    On  wall.ContentId = image.Id
                                            ) table2
                                        Inner join users
                                            On users.Id = table2.UId
                                        
                                        ORDER BY table2.Date DESC
                                                ");

        $success = $statement->execute();
        
        if ($success) {
            $query = $statement->fetchAll();

            foreach ($query as $row) {
                $comments = $this->get_comment($row['Id']);
                array_push($result, $this->formatter(
                        $row['Id'], $row['login'], $row['Profile_pic'], $row['Content'], $row['Type'], $row['Date'], $row['Privacy'], $comments
                        ));
            }
        } else {
            echo 'Error occurred while getting Wall!<br /><br />';
            print_r($statement);
            exit;
        }

        return $result;
    }

    public function get_status($username) {
        $result = array();
        $statement = $this->db->prepare("Select users.login, table2.status, table2.date, table2.privacy, table2.id, users.Profile_pic, table2.type
                                        From (
                                                Select status.status, status.UId, status.date, status.privacy, wall.id, wall.type
                                                From wall
                                                Inner join (
                                                                Select users.Id
                                                                From users
                                                                Where users.login = '$username'
                                                            ) table1
                                                    On table1.Id = wall.whereId
                                                Inner join status
                                                    On wall.ContentId = status.Id
                                                Where wall.Type = 'status'
                                            ) table2
                                        Inner join users
                                            On users.Id = table2.UId
                                        ORDER BY table2.date DESC
                                                ");

        $success = $statement->execute();
        
        if ($success) {
            $query = $statement->fetchAll();

            foreach ($query as $row) {
                $comments = $this->get_comment($row['id']);
                array_push($result, $this->formatter(
                        $row['id'], $row['login'], $row['Profile_pic'], $row['status'], $row['type'], $row['date'], $row['privacy'], $comments
                        ));
            }
        } else {
            echo 'Error occurred while getting status from db';
            exit;
        }

        return $result;
    }
    
    public function get_status_ajax() {
        $result = '[';
        $statement = $this->db->prepare("Select users.login, table2.status, table2.date, table2.privacy, table2.id, users.Profile_pic, table2.type
                                        From (
                                                Select status.status, status.UId, status.date, status.privacy, wall.id, wall.type
                                                From wall
                                                Inner join status
                                                    On wall.ContentId = status.Id
                                                Where wall.Type = 'status'
                                            ) table2
                                        Inner join users
                                            On users.Id = table2.UId
                                        ORDER BY table2.date DESC
                                                ");

        $success = $statement->execute();
        
        if ($success) {
            $query = $statement->fetchAll();

            $last = count($query) - 1;
            $count = 0;
            foreach ($query as $row) {
                $comments = $this->get_comment($row['id']);
                $result .= json_encode($this->formatter(
                        $row['id'], $row['login'], $row['Profile_pic'], $row['status'], $row['type'], $row['date'], $row['privacy'], $comments
                        ));
                if (end($query) != $row)
                {
                    $result .= ', ';
                }
            }
        } else {
            echo 'Error occurred while getting status ajax from db';
            exit;
        }

        return $result . ']';
    }
    
    public function get_image_ajax() {
        $result = '[';
        $statement = $this->db->prepare("Select users.login, table2.URL, table2.date, table2.privacy, table2.id, users.Profile_pic, table2.type
                                        From (
                                                Select image.URL, image.UId, image.Date, image.privacy, wall.Id, wall.Type
                                                From wall
                                                Inner join image
                                                    On wall.ContentId = image.Id
                                                Where wall.Type = 'image'
                                            ) table2
                                        Inner join users
                                            On users.Id = table2.UId
                                        ORDER BY table2.date DESC
                                                ");

        $success = $statement->execute();
        
        if ($success) {
            $query = $statement->fetchAll();

            $last = count($query) - 1;
            $count = 0;
            foreach ($query as $row) {
                $comments = $this->get_comment($row['id']);
                $result .= json_encode($this->formatter(
                        $row['id'], $row['login'], $row['Profile_pic'], $row['URL'], $row['type'], $row['date'], $row['privacy'], $comments
                        ));
                if (end($query) != $row)
                {
                    $result .= ', ';
                }
            }
        } else {
            echo 'Error occurred while getting status ajax from db';
            exit;
        }

        return $result . ']';
    }
    
    public function get_comment($PId) 
    {
        $statement = $this->db->prepare("Select users.login, table1.Comment, table1.Date, table1.Id, users.Profile_pic
                                        From (
                                                Select wall.Id, comment.Comment, comment.UId, comment.Date
                                                From wall
                                                Inner join comment
                                                    On wall.ContentId = comment.Id
                                                Where wall.PId = $PId
                                            ) table1
                                        Inner join users
                                            On users.Id = table1.UId
                                        ORDER BY table1.date ASC
                                                ");
        $success = $statement->execute();
        
        if (!$success) {
            echo "PID: $PId <br /><br />";
            echo "Get Comment Error in model!  (code:1123)<br /><br />";
            echo print_r($statement);
            exit;
        }
        
        $result = '[';
        $query = $statement->fetchAll();

        $numItems = count($query);
        $i = 0;
        foreach ($query as $row) {
            $result .= $this->commentFormatter($row['login'], $row['Comment'], $row['Id'], $row['Date'], $row['Profile_pic']);
            
            if(++$i !== $numItems) {
                $result .= ', ';
            }
        }
        $result .= ']';
        
        /*
        echo 'PID:  ' . $PId . '<br/><br/>';
        echo '# of query:  ' . count($query) . '<br/><br/>';
        echo $result;
        */
        
        return $result;
    }
    
    private function commentFormatter($commentor, $comment, $commentId, $Date, $profile_pic)
    {
        if (isset($profile_pic) && !empty($profile_pic) && file_exists(substr(URL . $profile_pic, 43) . "_original.jpg") == true) {
            $profile_pic = URL . $profile_pic . "_small.jpg";
        }
        else {
            $profile_pic = DEFAULT_PROFILE_PIC_SMALL;
        }
        
        $delete = null;
        if($commentor == Session::get('username'))
        {
            $delete = 'fi-trash';
        }
            
        return '{
                    "Commentor": "' . $commentor . '",
                    "Comment": "' . $comment . '",
                    "CommentId": "' . $commentId . '",
                    "Date": "' . $Date . '",
                    "Profile_pic": "' . $profile_pic . '",
                    "Delete": "' . $delete . '"
                }';
    }

    /**
     * @param int $id           Wall Id
     * @param string $writer    Name of writer
     * @param string $post      Post context
     * @param array $commentors List of commentors    
     * @param array $comments   List of comments
     */
    private function formatter($id, $writer, $profile_pic, $post, $type, $date, $privacy, $comments = null) 
    {
        $post = preg_replace("/[\r\n]{2,}/", "\\n", $post);

        if ($writer == Session::get('username')) {
            $delete = 'fi-trash';
        } 
        else {
            $delete = '';
        }
        
        if ($type == IMAGE)
        {
            $post .= "_large.jpg";
        }
        
        if (isset($profile_pic) && !empty($profile_pic) && file_exists(substr(URL . $profile_pic, 43) . "_original.jpg") == true) {
            $profile_pic_medium = URL . $profile_pic . "_medium.jpg";
            $profile_pic_small = URL . $profile_pic . "_small.jpg";
        }
        else {
            $profile_pic_medium = DEFAULT_PROFILE_PIC_MEDIUM;
            $profile_pic_small = DEFAULT_PROFILE_PIC_SMALL;
        }

        switch ((int) $privacy) {
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
                        "id": "' . $id . '",
                        "profile_pic_medium": "'. $profile_pic_medium . '",
                        "profile_pic_small": "'. $profile_pic_small . '",
                        "Writer": "' . $writer . '",
                        "Post": "' . $post . '",
                        "Type": "' . $type . '",
                        "Date": "' . $date . '",
                        "Privacy": "' . $privacy_icon . '",
                        "Privacy_description": "' . $description . '",
                        "Delete": "' . $delete . '"';
        if($comments != null || $comments != '[]')
        {
            $result .= ', "Comments": ';
            $result .= $comments;
        }
        
        $result .=  ' }';
        
        /*
        echo 'Comments: ' . $comments . '<br /><br /><br />';
        echo 'Raw Result: ' . $result . '<br /><br /><br />';
        echo 'Dedoed Result: ';
        print_r(json_decode($result, true));
        exit;
        */
        return json_decode($result, true);
    }

    public function profile_image($username) {
        $x_val = $_POST["x_val"];
        $y_val = $_POST["y_val"];
        $width_val = $_POST["width"];
        $height_val = $_POST["height"];

        $image_info = getimagesize($_FILES["file"]["tmp_name"]);

        if ($image_info[2] == IMAGETYPE_GIF || $image_info[2] == IMAGETYPE_JPEG || $image_info[2] == IMAGETYPE_PNG) {
            $date = date("Ymdhisu");
            $img_path = "public/images/image/" . $date . "_" . $username;
            $src = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
            $large = imagecreatetruecolor(300, 300);
            $medium = imagecreatetruecolor(80, 80);
            $small = imagecreatetruecolor(50, 50);
            $xsmall = imagecreatetruecolor(40, 40);

            imagecopyresampled($large, $src, 0, 0, $x_val, $y_val, 300, 300, $width_val, $height_val);
            imagecopyresampled($medium, $src, 0, 0, $x_val, $y_val, 80, 80, $width_val, $height_val);
            imagecopyresampled($small, $src, 0, 0, $x_val, $y_val, 50, 50, $width_val, $height_val);
            imagecopyresampled($xsmall, $src, 0, 0, $x_val, $y_val, 40, 40, $width_val, $height_val);
            
            imagejpeg($src, $img_path . "_original.jpg", 100);
            imagejpeg($large, $img_path . "_large.jpg", 100);
            imagejpeg($medium, $img_path . "_medium.jpg", 100);
            imagejpeg($small, $img_path . "_small.jpg", 100);
            imagejpeg($xsmall, $img_path . "_xsmall.jpg", 100);

            imagedestroy($src);
            imagedestroy($large);
            imagedestroy($medium);
            imagedestroy($small);
            imagedestroy($xsmall);

            Session::set('profile_pic', $img_path);

            $this->db->update('users', array('Profile_pic'), array($img_path), array('login'), array($username));
            $this->db->insert('image', array('UId', 'URL', 'Privacy'), array(Session::get('userId'), URL . "public/images/image/" . $date . "_" . $username, PUBLIC_POST));
            $success = $this->db->insert('wall', array('WhereId', 'Type', 'ContentId'), array(Session::get('userId'), IMAGE, $this->db->lastInsertId()));
            
            if ($success) {
                $full_path = URL . $img_path;
                return $full_path . "_large.jpg" . "," . $full_path . "_medium.jpg" . "," . $full_path . "_small.jpg," . $full_path . "_xsmall.jpg";
            }
        } else {
            return "Error occurred while inserting image URL into the db!";
        }
    }

}
