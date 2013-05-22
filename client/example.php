<?php

    include("class/phpQQclient.php");
    include("class/phpQQrun.php");

    use phpQQclient as QQ;

    QQ::start('http://qq-server.localhost/','ab045a04c73f32ae92f3b0690ed98aeb');

    QQ::event('test','qq',1);
    QQ::event('test','qq',2);
    sleep(1);
    QQ::event('test','qq',3);

    QQ::block('for');
    $k_times = rand(5,10);
    $l_times = rand(5,10);

    QQ::event('ktimes',$k_times);
    QQ::event('ltimes',$l_times);

    for($k=0;$k<$k_times;$k++){
        for($l=0;$l<$l_times;$l++){
            echo $l;
        }
        QQ::event('sleep',1);
        echo "\n";
       $x++; //first time is going to trow a warning
       usleep(rand(1000,500000));
    }
    QQ::event('xvalue',$x);
    QQ::block('for',false);

    QQ::close();

?>