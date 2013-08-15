<?php 

class UsersController extends AppController {

    public function beforeFilter(){

        //method specific api options -> REST!
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
            header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
            exit();
        }
    }

    public function login() {
        $req_url =  Configure::read('InnAc.req_url');
        $authurl =  Configure::read('InnAc.auth_url');
        $acc_url =  Configure::read('InnAc.acc_url');
        $api_url =  Configure::read('InnAc.api_url');
        $conskey =  Configure::read('InnAc.consumer_key');
        $conssec =  Configure::read('InnAc.consumer_secret');


        // In state=1 the next request should include an oauth_token.
        // If it doesn't go back to 0
        if(isset($_GET['oauth_token'])){header("Location: /");}
        if(!isset($_GET['oauth_token']) && $this->Session->read('state')==1) $this->Session->write('state', 0);
        try {
          $oauth = new OAuth($conskey,$conssec,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
          $oauth->enableDebug();
          if(!isset($_GET['oauth_token']) && !$this->Session->read('state')) {
            $request_token_info = $oauth->getRequestToken($req_url);
            $this->Session->write('secret', $request_token_info['oauth_token_secret']);
            $this->Session->write('state', 1);
            header('Location: '.$authurl.'?oauth_token='.$request_token_info['oauth_token']);
            exit;
          } else if($this->Session->read('state')==1) {
            $oauth->setToken($_GET['oauth_token'],$this->Session->read('secret'));
            $access_token_info = $oauth->getAccessToken($acc_url);
            $this->Session->write('state', 2);
            $this->Session->write('token', $access_token_info['oauth_token']);
            $this->Session->write('secret', $access_token_info['oauth_token_secret']);
          } 
          $oauth->setToken($this->Session->read('token'),$this->Session->read('secret'));
          $oauth->fetch("$api_url/me.json");
          $userRaw = json_decode($oauth->getLastResponse(), 1);
                 if(!is_array($userRaw['picture'])){ 
            $userRaw['picture'] = 'http://1.gravatar.com/avatar/'.md5($userRaw['mail']).'?s=100';
          }else{
            $userRaw['picture'] = Configure::read('InnAc.profilepic_thumb_path').$userRaw['picture']['filename'];
          }


          $userArr = array('user' => array(
            'uid'=>$userRaw['uid'],
            'username' => $userRaw['name'],
            'firstname' => $userRaw['first_name']['und'][0]['safe_value'],
            'lastname' => $userRaw['last_name']['und'][0]['safe_value'],
            'fullname' => $userRaw['first_name']['und'][0]['safe_value'] . ' ' . $userRaw['last_name']['und'][0]['safe_value'],
            'email' => $userRaw['mail'],
            'institution' => $userRaw['institution']['und'][0]['safe_value'],
            'avatar' => $userRaw['picture'],
            'roles' => $userRaw['roles'],
            'position' =>  $userRaw['position']['und'][0]['value'],
            'website' =>  $userRaw['website']['und'][0]['safe_value'],
            'innac_profile' => 'http://inn.ac/user/'.$userRaw['uid']
          ));

          $this->Session->write('User', $userArr);

          echo json_encode($userArr);

        } catch(OAuthException $E) {
          print_r($E);
        }
        exit();
    }




    public function me() {

        if($this->Session->read('User')){

            $me = $this->Session->read('User');
            $me['user']['id'] = 'me';

            echo json_encode($me);
        }else{
            echo '[]';
        }
        
        exit();
    }

    public function view($id) {
        
    }

    public function edit($id) {
     
    }
    
    public function loginexample() {
        $req_url = 'http://inn.ac/oauth/request_token';
        $authurl = 'http://inn.ac/oauth/authorize';
        $acc_url = 'http://inn.ac/oauth/access_token';
        $api_url = 'http://inn.ac/api/v1';
        $conskey = 'uTGoW4Eua5Fa5yGfRTJjPpXSN4xqRzhe';
        $conssec = 'QXshNra8RNj9gnF93k8JcufRP9H32YuH';

        session_start();

        // In state=1 the next request should include an oauth_token.
        // If it doesn't go back to 0
        if(!isset($_GET['oauth_token']) && $_SESSION['state']==1) $_SESSION['state'] = 0;
        try {
          $oauth = new OAuth($conskey,$conssec,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
          $oauth->enableDebug();
          if(!isset($_GET['oauth_token']) && !$_SESSION['state']) {
            $request_token_info = $oauth->getRequestToken($req_url);
            $_SESSION['secret'] = $request_token_info['oauth_token_secret'];
            $_SESSION['state'] = 1;
            header('Location: '.$authurl.'?oauth_token='.$request_token_info['oauth_token']);
            exit;
          } else if($_SESSION['state']==1) {
            $oauth->setToken($_GET['oauth_token'],$_SESSION['secret']);
            $access_token_info = $oauth->getAccessToken($acc_url);
            $_SESSION['state'] = 2;
            $_SESSION['token'] = $access_token_info['oauth_token'];
            $_SESSION['secret'] = $access_token_info['oauth_token_secret'];
          } 
          $oauth->setToken($_SESSION['token'],$_SESSION['secret']);
          $oauth->fetch("$api_url/me.json");
          $json = json_decode($oauth->getLastResponse());
          print_r($json);
        } catch(OAuthException $E) {
          print_r($E);
        }
        exit();
    }


}