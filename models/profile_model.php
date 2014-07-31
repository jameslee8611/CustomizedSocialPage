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

    public function delete_ajax($wall_Id) {
        $statement = $this->db->prepare("Delete wall, status
                            From status
                            Inner Join wall
                            Inner Join (
                                    Select wall.ContentId
                                    From wall
                                    Where wall.Id = '$wall_Id') table1
                            Where status.Id = table1.ContentId AND wall.Id = '$wall_Id'
                            ");
        $success = $statement->execute();
        if ($success) {
            return SUCCESS;
        } else {
            return FAIL;
        }
    }

    public function post_ajax($username, $from, $type) {
        if (!isset($from) || empty($from)) {
            $query_whereId = $this->db->select(array("Id"), "users", array("login"), array($username));
            $row = $query_whereId->fetchAll();
            $whereId = $row[0]['Id'];

            $this->db->insert("status", array("UId", "Status", "Privacy"), array(Session::get('userId'), $_POST['post-text'], $_POST['privacy']));
            $statement2 = $this->db->insert("wall", array("whereId", "ContentId", "Type"), array($whereId, $this->db->lastInsertId(), $type));

            $wallId = $this->db->lastInsertId();
        }

        if ($statement2->rowCount() > 0) {
            return json_encode($this->formatter($wallId, Session::get('username'), Session::get('profile_pic'), $_POST['post-text'], date("Y-m-d h:i:s"), $_POST['privacy']));
        } else {
            echo "Network Connection fails";
            exit;
        }
    }
    
    public function get_profile_url($username) {
        $query = $this->db->select(array('Profile_pic'), "users", array("login"), array($username));
        if ($query) {
            $row =$query->fetchAll();
            $result = $row[0]['Profile_pic'];
            
            if (!isset($result) || empty($result) || !file_exists(substr($result, 43) . '_large.jpg')) {
                return DEFAULT_PROFILE_PIC_LARGE;
            }
            else {
                $result .= '_large.jpg';
                return $result;
            }
        }
        else{
            echo 'network error!';
            exit;
        }
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
                                                    Where users.login = '$username') table1
                                                On table1.Id = wall.whereId
                                            Inner join status
                                                On wall.ContentId = status.Id) table2
                                        Inner join users
                                            On users.Id = table2.UId
                                        ORDER BY table2.date DESC
                                                ");

        $success = $statement->execute();
        
        if ($success) {
            $query = $statement->fetchAll();

            foreach ($query as $row) {
                array_push($result, $this->formatter($row['id'], $row['login'], $row['Profile_pic'], $row['status'], $row['type'], $row['date'], $row['privacy']));
            }
        } else {
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
    private function formatter($id, $writer, $profile_pic, $post, $type, $date, $privacy, $commentors = null, $commentor_url = null, $comments = null) {
        if (count($commentors) != count($comments)) {
            return NULL;
        }

        $post = preg_replace("/[\r\n]{2,}/", "\\n", $post);

        if ($writer == Session::get('username')) {
            $delete = 'fi-trash';
        } 
        else {
            $delete = '';
        }
        
        if (isset($profile_pic) && !empty($profile_pic) && file_exists(substr($profile_pic, 43) . "_original.jpg") == true) {
            $profile_pic_large = $profile_pic . "_large.jpg";
            $profile_pic_medium = $profile_pic . "_medium.jpg";
            $profile_pic_small = $profile_pic . "_small.jpg";
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
                        "Delete": "' . $delete . '",
                        "Comments": 
                        [';
        for ($i = 0; $i < count($commentors); $i++) {
            $result .= '{"Writer": "' . $commentors[$i] . '", "Comment": "' . $comments[$i] . '"}';
            if ($i + 1 != count($commentors)) {
                $result .= ', ';
            }
        }
        $result .= ']
                    }';
        
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

            imagecopyresampled($large, $src, 0, 0, $x_val, $y_val, 300, 300, $width_val, $height_val);
            imagecopyresampled($medium, $src, 0, 0, $x_val, $y_val, 80, 80, $width_val, $height_val);
            imagecopyresampled($small, $src, 0, 0, $x_val, $y_val, 50, 50, $width_val, $height_val);
            
            imagejpeg($src, $img_path . "_original.jpg", 100);
            imagejpeg($large, $img_path . "_large.jpg", 100);
            imagejpeg($medium, $img_path . "_medium.jpg", 100);
            imagejpeg($small, $img_path . "_small.jpg", 100);

            imagedestroy($src);
            imagedestroy($large);
            imagedestroy($medium);
            imagedestroy($small);

            Session::set('profile_pic', URL . $img_path);

            $statement = $this->db->update('users', array('Profile_pic'), array(URL . "public/images/image/" . $date . "_" . $username), array('login'), array($username));
            $success = $statement->execute();
            
            if ($success) {
                $full_path = URL . $img_path;
                return $full_path . "_large.jpg" . "," . $full_path . "_medium.jpg" . "," . $full_path . "_small.jpg";
            }
        } else {
            return "Invalid File Type!";
        }
    }

}
