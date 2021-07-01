<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('extern_id', 15)->nullable();
            $table->string('email', 15)->index();
            $table->string('title', 15)->nullable();
            $table->string('initials', 15)->nullable();
            $table->string('first_name', 25)->nullable();
            $table->string('middle_name', 25)->nullable();
            $table->string('last_name', 45);
            $table->string('attn', 45)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('mobile', 25)->nullable();
            $table->string('address', 45)->nullable();
            $table->string('housenumber', 15)->nullable();
            $table->string('housenumber_addition', 15)->nullable();
            $table->string('postal_code', 7)->nullable();
            $table->string('city', 45)->nullable();
            $table->date('dob')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
}