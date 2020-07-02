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
            $table->foreignId('order_id')->constrained('orders');
            $table->string('category');
            $table->string('type')->nullable();
            $table->string('keyring')->nullable();
            $table->string('heatpress')->nullable();
            $table->string('shape')->nullable();
            $table->integer('quantity');
            $table->string('value');
            $table->string('tracking_no')->nullable();
            $table->string('fileupload')->nullable();
            $table->string('active_status')->default('A');
            $table->timestamp('created_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('updated_at')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamp('deleted_at')->nullable();
            $table->foreignId('deleted_by')->nullable()->constrained('users');
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
