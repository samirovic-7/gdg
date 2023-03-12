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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('transaction_collection')->nullable();
            $table->integer('trans_no');
            $table->integer('folio_id');
            $table->integer('res_id');
            $table->foreignId('room_id')->constrained();
            $table->date('hotel_date');
            $table->date('sys_date');
            $table->foreignId('ledger_id')->constrained()->nullable();
            $table->integer('payment_type_id')->nullable();
            $table->double('charge_amount')->nullable();
            $table->double('charge_without_taxes')->nullable();
            $table->double('payment_amount')->nullable();
            $table->integer('window_id')->nullable();
            $table->string('trans_type');
            $table->string('recd_type');
            $table->integer('ref_id');
            $table->string('description');
            $table->boolean('is_reservation');
            $table->UnsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->boolean('is_void');
            $table->integer('invoice_id');
            $table->UnsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->boolean('inc');
            $table->softDeletes();
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
        Schema::dropIfExists('transactions');
    }
};
