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
        $dbname = "users";
        $statement = $this->db->update($dbname, array("password", "reset"), 
            array(md5($_POST['new_password']), null), array("reset"), array($_POST['reset']));
        if(!$statement)
            return false;

        header('location: '. URL);
    }
    
    private function resetCode($reset_code = null)
    {
        $dbname = "users";
        $statement = $this->db->update($dbname, array("reset"), array($reset_code), array("email"), array($this->email));
        if(!$statement)
            return false;
    }
    
    private function email_checker($email = null)
    {
        if (empty($email) || !isset($email))
        {
            return false;
        }
        
        $dbname = "users";
        $statement = $this->db->select(array("id"), $dbname, array("email"), array($email));
        if(!$statement)
            return false;    

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