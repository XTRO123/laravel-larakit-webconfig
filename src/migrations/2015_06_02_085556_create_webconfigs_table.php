<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWebconfigsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(
            'webconfigs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code');
                $table->dateTime('value_date');
                $table->text('value_text');
                $table->double('value_digit');
                $table->timestamps();
            }
        );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('webconfigs');
    }

}
