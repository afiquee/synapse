<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->constrained('orders');
            $table->string('type');
            $table->string('shape');
            $table->integer('quantity');
            $table->string('value');
            $table->string('active_status')->default('A');
            $table->timestamp('created_at')->nullable();
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
        Schema::dropIfExists('items');
    }
}
