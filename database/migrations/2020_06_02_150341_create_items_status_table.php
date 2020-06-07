<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_status', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id')->constrained('items');
            $table->integer('status_id')->constrained('status');
            $table->timestamp('created_at')->nullable();
            $table->integer('created_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_bridges');
    }
}
