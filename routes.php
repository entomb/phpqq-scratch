<?php
    use phpQQserver as QQserver;
    use phpQQadmin as QQadmin;


    /**
     * middleware for API requests
     */
    function APIrequest(){
        $app = \Slim\Slim::getInstance();
        $app->view(new \JsonApiView());
        $app->add(new \JsonApiMiddleware());
    }

    /**
     * middleware for HTML requests
     */
    function HTMLrequest(){
        $app = \Slim\Slim::getInstance();
        $app->view(new \Slim\View());

        QQadmin::$app = &$app;
    }


    /**
     * HTML ROUTES
     */
    $app->get('/(admin)', 'HTMLrequest', function() use ($app) {
        $app->view(new \Slim\View());

        QQadmin::call('welcome');
    });

    $app->get('/admin/servers', 'HTMLrequest', function() use ($app) {
        $app->view(new \Slim\View());

        QQadmin::call('servers');
    });

    $app->get('/admin/:key(/:method)', 'HTMLrequest',function($key=0,$method="detail") use ($app){

        $app->view(new \Slim\View());

        QQadmin::$app = &$app;
        QQadmin::call($method,$key);
    });




    /**
     * API ROUTES
     */

    $app->get('/api', 'APIrequest', function() use ($app) {
        $app->render(200,array(
                        'msg'     => 'Welcome to phpQQ server',
                        'version' => QQserver::$version,
                    )
                );
    });

    $app->post('/api/log(/:key)','APIrequest', function($key=null) use ($app){
        if($key){

             if($qq_server_id = QQserver::_checkServerExists($key)){

                $payload = $app->request()->getBody();

                if($id_payload = QQserver::log($qq_server_id,$payload)){
                    $app->render(200,array(
                            'msg' => "payload saved",
                            'id_payload' => $id_payload,
                            'key'        => $key
                        )
                    );
                }else{
                    $app->render(500,array(
                            'msg' => "error saving payload.",
                            'key' => $key,
                            'error' => true,
                        )
                    );
                }
            }else{
               $app->render(404,array(
                        'msg' => "server not found for that key",
                        'key' => $key,
                        'error' => true,
                    )
                );
            }

        }else{
            $app->render(400,array(
                'msg' => "no server key specified",
                'error' => true,
                )
            );
        }

    });

    $app->get('/api/log(/:key)','APIrequest',function($key=null) use ($app){
        $app->render(400,array(
                'msg' => "/log accepts only POST requests",
                'error' => true,
            )
        );
    });

    $app->get('/api/runs(/:key)','APIrequest',function($key=null) use ($app){
        if($qq_server_id = QQserver::_checkServerExists($key)){

            if($runs=QQserver::getLastRuns($qq_server_id,30)){
                $app->render(200,array(
                        'msg'  => "fetching last 30 runs",
                        'key'  => $key,
                        'data' => $runs,
                    )
                );
            }else{
                $app->render(500,array(
                        'msg' => "error fetching runs",
                        'key' => $key,
                        'error' => true,
                    )
                );
            }
        }else{
            $app->render(404,array(
                        'msg' => "server not found for that key",
                        'key' => $key,
                        'error' => true,
                    )
                );
        }
    });

    $app->get('/api/process(/:key(/:id))','APIrequest',function($key=null,$id=null) use ($app){

        if($qq_server_id = QQserver::_checkServerExists($key)){

            if($id){
                $qq_run = QQserver::processPayload($id);
            }elseif($key){
                $qq_run = QQserver::process($qq_server_id);
            }else{
                 $app->render(404,array(
                        'msg' => "server not found for that key",
                        'key' => $key,
                        'error' => true,
                    )
                );
            }

            if($qq_run){
                $app->render(200,array(
                            'msg' => "Processing done",
                            'key' => $key,
                            'qq_run' => $qq_run,
                            'error'  => false,
                        )
                    );
            }elseif($qq_run===0){
                 $app->render(200,array(
                            'msg' => "Nothing to process",
                            'key' => $key,
                            'error' => false,
                        )
                    );
            }else{
                $app->render(500,array(
                            'msg' => "error processing payload.",
                            'key' => $key,
                            'error' => true,
                        )
                    );
            }
        }else{
            $app->render(404,array(
                        'msg' => "server not found for that key",
                        'key' => $key,
                        'error' => true,
                    )
                );
        }

    });