<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id');
            $table->date('date');
            $table->text('place');
            $table->enum('type_of_animal', ['PD', 'PC']);
            $table->enum('type', ['B', 'NB']);
            $table->enum('body_parts', ['R FOOT', 'L LEG', 'L ARM', 'L HAND', 'R LEG', 'BUTTOCKS', 'R HAND']);
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
        Schema::dropIfExists('patient_histories');
    }
}
