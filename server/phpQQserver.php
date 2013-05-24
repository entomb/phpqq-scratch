<?php


Class phpQQserver {


    static $version = "0.1beta";

    static function log($qq_server_id,$payload){

        $insertData  = array(
                        'qq_server_id'   => (int)$qq_server_id,
                        'payload'        => (string)$payload,
                        'date_created'   => (object)"NOW()",
                        'flag_processed' => 0,
                    );

        $insertOk = DB::mysql()->insert('qq_server_payload',$insertData);

        if($insertOk){
            return $insertOk;
        }else{
            return false;
        }
    }

    static function process($qq_server_id){

        $check = DB::mysql()->query("SELECT qq_server_payload_id
                                       FROM qq_server_payload
                                      WHERE qq_server_id = ?
                                      AND flag_processed = 0
                                      ORDER BY qq_server_payload_id ASC
                                      LIMIT 1",array($qq_server_id));
        if($check->num_rows==0){
            return 0;
        }else{
            if($payload = $check->fetch()){
                return self::processPayload($payload->qq_server_payload_id);
            }else{
                false;
            }
        }


    }



    static function processPayload($qq_server_payload_id){
        $check = DB::mysql()->query("SELECT *
                                       FROM qq_server_payload
                                      WHERE qq_server_payload_id = ?
                                      LIMIT 1",array($qq_server_payload_id));
        $row = $check->fetch();

        $payload = json_decode($row->payload);
        $qq_server_id = (int)$row->qq_server_id;

        $qq_run_id = DB::mysql()->insert('qq_run',array(
                                        'qq_server_id' => $qq_server_id,
                                        'time_start'   => (string)@$payload->start_time,
                                        'time_end'     => (string)@$payload->end_time,
                                        '_SERVER'      => json_encode(@$payload->_SERVER),
                                        '_POST'        => json_encode(@$payload->_POST),
                                        '_GET'         => json_encode(@$payload->_GET),
                                        '_ENV'         => json_encode(@$payload->_ENV),
                                    )
                                );

        if(!$qq_run_id){
            //invalid run
            return false;
        }


        foreach($payload->_EVENT as $event){
            if(is_object($event->value)){
                $value = json_encode($event->value);
            }else{
                $value = (string)$event->value;
            }
            $newEvent = array(
                            'qq_run_id' => $qq_run_id,
                            'block' => (string)$event->block,
                            'time'  => (string)$event->time,
                            'event' => (string)$event->event,
                            'value' => $value,
                            'id'    => (string)$event->id,
                        );

            DB::mysql()->insert('qq_run_event',$newEvent);

        }



        DB::mysql()->update('qq_server_payload',
                            array(
                                    'flag_processed' => 1,
                                    'qq_run_id'      => $qq_run_id,
                                ),
                            array('qq_server_payload_id'=>$qq_server_payload_id)
                        );



        return $qq_run_id;

    }


    static function getLastRuns($qq_server_id,$num_runs=30){
        $query = DB::mysql()->query("SELECT *
                                       FROM qq_run
                                      WHERE qq_server_id = ?
                                      ORDER BY qq_run_id DESC
                                      LIMIT ? ", array($qq_server_id,$num_runs)
                                    );
        $Runs = array();

        while($runObject = $query->fetch()){
            $Runs[] = new phpQQrun($runObject);
        }

        return $Runs;

    }

    static function getRun($qq_server_id,$qq_run_id){

        $query = DB::mysql()->query("SELECT *
                                       FROM qq_run
                                      WHERE qq_server_id = ?
                                        AND qq_run_id = ?
                                      ORDER BY qq_run_id DESC ", array($qq_server_id, $qq_run_id)
                                    );


        if($runObject = $query->fetch()){
            return new phpQQrun($runObject);
        }else{
            return false;
        }

    }

    static function getRunEvents($qq_server_id,$qq_run_id){

        $query = DB::mysql()->query("SELECT *
                                       FROM qq_run r
                                       JOIN qq_run_event e using(qq_run_id)
                                      WHERE r.qq_server_id = ?
                                        AND r.qq_run_id = ?
                                      ORDER BY qq_run_id DESC", array($qq_server_id, $qq_run_id)
                                    );


        return $query->fetchAll();
    }


    static function getServers(){
        $query = DB::mysql()->query("SELECT * FROM qq_server");

        if($servers = $query->fetchAll()){
            return $servers;
        }else{
            return array();
        }

    }


    static function _checkServerExists($key){

        $check = DB::mysql()->query("SELECT qq_server_id FROM qq_server WHERE api_key = ? ",array($key));
        if($server = $check->fetch()){
            return $server->qq_server_id;
        }else{
            return false;
        }
    }

}