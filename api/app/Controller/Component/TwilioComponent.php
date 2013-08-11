<?php

//twilio library
require_once('/var/storage/generic1/www/sites/inn.ac/vijo/api/app/Vendor/Services/Twilio.php');

App::uses('Component', 'Controller');

class TwilioComponent extends Component {

    private $sid = "ACe491d4bd5522e22e77948f0ae6c84bf5";  // Your Account SID from www.twilio.com/user/account
    private $token = "31120f1389c86856e4a4d15cc7aa03d5"; // Your Auth Token from www.twilio.com/user/account
    private $twilio_tel = '+41435081826';

    public function Call($say, $tel) {

        $client = new Services_Twilio($this->sid, $this->token);
        $call = $client->account->calls->create(
          $this->twilio_tel, // From a valid Twilio number
          $tel, // Call this number
          'http://twimlets.com/message?Message='.urlencode($say)
        );

        print $call->sid;
    }

    public function SendSMS($text, $tel){
        $client = new Services_Twilio($this->sid, $this->token);

        $sms = $client->account->sms_messages->create(
                    $this->twilio_tel,
                    $tel,
                    $text
        );

        return true;
    }
}


