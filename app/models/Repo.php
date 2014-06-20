<?php

class Repo extends \Eloquent {
    protected $table = 'repos';
	protected $fillable = ['user_id', 'name'];
    public $timestamps = false;
}