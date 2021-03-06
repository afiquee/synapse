<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('state_id')->nullable()->constrained('states');
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
        Schema::dropIfExists('customers');
    }
}
