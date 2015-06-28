<?php namespace Void\Match\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMatchesTable extends Migration
{

    public function up()
    {
        Schema::create('matches', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('type');
            $table->string('week_limit');
            $table->string('min_pages')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matches');
    }

}
