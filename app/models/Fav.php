<?php

class Fav extends \Eloquent {
    protected $table = 'favs';
	protected $fillable = ['user_id', 'repo_id', 'score'];
    public $timestamps = false;
}