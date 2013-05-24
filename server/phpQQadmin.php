<?php

use phpQQserver as QQ;

Class phpQQadmin{

    static $app;
    static $qq_server_id;


    static function run($key,$qq_run_id=false){

        $Run    = QQ::getRun(self::$qq_server_id,$qq_run_id);
        $Events = QQ::getRunEvents(self::$qq_server_id,$qq_run_id);



        self::$app->render('run.tpl',array(
                                'key'       => $key,
                                'qq_run_id' => $qq_run_id,
                                'Run'       => $Run,
                                'Events'    => $Events,
                            ));
    }

    static function detail($key){

        $lastRuns = QQ::getLastRuns(self::$qq_server_id);

        self::$app->render('detail.tpl',array(
                                'key'  => $key,
                                'lastRuns' => $lastRuns,
                            ));
    }


    static function servers(){

        $Servers = QQ::getServers();

        self::$app->render('servers.tpl',array('servers' => $Servers));

    }


    static function welcome(){


        self::$app->render('welcome.tpl');
    }




    static function call($method,$key=null,$id=null){

        if($key){
            self::$qq_server_id = QQ::_checkServerExists($key);
        }

        self::$app->render('_header.tpl');
        self::$method($key,$id);
        self::$app->render('_footer.tpl');
    }

}