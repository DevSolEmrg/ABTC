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
            // $table->id();
            // $table->foreignId('patient_id')->constrained('patients');
            // $table->dateTime('date_of_incident');
            // $table->text('place_of_incident');
            // $table->dateTime('date_of_physical_exam');
            // $table->text('place_of_physical_exam');
            // $table->enum('type_of_animal', ['PD', 'PC']);
            // $table->enum('type_of_exposure', ['B', 'NB']);
            // $table->json('site_of_infection')->nullable();
            // $table->boolean('is_washed')->default(true);
            // $table->string('route');
            // $table->enum('category', ['1', '2', '3']);
            // $table->enum('outcome', ['C', 'INC', 'N', 'D']);
            // $table->enum('biting_animal_status', ['ALIVE', 'DEAD', 'LOST']);
            // $table->text('remarks');
            // $table->timestamps();
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->cascadeOnDelete();
            $table->integer('registration_number')->nullable();
            $table->dateTime('registration_date')->nullable();
            $table->integer('age_of_patient')->nullable();
            $table->dateTime('date_of_incident');
            $table->text('place_of_incident');
            $table->dateTime('date_of_physical_exam')->nullable();
            $table->text('place_of_physical_exam')->nullable();

            $table->unsignedBigInteger('type_of_animal_id')->nullable();
            $table->foreign('type_of_animal_id')->references('id')->on('references')->cascadeOnDelete();

            $table->unsignedBigInteger('type_of_exposure_id')->nullable();
            $table->foreign('type_of_exposure_id')->references('id')->on('references')->cascadeOnDelete();

            $table->json('site_of_infection_id')->nullable();

            $table->boolean('is_washed')->nullable()->default(true);

            $table->dateTime('rig_date_given')->nullable();
            $table->string('route')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('references')->cascadeOnDelete();

            $table->unsignedBigInteger('outcome_id')->nullable();
            $table->foreign('outcome_id')->references('id')->on('references')->cascadeOnDelete();

            $table->unsignedBigInteger('biting_animal_status_id')->nullable();
            $table->foreign('biting_animal_status_id')->references('id')->on('references')->cascadeOnDelete();

            $table->longText('doctors_order')->nullable();
            $table->longText('nurses_notes')->nullable();

            $table->longText('remarks')->nullable();
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
