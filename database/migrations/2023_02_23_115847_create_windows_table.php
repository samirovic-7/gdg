<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('windows', function (Blueprint $table) {
            $table->foreignId('guest_id')->constrained();
            $table->bigInteger('window_number')->unsigned();
            $table->string('window_name',50);
            $table->string('invoice_number');
            $table->timestamps();
            $table->primary(['guest_id','window_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('windows');
    }
};
