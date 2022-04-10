<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id');
            $table->string('name');
            $table->date('start_date');
            $table->unsignedInteger('period');
            $table->time('take_time')->nullable()->default(NULL);
            $table->string('dose')->nullable()->default(NULL);
            $table->boolean('every_day')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('prescription_id')->on('prescriptions')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drugs');
    }
}
