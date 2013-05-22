<?php


class phpQQrun {

    var $run_id = false;
    var $start_time = false;
    var $end_time   = false;

    var $_SERVER = array();
    var $_ENV    = array();
    var $_GET    = array();
    var $_POST   = array();


    var $_EVENT = array();

    function __construct($runObject){

        $this->run_id     = $runObject->qq_run_id;
        $this->start_time = $runObject->time_start;
        $this->end_time   = $runObject->time_end;


        $this->_SERVER = json_decode($runObject->_SERVER);
        $this->_ENV    = json_decode($runObject->_ENV);
        $this->_GET    = json_decode($runObject->_GET);
        $this->_POST   = json_decode($runObject->_POST);

        //calculations
        $this->str_start_time = Date('d-m-Y h:i:s',$this->start_time);
        $this->str_end_time   = Date('d-m-Y h:i:s',$this->end_time);

        $this->float_start_time = (float)$this->start_time;
        $this->float_end_time   = (float)$this->end_time;


        $this->duration_time = ($this->float_end_time - $this->float_start_time);
        $this->str_duration_time = round($this->duration_time,3);


        $this->_loadEvents();

    }


    /**
     * GETERS
     */
    function isHTTP(){
        return isset($this->_SERVER->HTTP_HOST);
    }

    function server($index=false){
        if($index){
            return $this->_getVar('_SERVER',$index);
        }else{
            return $this->_SERVER;
        }
    }

    function env($index=false){
        if($index){
            return $this->_getVar('_ENV',$index);
        }else{
            return $this->_ENV;
        }
    }

    function get($index=false){
        if($index){
            return $this->_getVar('_GET',$index);
        }else{
            return $this->_GET;
        }
    }

    function post($index=false){
        if($index){
            return $this->_getVar('_POST',$index);
        }else{
            return $this->_POST;
        }
    }


    private function _getVar($key,$index){
        if(isset($this->{$key}) && isset($this->{$key}->{$index})){
            return $this->{$key}->{$index};
        }else{
            return false;
        }
    }


    /**
     * LOADERS
     */

    private function _loadEvents(){
        if(!$this->run_id) return false;
        if($this->_EVENT) return $this->_EVENT;


        $Events = DB::mysql()->query("SELECT *
                                       FROM qq_run_event
                                      WHERE qq_run_id = ?",array($this->run_id))->fetchAll();

        $this->_EVENT = $Events;
        return $Events;
    }



}

