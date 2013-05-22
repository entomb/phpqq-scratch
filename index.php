<?php
    require 'vendor/autoload.php';


    $app = new \Slim\Slim(array('debug' => false));

    //load static routes
    require 'server/phpQQserver.php';
    require 'server/phpQQadmin.php';
    require 'server/phpQQrun.php';
    require 'server/DB.php';


    DB::mysql(array(
                'hostname' => '127.0.0.1',
                'username' => 'root',
                'password' => 'pass',
                'database' => 'qqserver',
                'echo_on_error' => false,
                'exit_on_error' => true,
            )
        );


    require 'routes.php';

    $app->run();
?>