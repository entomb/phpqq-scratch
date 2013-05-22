<?php


Class phpQQclient {


    static $run    = false;
    static $server = false;
    static $key    = false;
    static $block  = false;



    static function start($server,$key){
        if(!self::$run){
            self::$run = self::__startRun($key);
        }

        set_error_handler("QQErrorHandler");

        self::$server = $server;
        self::$key    = $key;

        self::block('qq');
    }

    static function error($data=null,$id=0){
        self::event('error',$data,$id);
    }
    static function warning($data=null,$id=0){
        self::event('warning',$data,$id);
    }
    static function notice($data=null,$id=0){
        self::event('notice',$data,$id);
    }
    static function info($data=null,$id=0){
        self::event('info',$data,$id);
    }

    static function event($event=null,$data=null,$id=null){
        if(!self::$run){
            return false;
        }
        self::$run->addEvent(self::$block,$event,$data,$id);
    }

    static function block($block="qq",$_state = true){
        if(!self::$run){
            return false;
        }
        $event = $_state ? "start" : "end";
        if($_state){
            self::$block = $block;
            self::event($block,$event);
        }else{
            self::event($block,$event);
            self::$block = 'qq';
        }

    }

    static function close(){
        if(!self::$run){
            return false;
        }

        self::block('qq',false);
        self::__endRun();
        self::__logRun();
    }

    static function __startRun($key){
        if(!self::$run){
          self::$run = new phpQQrun($key);
        }
        self::$run->setStartTime();
        return self::$run;
    }

    static function __endRun(){
        if(!self::$run){
          return false;
        }
        self::$run->setEndTime();
        return self::$run;
    }

    static function __logRun(){
        if(!self::$run){
            return false;
        }

        $payloadFull = json_encode((array)self::$run);

        $curl = curl_init(self::$server."/api/log/".self::$key);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //curl_setopt($curl, CURLOPT_USERPWD, "musicprivatebox:mailerMBauth");
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payloadFull);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $raw_response = curl_exec($curl);
        $json_response = json_decode($raw_response);

        if(isset($json_response->code) && $json_response->code==200){
            return true;
        }

    }


}


function QQErrorHandler($errID, $errStr, $errFile, $errLine) {
    $errorData = array(
                'msg'   => $errStr,
                'file'  => $errFile,
                'line'  => $errLine,
            );
    switch ($errID) {
        case E_USER_ERROR:
            phpQQclient::error($errorData);
            phpQQclient::close();
            exit();
            break;

        case E_USER_WARNING:
            phpQQclient::warning($errorData);
            break;

        case E_USER_NOTICE:
            phpQQclient::notice($errorData);
            break;
        default:
            phpQQclient::error($errorData);
            break;
    }
    return true;
}