<?php


Route::get('/', 'GitfavController@process');

Route::get('list/{username}', 'GitfavController@repolist');

