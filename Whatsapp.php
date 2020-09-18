<?php



define('ACCOUNT','xxxxxxxxxxxxxxxxxxxxxxx');
define('TOKEN','xxxxxxxxxxxxxxxxxxxxxxx');
define('FROM','+919876543210');

require __DIR__ . '/twilio-php-main/src/Twilio/autoload.php';
use Twilio\Rest\Client; 

class Whatsapp
{
    protected $twilio;
    protected $message;
    function __construct()
    {        
        $this->twilio = new Client(ACCOUNT, TOKEN);  
    }
    function send($msg=null,$sending_to=null){
        $this->message = $this->twilio->messages 
        ->create("whatsapp:$sending_to",
                 array( 
                     "from" => "whatsapp:".FROM,       
                     "body" => $msg 
                 ) 
        ); 
        return $this->message;
    }
}
?>