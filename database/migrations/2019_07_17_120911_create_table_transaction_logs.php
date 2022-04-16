<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTransactionLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transaction_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('subscriber_name', 200);
            $table->string('subscriber_email', 200);
            $table->string('order_id', 200)->unique()->nullable();
            $table->string('txn_id', 200)->unique()->nullable();
            $table->string('amount', 10);
            $table->string('payment_gateway', 200);
            $table->enum('payment_status', ['processing', 'completed', 'cancelled', 'failed', 'refund']);
            $table->string('subscription_type', 250)->nullable();//['monthly', 'yearly']
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
        Schema::dropIfExists('payment_transaction_logs');
    }
}
