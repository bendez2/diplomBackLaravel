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
        Schema::create('type_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('name_applicationsid')->unsigned();
            $table->foreign('name_applicationsid')->references('id')->on('name_applications')->onDelete('cascade');;
            $table->string('sla');
            $table->integer('prioritiesid')->unsigned();
            $table->foreign('prioritiesid')->references('id')->on('priorities')->onDelete('cascade');
            $table->integer('sladay');
            $table->integer('slahours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_applications');
    }
};
