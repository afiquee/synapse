<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('quantity');
            $table->string('value');
            $table->integer('created_by')->nullable()->constrained('users');
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->nullable()->constrained('users');
            $table->timestamp('deleted_at')->nullable();
            $table->integer('deleted_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
