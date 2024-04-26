<?php

$GLOBALS['config'] = array(

    'app' => array(
        'name' => 'AppName',
    ),

    'mysql' => array(
        'host'          => '127.0.0.1',
        'username'      => 'root',
        'password'      => '',
        'db_name'        => 'test_assignment'
    ),

    'password' => array(
        'algo_name' => PASSWORD_DEFAULT,
        'cost'      => 10,
        'salt'      => 50,
    ),
    
    'session'   => array(
        'session_name'  => 'user',
    )
);
