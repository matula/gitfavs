<?php

class Githubstar extends \Eloquent {
    protected $table = 'github_stars';
	protected $fillable = ['user_id', 'repo_id', 'type'];
    public $timestamps = false;
}