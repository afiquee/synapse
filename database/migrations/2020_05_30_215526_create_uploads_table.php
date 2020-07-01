<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->string('filename');
            $table->string('location');
            $table->string('active_status')->default('A');
            $table->timestamp('created_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('updated_at')->nullable();
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamp('deleted_at')->nullable();
            $table->foreignId('deleted_by')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploads');
    }
}
