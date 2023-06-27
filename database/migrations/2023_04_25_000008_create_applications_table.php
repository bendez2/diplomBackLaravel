<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('type_applications')->onDelete('cascade');
            $table->string('text');
            $table->string('location');
            $table->timestamp('executiontime');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->string('comment');
            $table->timestamp('closetime');
            $table->integer('initiator_id')->unsigned();
            $table->foreign('initiator_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('historyexecutor');
            $table->timestamp('startwork');
            $table->integer('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
