<?php
/**
 * @author Seungchul
 * @date   July 5, 2014
 */

class Index_Model extends Model {

    function __construct() 
    {
        parent::__construct();
    }
    
    public function checkReturnUser()
    {
        $key = pack("H*", MYKEY);
        $rememberMe = new RememberMe($key);

        if ($data = $rememberMe->auth()) 
        {
            $rememberMe->remember($data['user']);
            Session::set('loggedIn', true);
            Session::set('username', $data['user']);
            $query_whereId = $this->db->select(array("Id"), "users", array("login"), array($data['user']));
            $row =$query_whereId->fetchAll();
            $whereId = $row[0]['Id'];
            Session::set('userId', $whereId);
            Session::set('profile_pic', $this->get_profile_url($data['user']));
            return true;
        } 
        else
        {
            return false;
        }
    }

    public function login($login, $password)
    {
        if(empty($login) && empty($_POST['login']))
        {
            header('location: '.URL);
            exit;
        }
        elseif(!empty($_POST['login']))
        {
            $login = $_POST['login'];
            $password = $_POST['password'];
        }

        $statement = $this->db->select(array("id"), "users", array("login", "password"), array($login, MD5($password)));
        
        if(!$statement){
            throw new Exception('Query failed.');
        }
        
        if($statement->rowCount() > 0)
        {
            $row = $statement->fetchAll();
            $whereId = $row[0]['id'];
            Session::set('loggedIn', true);
            Session::set('username', $login);
            Session::set('userId', $whereId);
            Session::set('profile_pic', $this->get_profile_url($login));
            
            if (!empty($_POST['keep_loggedIn']) || isset($_POST['keep_loggedIn']))
            {
                $key = pack("H*", MYKEY); 
                $rememberMe = new RememberMe($key);
                $rememberMe->remember($login);
            }
            
            #$this->view->login_failed = false;
            header('location: '.URL);
        }
        else
        {
            #header('location: '.URL);
            return false;
        }
    }
    
    public function get_profile_url($username) {
        $query = $this->db->select(array('Profile_pic'), "users", array("login"), array($username));
        if ($query) {
            $row =$query->fetchAll();
            $result = $row[0]['Profile_pic'];
            
            if (!isset($result) || empty($result) || !file_exists($result . '_large.jpg')) {
                return 'public/images/profile';
            }
            else {
                return $result;
            }
        }
        else{
            echo 'network error!';
            exit;
        }
    }
    
    public function logout()
    {
        $this->db->update("users", 
                        array("remember_info"), 
                        array(null), 
                        array("login"), 
                        array(Session::get('username')));
        
        Cookie::remove('auto');
        
        Session::destroy();
        header('location: '.URL);
        exit;
    }
    
    public function get_wall()
    {
        $get_minId_statement = $this->db->prepare("SELECT MIN(id) AS min FROM wall");
        $get_minId_statement->execute();
        $query_minId = $get_minId_statement->fetchAll();
        $lastId = $query_minId[0]['min'];
        Session::set('lastId', $lastId);
        
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
                                                left outer join status
                                                    On  wall.ContentId = status.Id
                                                left outer join  image
                                                    On  wall.ContentId = image.Id
                                            ) table2
                                        Inner join users
                                            On users.Id = table2.UId
                                        ORDER BY table2.Date DESC
                                        LIMIT 4
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
    
    public function signup() 
    {
        if ($this->check_available(array('login', 'email'), array($_POST['username'], $_POST['email']))) 
        {
            $dbname = "users";
            $statement = $this->db->insert($dbname, array('login', 'password', 'email'), 
                array($_POST['username'], md5($_POST['password']), $_POST['email']));
            if(!$statement){
                throw new Exception('Query failed.');
            }

            if ($statement->errorCode()) 
            {
                Session::set('loggedIn', true);
                header('location: ' . URL . 'index/login/' . $_POST['username'] . '/' . $_POST['password']);
            } 
            else 
            {
                echo 'error';
            }
        }
    }

    private function check_available($attrNames, $attrValues) 
    {
        $dbname = "users";
        $statement = $this->db->select(array("id"), $dbname, $attrNames, $attrValues, "or");
        if(!$statement){
            throw new Exception('Query failed.');
        }

        $count = $statement->rowCount();
        if ($count == 0) 
        {
            return true;
        } 
        else 
        {
            // increment fail cnt
            require 'controllers/error.php';
            $controller = new Error();
            $controller->signup_error("This username or email already exists");
            exit;
        }
    }
}