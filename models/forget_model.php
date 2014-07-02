<?php
/**
 * @author Seungchul Lee, Jiwoong Yoon
 */

class Forget_Model extends Model {
    
    var $email;
    
    function __construct() 
    {
        parent::__construct();
    }

    public function askPassword()
    {
        if($this->email_checker($_POST['email']))
        {   
            $this->email = $_POST['email'];
            $reset_code = $this->randomPasswordGenetator(32);
            $to  = $_POST['email'];
            $subject = 'Password Reset';
            $message = '<html>
                        <head>
                          <title>Password Reset From</title>
                        </head>
                        <body>
                          <p>You\'ve sent passowrd request. If you did\'n request, please ignore this email</p>
                          <p>Your Reset Code: <strong>'.
                          $reset_code
                         .'</strong></p>
                        </body>
                        </html>';

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'Reply-To: Admin<' . ADMIN_EMAIL . ">\r\n";
            mail($to, $subject, $message, $headers);
            
            $this->resetCode($reset_code);
            header('location: ../forget/success');
            //$success = mail($to, $subject, $message, $headers);
//            if ($success) {
//                $this->resetCode($reset_code);
//                header('location: ../forget/success');
//            }
//            else
//            {
//                header('location: '. URL .'index');
//            }
            exit;
        }
        else
        {
            header('location: ../forget/fail');
            exit;
        }
    }
    
    public function resetPassword()
    {
        $state = $this->db->prepare("UPDATE users SET password = :password, reset = :new WHERE reset = :reset");
        $state->execute(array(
            ':password' => md5($_POST['new_password']),
            ':new' => null,
            ':reset' => $_POST['reset']
        ));
        
        header('location: '. URL);
    }
    
    private function resetCode($reset_code = null)
    {
        $state = $this->db->prepare("UPDATE users SET reset = :reset WHERE email = :email");
        $state->execute(array(
            ':reset' => $reset_code,
            ':email' => $this->email
        ));
    }
    
    private function email_checker($email = null)
    {
        if (empty($email) || !isset($email))
        {
            return false;
        }
        
        $database = new Database();
        $dbname = "users";
        $statement = $database->select(array("id"), $dbname, array("email"), array($email));
        if(!$statement)
            return false;
        
        /*
        $state = $this->db->prepare("SELECT id FROM users WHERE email = :email");
        $state->execute(array(
            ':email' => $email
        ));
        */        

        $count = $statement->rowCount();
        if($count > 0)
        {
            // change password in db            
            return true;
        }
        
        return false;
    }
    
    private function randomPasswordGenetator($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
}