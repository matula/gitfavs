<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('favs', function($table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('repo_id')->unsigned();
            $table->integer('score')->nullable()->unsigned();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('favs');
	}

}
