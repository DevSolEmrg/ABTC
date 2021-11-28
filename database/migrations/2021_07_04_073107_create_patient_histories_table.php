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
            $table->foreignId('patient_id')->constrained('patients');
            $table->dateTime('date_of_incident');
            $table->text('place_of_incident');
            $table->dateTime('date_of_physical_exam');
            $table->text('place_of_physical_exam');
            $table->enum('type_of_animal', ['PD', 'PC']);
            $table->enum('type_of_exposure', ['B', 'NB']);
            $table->json('site_of_infection')->nullable();
            $table->boolean('is_washed')->default(true);
            $table->string('route');
            $table->enum('category', ['1', '2', '3']);
            $table->enum('outcome', ['C', 'INC', 'N', 'D']);
            $table->enum('biting_animal_status', ['ALIVE', 'DEAD', 'LOST']);
            $table->text('remarks');
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
