<?php



Class phpQQadmin{

    static $app;
    static $qq_server_id;


    static function detail($key){

        $lastRuns = phpQQserver::getLastRuns(self::$qq_server_id);

        self::$app->render('detail.tpl',array(
                                'key'  => $key,
                                'lastRuns' => $lastRuns,
                            ));
    }


    static function servers(){

        $Servers = phpQQserver::getServers();

        self::$app->render('servers.tpl',array('servers' => $Servers));

    }


    static function welcome(){


        self::$app->render('welcome.tpl');
    }




    static function call($method,$key=null){

        if($key){
            self::$qq_server_id = phpQQserver::_checkServerExists($key);
        }

        self::$app->render('_header.tpl');
        self::$method($key);
        self::$app->render('_footer.tpl');
    }

}