<?php

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

ini_set('xdebug.var_display_max_depth', 100);
ini_set('xdebug.var_display_max_children', 1006);
ini_set('xdebug.var_display_max_data', 5024);

Log::useFiles(storage_path().'/logs/laravel.log');

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

App::error(function(RuntimeException $e)
{
    return print_r($e->getMessage(), true) ;
});

App::down(function()
{
	return Response::make("Be right back!", 503);
});

require app_path().'/filters.php';
