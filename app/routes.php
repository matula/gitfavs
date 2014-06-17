<?php

Route::get('/', function()
{
    $client = new \Github\Client();
    $follows = $client->api('user')->following('matula');
    $results = [];
    foreach($follows as $follow) {
        $stars = $client->api('user')->starred($follow['login']);
        foreach($stars as $star) {
            $results[$follow['login']][] = $star['full_name'];
        }
    }

    dd($results);
});
