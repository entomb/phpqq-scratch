<?php


Class DB{

    static $mysql = false;

    static function mysql($config=null){
        if(self::$mysql){
            return self::$mysql;
        }else{
            self::$mysql = new Slim_OBJ_mysql($config);
        }

        return self::$mysql;
    }

}


Class Slim_OBJ_mysql extends OBJ_mysql{

    final function _displayError($e){
        $app = \Slim\Slim::getInstance();
        $app->render(500,array(
                'error' => true,
                'msg'   => 'unexpected mysql error',
                'e' => $e,
            )
        );
    }
}