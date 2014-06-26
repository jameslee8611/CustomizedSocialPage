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
        
        if($success){
            header('location: ../forget/success');
        }
        else{
            header('location: ../forget/fail');
        }
    }
    
    private function email_checker($email = null)
    {
        // db check
        
        return false;
    }
    
    private function randomPasswordGenetator($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
}