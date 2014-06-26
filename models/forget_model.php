<?php
/**
 * @author Seungchul Lee, Jiwwong Yoon
 */

class Forget_Model extends Model {
    
    function __construct() 
    {
        parent::__construct();
    }

    public function askPassword()
    {
        if($this->email_checker($_POST['email']))
        {
            $password = $this->randomPasswordGenetator(32);
            $to  = $_POST['email'];
            $subject = 'Password Reset';
            $message = '<html>
                        <head>
                          <title>Password Reset</title>
                        </head>
                        <body>
                          <p>Your new password: '.
                          $password
                         .'</p>
                        <a href="https://github.com/sclee8611/CustomizedSocialPage">Go To Website</a>
                        </body>
                        </html>';

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'Reply-To: Admin<' . ADMIN_EMAIL . ">\r\n";

            $success = mail($to, $subject, $message, $headers);
            header('location: ../forget/success');
            exit;
        }
        else
        {
            header('location: ../forget/fail');
            exit;
        }
    }
    
    private function email_checker($email = null)
    {
        $state = $this->db->prepare("SELECT id FROM users WHERE email = :email");
        $state->execute(array(
            ':email' => $email
        ));
        
        $count = $state->rowCount();
        if($count > 0)
        {
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