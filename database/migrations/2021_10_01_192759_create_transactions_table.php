<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
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
            $table->string('ref_no')->nullable();
            $table->string('trx_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('source_id')->nullable();
            $table->decimal('trx_amount', 20, 2)->nullable();
            $table->enum('type', ['income', 'expense'])->nullable();
            $table->text('description')->nullable();
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
}
