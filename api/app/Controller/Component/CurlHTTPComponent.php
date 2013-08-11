<?php

App::uses('Component', 'Controller');

class CurlHTTPComponent extends Component {

    public function Post($url, $datastring, $referer, $useProxy = 1) {

        $proxies = array(
            '190.52.38.92:8080',
            '118.97.95.174:8080',
            '210.101.131.231:8080',
            '118.97.95.174:8080'
        );
    
        $proxy = $proxies[array_rand($proxies)];
        $proxy = explode(':', $proxy);
        $proxy_ip = $proxy[0];
        $proxy_port = $proxy[1];

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_REFERER, "");
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:17.0) Gecko/20100101 Firefox/17.0");
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $datastring);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);



        if($useProxy){
            //set proxy options
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
            curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
            curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
        }
        
        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        CakeLog::write('activity', 'curl (POST) used proxy '.$proxy_ip.':'.$proxy_port);
        if($result == ''){
            CakeLog::write('activity', 'curl (POST) had empty output');


        }

        return $result;
    }
    
    public function Get($url, $useProxy = 1) {

        $proxies = array(
            '190.52.38.92:8080',
            '118.97.95.174:8080',
            '210.101.131.231:8080',
            '118.97.95.174:8080'
        );
    
        $proxy = $proxies[array_rand($proxies)];
        $proxy = explode(':', $proxy);
        $proxy_ip = $proxy[0];
        $proxy_port = $proxy[1];

        // is cURL installed yet?
        if (!function_exists('curl_init')){
            die('Sorry cURL is not installed!');
        }
     
        // OK cool - then let's create a new cURL resource handle
        $ch = curl_init();
     
        // Now set some options (most are optional)
     
        // Set URL to download
        curl_setopt($ch, CURLOPT_URL, $url);
     
        // Set a referer
        curl_setopt($ch, CURLOPT_REFERER, "");
     
        // User agent
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:17.0) Gecko/20100101 Firefox/17.0");
     
        // Include header in result? (0 = yes, 1 = no)
        curl_setopt($ch, CURLOPT_HEADER, 0);
     
        // Should cURL return or print out the data? (true = return, false = print)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        if($useProxy){
            //set proxy options
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
            curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
            curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
        }

     
        // Download the given URL, and return output
        $output = curl_exec($ch);
     
        // Close the cURL resource, and free system resources
        curl_close($ch);
        
        CakeLog::write('activity', 'curl used proxy '.$proxy_ip.':'.$proxy_port);
        if($output == ''){
            CakeLog::write('activity', 'curl had empty output');
        }
        
        return $output;
    }
}


