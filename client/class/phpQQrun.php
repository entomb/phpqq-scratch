<?php

class phpQQrun {

    var $key        = false;
    var $start_time = false;
    var $end_time   = false;

    var $_SERVER = array();
    var $_ENV    = array();
    var $_GET    = array();
    var $_POST   = array();


    var $_EVENT = array();

    function __construct($key=null){
        if(!$key || empty($key)){
            return false;
        }

        $this->key = (string)$key;


        $this->_SERVER    = @$_SERVER;
        $this->_ENV       = @$_ENV;
        $this->_GET       = @$_GET;
        $this->_POST      = @$_POST;
        $this->_SESSION   = @$_SESSION;

    }

    function setEndTime(){
        $this->end_time = $this->_microtime();
    }

    function setStartTime(){
        $this->start_time = $this->_microtime();
    }

    private function _microtime(){
        return microtime(true);
        //list($usec, $sec) = explode(" ", microtime());
        //return ((float)$usec + (float)$sec);
    }

    function addEvent($block='qq',$event=null,$value=null,$id=0){
        $this->_EVENT[] = array(
                            'block' => $block,
                            'time'  => $this->_microtime(),
                            'event' => $event,
                            'value' => $value,
                            'id' => $id,
                        );
        return $this;
    }

}